import os
import sys
from PyPDF2 import PdfReader

def extract_images_from_pdf(pdf_path, output_dir):
    os.makedirs(output_dir, exist_ok=True)
    count = 1
    
    try:
        reader = PdfReader(pdf_path)
        print(f"⏳ Membaca {pdf_path} dengan PyPDF2...")
        
        for i, page in enumerate(reader.pages):
            for image_file_object in page.images:
                # Limit size to ignore small vector paths/icons
                if len(image_file_object.data) > 15000:  # > 15KB
                    filename = f"gambar_menu_{count}.{image_file_object.name.split('.')[-1]}"
                    # Sometimes names don't have extension
                    if '.' not in filename:
                        filename += ".jpg"
                        
                    out_path = os.path.join(output_dir, filename)
                    with open(out_path, "wb") as f:
                        f.write(image_file_object.data)
                    count += 1
                    
        print(f"✅ Selesai! {count-1} gambar berhasil diekstrak ke folder: {output_dir}")
        print("💡 TIP: Kamu bisa klik kanan file-file itu dan rename sesuai ID menu untuk diupload sekaligus.")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == '__main__':
    if len(sys.argv) < 2:
        print("Usage: python extract_images.py path/to/menu.pdf")
        sys.exit(1)
        
    pdf_path = sys.argv[1]
    output_dir = "public/images/menu_extracted"
    extract_images_from_pdf(pdf_path, output_dir)
