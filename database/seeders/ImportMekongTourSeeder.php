<?php

use App\Models\Tour;
use Illuminate\Support\Str;

$tour = Tour::create([
    'title' => 'Cruising the Mekong & Angkor Wat',
    'slug' => Str::slug('Cruising the Mekong & Angkor Wat'),
    'price' => '$10,995',
    'duration_days' => 13,
    'destinations_count' => 6,
    'max_guests' => '24 Guests Max',
    'countries' => 'Thailand, Cambodia, Vietnam',
    'overview_heading' => 'The Mother of Waters.',
    'overview_desc' => '<p>Regarded as the Mother of Waters, the Mekong River is a nurturing source of life and sustenance for millions who live along its banks. Begin in bustling, electric Bangkok before continuing to Cambodia to see the astonishing ruins of Angkor Wat. Then join an exclusively chartered cruise through the lower reaches of the Mekong in Cambodia and Vietnam, exploring rural villages little visited by Western travellers and encountering history in Ho Chi Minh City, the former Saigon.</p>',
    'is_published' => true,
    'highlights_heading' => 'What awaits you.',
    'differences_heading' => 'Why Choose an A&K Small Group Journey?',
    'inclusions_heading' => 'Every detail, handled.',
    'accommodations_heading' => 'Landmark hotels, and a river all your own.',
    'additional_infos_heading' => 'Additional information.',
]);

$highlights = [
    "Cruise for seven nights on an exclusive charter of the 24-guest Mekong Princess, a luxurious, all-suite boutique riverboat able to reach lesser-known ports and authentic rural cultures.",
    "In Siem Reap, devote nearly two days to exploring Cambodia's iconic temples — Angkor Thom, Bayon and Ta Prohm — with an expert local guide, and watch the sun rise over Angkor Wat.",
    "Meet local villagers and families in their homes and monks in pagodas, connecting with Southeast Asia's varied, intertwined river cultures in authentic and deeply personal ways.",
    "Cruise into the heart of old Saigon and choose from an array of active, cultural and culinary options revealing the diverse appeal of today's Ho Chi Minh City."
];

foreach ($highlights as $i => $h) {
    $tour->highlights()->create([
        'content' => '<li>' . $h . '</li>',
        'sort_order' => $i
    ]);
}

$differences = [
    "English-speaking Resident Tour Directors",
    "Small group sizes",
    "Authentic experiences shaped by local knowledge",
    "The best luxury accommodations in every destination",
    "Private transfers and dedicated service ensure a seamless travel experience",
    "Guaranteed departures with a minimum of two guests"
];

foreach ($differences as $i => $d) {
    $tour->differences()->create([
        'content' => '<li>' . $d . '</li>',
        'sort_order' => $i
    ]);
}

$inclusions = [
    "Travelling Bell Boy® bag transfer service",
    "English-speaking Resident Tour Director® & local guides",
    "Airport meet-and-greet with private transfers",
    "Mid-journey Traveller's Valet® laundry service",
    "Internet access",
    "Daily breakfast, along with many meals",
    "Entrance fees, taxes and gratuities (except Resident Tour Director)",
    "Round-the-clock, on-call support from our travel experts",
    "Internal air included — economy class, an $800 value (Bangkok / Siem Reap)"
];

foreach ($inclusions as $i => $inc) {
    $tour->inclusions()->create([
        'content' => '<li>' . $inc . '</li>',
        'sort_order' => $i
    ]);
}

$accommodations = [
    ['hotel_name' => "Sofitel Legend Metropole Hanoi", 'description' => "A French colonial landmark hosting ambassadors, writers and statesmen for more than 100 years. 358 rooms and suites, three restaurants, three bars, a Jacuzzi, sauna, spa and fitness center."],
    ['hotel_name' => "The Reverie Saigon", 'description' => "Perched atop the Times Square Building in District 1. 286 eclectic rooms and suites, five restaurants, a pool, fitness center, salon and spa."],
    ['hotel_name' => "Raffles Grand Hotel d'Angkor", 'description' => "A historic fixture of Siem Reap's French Quarter since 1932, among 15 acres of gardens five miles from Angkor Wat. 119 Art Deco rooms and suites, five restaurants and bars, and a spa."],
    ['hotel_name' => "Mekong Princess", 'description' => "Recalling the romance of a bygone era with a gracious staff and elegant French colonial decor. 12 tranquil suites overlook the river from private verandas or Juliet balconies; an observation deck, dining room, lounge, library, spa and gym on board."]
];

foreach ($accommodations as $i => $acc) {
    $tour->accommodations()->create([
        'hotel_name' => $acc['hotel_name'],
        'description' => $acc['description'],
        'sort_order' => $i
    ]);
}

$additional_infos = [
    "Guaranteed to depart with a minimum of two guests",
    "Small group journey with expert local guides throughout",
    "English is the official onboard language of the Mekong Princess",
    "Wi-Fi available in common areas on board"
];

foreach ($additional_infos as $i => $info) {
    $tour->additionalInfos()->create([
        'content' => '<li>' . $info . '</li>',
        'sort_order' => $i
    ]);
}

echo "Tour created successfully!";
