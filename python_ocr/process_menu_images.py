import json
import os
import glob
from PIL import Image

menus_path = "database/data/menus.json"
output_images_dir = "public/images"
extracted_dir = "public/images/menu_extracted"

os.makedirs(output_images_dir, exist_ok=True)

with open(menus_path, "r", encoding="utf-8") as f:
    menus = json.load(f)

print(f"Total Menus: {len(menus)}")

# Convert all valid images from menu_extracted to public/images
extracted_files = glob.glob(f"{extracted_dir}/*")
print(f"Found {len(extracted_files)} files in {extracted_dir}")

food_images = []
for f in extracted_files:
    ext = os.path.splitext(f)[1].lower()
    base = os.path.splitext(os.path.basename(f))[0]
    # Try opening with PIL
    try:
        with Image.open(f) as img:
            # We want actual item photos: width >= 150 and height >= 150, aspect ratio not too extreme
            ratio = max(img.width, img.height) / min(img.width, img.height)
            if img.width >= 150 and img.height >= 150 and ratio <= 3.5:
                out_name = f"{base}.jpg"
                out_path = os.path.join(output_images_dir, out_name)
                rgb = img.convert('RGB')
                rgb.save(out_path, "JPEG", quality=85)
                food_images.append(out_name)
    except Exception as e:
        pass

print(f"Total clean food photos ready: {len(food_images)}")

# Map images to menus based on keywords or sequentially ensuring every menu has an image
# Keyword-based mapping for top favorites
keyword_map = {
    'pempek': ['gambar_menu_1.jpg', 'page_1_img_1_Im19.jpg', 'page_1_img_2_Im66.jpg'],
    'tekwan': ['page_1_img_3_Im65.jpg', 'page_1_img_4_Im74.jpg'],
    'model': ['page_1_img_5_Im73.jpg'],
    'dimsum': ['page_2_img_2_Im222.jpg', 'page_2_img_3_Im221.jpg'],
    'sup': ['page_2_img_4_Im230.jpg', 'page_2_img_5_Im229.jpg'],
    'telur': ['page_2_img_6_Im237.jpg'],
    'iga': ['page_3_img_4_Im336.jpg', 'page_3_img_5_Im335.jpg'],
    'nasi': ['page_3_img_6_Im344.jpg', 'page_3_img_7_Im343.jpg', 'page_3_img_8_Im352.jpg', 'page_3_img_9_Im351.jpg'],
    'spaghetti': ['page_4_img_2_Im441.jpg', 'page_4_img_3_Im440.jpg', 'page_4_img_7_Im456.jpg'],
    'pasta': ['page_4_img_8_Im465.jpg', 'page_4_img_9_Im464.jpg'],
    'wings': ['page_5_img_4_Im638.jpg', 'page_5_img_5_Im637.jpg'],
    'tempe': ['page_5_img_6_Im646.jpg', 'page_5_img_7_Im645.jpg'],
    'kopi': ['page_5_img_8_Im654.jpg', 'page_5_img_9_Im653.jpg', 'page_5_img_10_Im662.jpg', 'page_5_img_11_Im661.jpg'],
    'shake': ['page_4_img_11_Im472.jpg', 'page_4_img_13_Im480.jpg', 'page_1_img_13_Im111.jpg'],
    'tea': ['page_1_img_10_Im104.jpg', 'page_1_img_11_Im103.jpg'],
    'latte': ['page_5_img_8_Im654.jpg', 'page_5_img_9_Im653.jpg'],
    'lemonade': ['page_1_img_10_Im104.jpg'],
}

assigned_count = 0
for idx, m in enumerate(menus):
    name_lower = m['name'].lower()
    cat_lower = m['category'].lower()
    sub_lower = (m.get('sub_category') or '').lower()
    
    assigned_img = None
    # Check keywords
    for kw, img_list in keyword_map.items():
        if kw in name_lower or kw in sub_lower:
            # pick valid existing image
            for candidate in img_list:
                if os.path.exists(os.path.join(output_images_dir, candidate)):
                    assigned_img = candidate
                    break
        if assigned_img:
            break
            
    # Fallback to cyclic assignment from food_images pool
    if not assigned_img and food_images:
        assigned_img = food_images[idx % len(food_images)]
        
    m['image'] = assigned_img
    assigned_count += 1

with open(menus_path, "w", encoding="utf-8") as f:
    json.dump(menus, f, indent=4, ensure_ascii=False)

print(f"SUCCESS: Successfully linked images to all {assigned_count} menus in {menus_path}!")
