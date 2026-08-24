import os
import re
import glob

# Image mapping dictionary based on keywords in the ph-label
image_map = {
    "angkor wat": "angkor_wat_hq.jpg",
    "siem reap": "siem_reap_hq.jpg",
    "mekong": "mekong_cruise_hq.jpg",
    "epic voyage": "epic_voyage_hq.jpg",
    "private tours": "private_tours_hq.jpg",
    "hanoi": "hanoi_hq.jpg",
    "ho chi minh": "ho_chi_minh_hq.jpg",
    "luang prabang": "luang_prabang_hq.jpg",
    "bangkok": "bangkok_hq.jpg",
    "tented camp": "tented_camp_hq.jpg",
    "family": "family_travel_hq.jpg",
    "bespoke": "bespoke_travel_hq.jpg",
    "at sea": "hero_landscape_hq.jpg",
    "ha long bay": "hero_landscape_hq.jpg",
    "purpose": "hero_landscape_hq.jpg",
    "our values": "tented_camp_hq.jpg",
    "thailand, in full": "bangkok_hq.jpg",
    "under canvas": "tented_camp_hq.jpg",
    "icons of southeast asia": "angkor_wat_hq.jpg",
    "thailand family adventure": "family_travel_hq.jpg",
    "ultimate thailand adventure": "bangkok_hq.jpg",
    "small group tours": "hero_landscape_hq.jpg"
}

hero_map = {
    "angkor-wat-and-icons-of-southeast-asia.html": "angkor_wat_hq.jpg",
    "cruising-the-mekong-and-angkor-wat.html": "mekong_cruise_hq.jpg",
    "epic-voyage-around-southeast-asia.html": "epic_voyage_hq.jpg",
    "luxury-tented-camps-of-southeast-asia.html": "tented_camp_hq.jpg",
    "private-tours.html": "private_tours_hq.jpg",
    "small-group-tours.html": "hero_landscape_hq.jpg",
    "thailand-family-adventure.html": "family_travel_hq.jpg",
    "ultimate-thailand-adventure.html": "bangkok_hq.jpg",
    "about.html": "tented_camp_hq.jpg",
    "contact.html": "bespoke_travel_hq.jpg",
}

def get_best_image(label):
    label_lower = label.lower()
    for key, img in image_map.items():
        if key in label_lower:
            return img
    return "hero_landscape_hq.jpg" # fallback

html_files = glob.glob("*.html")

for file in html_files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Replace Hero background if applicable
    if file in hero_map:
        hero_img = hero_map[file]
        # Find <section class="detail-hero"> or <section class="page-hero">
        content = re.sub(
            r'<section class="(detail-hero|page-hero)">',
            f'<section class="\\1" style="background-image: linear-gradient(180deg, rgba(10,55,51,0.85), rgba(15,92,87,0.95)), url(\'assets/images/{hero_img}\')">',
            content
        )

    # 2. Replace <div class="ph ..."><span class="ph-label">LABEL</span></div>
    def replacer(match):
        full_tag = match.group(0)
        classes = match.group(1)
        style = match.group(2) if match.group(2) else ""
        label = match.group(3)
        img_src = get_best_image(label)

        if "stay-thumb" in classes:
             return f'<div class="card-image-wrap ratio-1-1 stay-thumb"><img src="assets/images/{img_src}" alt="{label}"></div>'
        elif "ratio-4-5" in classes:
             # This is usually a card image
             return f'<div class="card-image-wrap ratio-4-5"><img src="assets/images/{img_src}" alt="{label}"></div>'
        elif "ratio-16-9" in classes:
             # Wide block image
             return f'<img src="assets/images/{img_src}" alt="{label}" class="reveal" style="margin-bottom:50px; width:100%; border-radius:4px; aspect-ratio:16/9; object-fit:cover;">'
        elif "split-media" in classes:
             classes = classes.replace("ph", "").strip()
             return f'<div class="card-image-wrap {classes}"><img src="assets/images/{img_src}" alt="{label}"></div>'
        else:
             return f'<div class="card-image-wrap"><img src="assets/images/{img_src}" alt="{label}"></div>'

    # Regex to match: <div class="ph CLASSES" [style="..."]><span class="ph-label">LABEL</span></div>
    content = re.sub(
        r'<div class="([^"]*\bph\b[^"]*)"(?: style="([^"]*)")?>\s*<span class="ph-label">([^<]+)</span>\s*</div>',
        replacer,
        content
    )

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

print("Images replaced successfully.")
