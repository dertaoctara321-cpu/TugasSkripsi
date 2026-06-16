#!/usr/bin/env python3
"""
extract_menu.py - Extract menu items from PDF
Strategy:
  1. Try pdfplumber text extraction (instant, best for CorelDraw/design PDFs with embedded text)
  2. If zero text found, fall back to EasyOCR (for fully rasterized/scanned PDFs)

Usage: python extract_menu.py <path_to_pdf>
Output: JSON array to stdout, debug to stderr
"""

import sys
import json
import re
import os


# ─── Price / subcategory regex ──────────────────────────────────────────────
PRICE_K_RE   = re.compile(r'\b(\d{1,3})\s*[kK]\b')
PRICE_RB_RE  = re.compile(r'\b(\d{1,3})[.,]?000\b')   # e.g. 20.000, 20000
SUBCAT_RE    = re.compile(
    r'menu\s+pakam|menu\s+sarapan|sarapan|main\s+course|'
    r'nasi\s+goreng|pasta|palembang\s+nian|snack\s+nian|'
    r'little\s+coconut|coffee|western|steak|pizza|camilan|minuman',
    re.IGNORECASE
)
SKIP_SET = {
    'menu','harga','price','rp','food','drink','tersedia',
    'little','palembang','coconut','cafe','nian','description',
    'deskripsi','available','qty','quantity',
}


def detect_category(sub_lower: str) -> str:
    if any(w in sub_lower for w in ['coconut','coffee','minum','juice','teh','es ','drink']):
        return 'Minuman'
    if any(w in sub_lower for w in ['snack','camilan']):
        return 'Camilan'
    return 'Makanan'


def price_from_text(text: str):
    """Return price in rupiah or None."""
    m = PRICE_K_RE.search(text)
    if m:
        return int(m.group(1)) * 1000
    m = PRICE_RB_RE.search(text)
    if m:
        return int(m.group(1).replace('.','').replace(',','')) * 1000
    return None


# ─── Strategy 1: pdfplumber (text-based PDF) ────────────────────────────────
def extract_with_pdfplumber(pdf_path: str):
    import pdfplumber
    from collections import defaultdict

    all_items  = []
    current_sub = ''
    total_words = 0

    with pdfplumber.open(pdf_path) as pdf:
        for page_num, page in enumerate(pdf.pages):
            raw_words = page.extract_words(x_tolerance=4, y_tolerance=4)
            if not raw_words:
                continue
            total_words += len(raw_words)
            page_h = float(page.height)

            # ── Step 1: Group words into visual rows (±8pt y tolerance) ───
            rows_dict = defaultdict(list)
            for w in raw_words:
                row_key = round(float(w['top']) / 8) * 8
                rows_dict[row_key].append(w)

            # Build sorted list of rows: (y_top, row_text, [words])
            rows = []
            for y_key in sorted(rows_dict.keys()):
                rw = sorted(rows_dict[y_key], key=lambda w: float(w['x0']))
                row_text = ' '.join(w['text'] for w in rw)
                rows.append({'y': float(y_key), 'text': row_text, 'words': rw})

            # ── Step 2: Merge price rows: '20' + 'k' on consecutive rows ──
            merged_rows = []
            i = 0
            while i < len(rows):
                r = rows[i]
                # Check if this row is a pure number and next row is 'k'/'K'
                if (i + 1 < len(rows)
                        and re.fullmatch(r'\d{1,3}', r['text'].strip())
                        and re.fullmatch(r'[kK]', rows[i+1]['text'].strip())
                        and rows[i+1]['y'] - r['y'] < 16):
                    merged = dict(r)
                    merged['text'] = r['text'].strip() + 'k'
                    merged_rows.append(merged)
                    i += 2
                    continue
                # Also merge within same row: '20' adjacent to 'k'
                new_words = []
                j = 0
                while j < len(r['words']):
                    w = r['words'][j]
                    if (j + 1 < len(r['words'])
                            and re.fullmatch(r'\d{1,3}', w['text'].strip())
                            and re.fullmatch(r'[kK]', r['words'][j+1]['text'].strip())
                            and float(r['words'][j+1]['x0']) - float(w['x1']) < 20):
                        merged_w = dict(w)
                        merged_w['text'] = w['text'].strip() + 'k'
                        new_words.append(merged_w)
                        j += 2
                        continue
                    new_words.append(w)
                    j += 1
                r['words'] = new_words
                r['text']  = ' '.join(w['text'] for w in new_words)
                merged_rows.append(r)
                i += 1
            rows = merged_rows

            # ── Step 3: Detect sub_category from top 45% of page ──────────
            # Reset per page — pages without headers get empty sub_category
            page_sub = ''
            header_zone = page_h * 0.45
            row_texts_combined = []
            for k in range(len(rows)):
                if rows[k]['y'] > header_zone:
                    break
                t = rows[k]['text']
                # 2-row sliding window to catch split headings ("menu" + "PAKAM")
                if k + 1 < len(rows) and rows[k + 1]['y'] <= header_zone:
                    t = t + ' ' + rows[k + 1]['text']
                row_texts_combined.append(t)

            for combined_t in row_texts_combined:
                if SUBCAT_RE.search(combined_t):
                    # Strip bullet numbers and noise from sub_category text
                    candidate = re.sub(r'\b\d{1,2}\.\s*', '', combined_t)
                    candidate = re.sub(r'\bFOOD\b|\bDRINK\b', '', candidate, flags=re.IGNORECASE)
                    parts = [p for p in candidate.split()
                             if p.lower() not in SKIP_SET and len(p) > 1]
                    candidate = ' '.join(parts).strip().title()
                    if len(candidate) > 3:
                        page_sub = candidate
                        break

            # Use page_sub if found, else carry over from previous page
            if page_sub:
                current_sub = page_sub

            # ── Step 4: Find price rows and assemble item names ───────────
            BULLET_RE = re.compile(r'\b\d{1,2}\.\s')  # "01. " anywhere
            NOISE_RE  = re.compile(
                r'\b\d{1,3}[kK]\b'          # stray price tokens "20k"
                r'|\b\d{5,}\b'              # long phone/barcode numbers
                r'|\brp\.?\s*\d*\b'         # "rp." "rp.20" labels
                r'|\b000\b'                 # leftover "000" from price
                r'|@\S+'                    # social media handles
                r'|#\S+'
                r'|\bRSRV\b|\bCUBO\b|\bKELAH\b|\bNIAN\b',
                re.IGNORECASE
            )
            page_items       = []
            used_row_indices = set()

            for i, row in enumerate(rows):
                price = price_from_text(row['text'])
                if price is None:
                    continue
                if price < 5000 or price > 300_000:
                    continue

                price_y = row['y']

                # ── Scan upward for item name ──────────────────────────────
                # Logic:
                #   • Normal scan: collect rows within 180pt
                #   • On bullet ("01."): strip bullet, add text, mark bullet_y
                #     then continue scanning but only up to 40pt ABOVE the bullet
                #   • Stop when hitting prev item's price or used rows
                name_parts    = []
                bullet_y      = None   # y-pos of bullet when found

                for j in range(i - 1, -1, -1):
                    r_above = rows[j]
                    vert    = price_y - r_above['y']

                    if vert > 180:
                        break    # too far above

                    # If we already passed a bullet, only look up to 40pt above it
                    if bullet_y is not None and (bullet_y - r_above['y']) > 40:
                        break

                    if vert <= 0:
                        continue

                    t = r_above['text'].strip()

                    if BULLET_RE.search(t + ' '):
                        # Extract name part after the bullet number, if any
                        after_bullet = re.sub(r'^\d{1,2}\.\s*', '', t).strip()
                        if after_bullet and len(after_bullet) >= 2 and j not in used_row_indices:
                            name_parts.append((r_above['y'], after_bullet))
                            used_row_indices.add(j)
                        bullet_y = r_above['y']   # mark boundary, continue 40pt above
                        continue

                    if j in used_row_indices:
                        continue
                    if price_from_text(t) is not None:
                        continue   # skip price rows of other items
                    if t.lower() in SKIP_SET or len(t) < 2:
                        continue
                    if SUBCAT_RE.search(t):
                        continue   # skip section headers

                    name_parts.append((r_above['y'], t))
                    used_row_indices.add(j)

                # Assemble name
                if name_parts:
                    name_parts.sort(key=lambda x: x[0])
                    raw = ' '.join(p[1] for p in name_parts)
                    raw = NOISE_RE.sub(' ', raw)
                    raw = re.sub(r'\s{2,}', ' ', raw).strip()
                    name = raw if len(raw) >= 2 else f"Item halaman {page_num + 1}"
                else:
                    name = f"Item halaman {page_num + 1}"

                page_items.append({
                    'name':         name,
                    'price':        price,
                    'sub_category': current_sub,
                    'category':     detect_category(current_sub.lower()),
                    'description':  '',
                })

            all_items.extend(page_items)
            print(f"  Page {page_num+1}: {len(rows)} rows → {len(page_items)} items  | sub='{current_sub}'",
                  file=sys.stderr, flush=True)

    print(f"pdfplumber: {total_words} words, {len(all_items)} items total.", file=sys.stderr, flush=True)
    return all_items, total_words


# ─── Strategy 2: EasyOCR fallback (image/raster PDF) ────────────────────────
def extract_with_ocr(pdf_path: str):
    import pypdfium2 as pdfium
    import numpy as np
    import easyocr

    print("Falling back to EasyOCR (PDF has no embedded text)...", file=sys.stderr, flush=True)

    doc = pdfium.PdfDocument(pdf_path)
    total_pages = len(doc)

    try:
        reader = easyocr.Reader(['id', 'en'], gpu=True, verbose=False)
        print("Using GPU.", file=sys.stderr, flush=True)
    except Exception:
        reader = easyocr.Reader(['id', 'en'], gpu=False, verbose=False)
        print("Using CPU.", file=sys.stderr, flush=True)

    all_items = []
    current_sub = ''

    for page_num in range(total_pages):
        print(f"OCR page {page_num+1}/{total_pages}...", file=sys.stderr, flush=True)
        page   = doc[page_num]
        bitmap = page.render(scale=2.0)   # higher scale = more accurate OCR
        img    = np.array(bitmap.to_pil())

        results = reader.readtext(img, detail=1, paragraph=False)
        if len(results) < 3:
            continue

        img_h = img.shape[0]
        entries = []
        for bbox, text, conf in results:
            text = text.strip()
            if conf < 0.2 or not text or len(text) < 2:
                continue
            yc = (bbox[0][1] + bbox[2][1]) / 2
            xc = (bbox[0][0] + bbox[2][0]) / 2
            entries.append({'text': text, 'y': yc, 'x': xc, 'conf': conf})
        entries.sort(key=lambda e: e['y'])

        # Detect subcategory
        header_zone = img_h * 0.35
        for e in entries:
            if e['y'] < header_zone and SUBCAT_RE.search(e['text']):
                cand = e['text'].strip().title()
                if cand.lower() not in SKIP_SET and len(cand) > 3:
                    current_sub = cand
                    break

        used  = set()
        page_items = []
        for i, e in enumerate(entries):
            price = price_from_text(e['text'])
            if price is None:
                continue
            if price < 5000 or price > 500000:
                continue

            candidates = []
            for j, above in enumerate(entries[:i]):
                if j in used:
                    continue
                vert  = e['y'] - above['y']
                horiz = abs(above['x'] - e['x'])
                if vert <= 0 or vert > 300 or horiz > 400:
                    continue
                if price_from_text(above['text']) is not None:
                    continue
                if above['text'].lower() in SKIP_SET or len(above['text']) < 2:
                    continue
                candidates.append((j, above, vert))

            if candidates:
                candidates.sort(key=lambda c: c[2])
                best_j, best_e, _ = candidates[0]
                name = best_e['text']
                used.add(best_j)
            else:
                name = f"Item halaman {page_num+1}"

            page_items.append({
                'name': name,
                'price': price,
                'sub_category': current_sub,
                'category': detect_category(current_sub.lower()),
                'description': '',
            })

        all_items.extend(page_items)
        print(f"  Page {page_num+1}: {len(page_items)} items", file=sys.stderr, flush=True)

    doc.close()
    return all_items


# ─── Main ────────────────────────────────────────────────────────────────────
def main():
    if len(sys.argv) < 2:
        print(json.dumps([]), flush=True)
        sys.exit(1)

    pdf_path = sys.argv[1]
    if not os.path.exists(pdf_path):
        print(json.dumps([]), flush=True)
        print(f"File not found: {pdf_path}", file=sys.stderr)
        sys.exit(1)

    print(f"Processing: {pdf_path}", file=sys.stderr, flush=True)

    # ── Strategy 1: pdfplumber (fast, text-based) ──
    try:
        items, total_words = extract_with_pdfplumber(pdf_path)
        if total_words > 20 and len(items) > 0:
            print(f"pdfplumber succeeded: {len(items)} items.", file=sys.stderr, flush=True)
            print(json.dumps(items, ensure_ascii=False), flush=True)
            return
        elif total_words > 20 and len(items) == 0:
            # Text found but no prices - output raw text as items for manual review
            print("Text found but no prices matched. Falling back to OCR.", file=sys.stderr, flush=True)
        else:
            print("No embedded text found. Falling back to EasyOCR.", file=sys.stderr, flush=True)
    except Exception as e:
        print(f"pdfplumber error: {e}", file=sys.stderr, flush=True)

    # ── Strategy 2: EasyOCR fallback ──
    try:
        items = extract_with_ocr(pdf_path)
        print(f"OCR completed: {len(items)} items.", file=sys.stderr, flush=True)
        print(json.dumps(items, ensure_ascii=False), flush=True)
    except Exception as e:
        print(f"OCR error: {e}", file=sys.stderr, flush=True)
        print(json.dumps([]), flush=True)


if __name__ == '__main__':
    main()
