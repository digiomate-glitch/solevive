const fs = require('fs');
const path = require('path');

const image_map = {
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
};

const hero_map = {
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
};

function getBestImage(label) {
    const lower = label.toLowerCase();
    for (const [key, img] of Object.entries(image_map)) {
        if (lower.includes(key)) {
            return img;
        }
    }
    return "hero_landscape_hq.jpg"; // fallback
}

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // 1. Replace Hero background if applicable
    if (hero_map[file]) {
        const heroImg = hero_map[file];
        content = content.replace(/<section class="(detail-hero|page-hero)">/g, 
            `<section class="$1" style="background-image: linear-gradient(180deg, rgba(10,55,51,0.85), rgba(15,92,87,0.95)), url('assets/images/${heroImg}')">`
        );
    }

    // 2. Replace placeholders
    const regex = /<div class="([^"]*\bph\b[^"]*)"(?: style="([^"]*)")?>\s*<span class="ph-label">([^<]+)<\/span>\s*<\/div>/g;
    content = content.replace(regex, (match, classes, style, label) => {
        const imgSrc = getBestImage(label);
        if (classes.includes("stay-thumb")) {
             return `<div class="card-image-wrap ratio-1-1 stay-thumb"><img src="assets/images/${imgSrc}" alt="${label}"></div>`;
        } else if (classes.includes("ratio-4-5")) {
             return `<div class="card-image-wrap ratio-4-5"><img src="assets/images/${imgSrc}" alt="${label}"></div>`;
        } else if (classes.includes("ratio-16-9")) {
             return `<img src="assets/images/${imgSrc}" alt="${label}" class="reveal" style="margin-bottom:50px; width:100%; border-radius:4px; aspect-ratio:16/9; object-fit:cover;">`;
        } else if (classes.includes("split-media")) {
             const newClasses = classes.replace(/\bph\b/g, "").trim();
             return `<div class="card-image-wrap ${newClasses}"><img src="assets/images/${imgSrc}" alt="${label}"></div>`;
        } else {
             return `<div class="card-image-wrap"><img src="assets/images/${imgSrc}" alt="${label}"></div>`;
        }
    });

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Images replaced successfully.");
