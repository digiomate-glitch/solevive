<?php

use Awcodes\Curator\Models\Media;
use App\Models\Tour;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function importImage($url, $directory) {
    $url = str_replace(' ', '%20', $url);
    $contents = @file_get_contents($url);
    if (!$contents) return null;
    
    $filename = basename(parse_url($url, PHP_URL_PATH));
    $filename = urldecode($filename);
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION) ?: 'jpg';
    $path = $directory . '/' . $filename;
    
    // Check if it already exists in media
    $existing = Media::where('path', $path)->first();
    if ($existing) return $existing->id;
    
    Storage::disk('public')->put($path, $contents);
    
    $size = strlen($contents);
    $tempFile = sys_get_temp_dir() . '/' . uniqid() . '.' . $ext;
    file_put_contents($tempFile, $contents);
    $imageInfo = @getimagesize($tempFile);
    $width = $imageInfo ? $imageInfo[0] : null;
    $height = $imageInfo ? $imageInfo[1] : null;
    $type = $imageInfo ? $imageInfo['mime'] : 'image/jpeg';
    @unlink($tempFile);

    $media = Media::create([
        'disk' => 'public',
        'directory' => $directory,
        'visibility' => 'public',
        'name' => $name,
        'path' => $path,
        'width' => $width,
        'height' => $height,
        'size' => $size,
        'type' => $type,
        'ext' => $ext,
        'alt' => $name,
        'title' => $name,
    ]);
    
    return $media->id;
}

$heroId = importImage('https://www.solvivetravel.com/assets/images/Epic%20Voyage%20Around%20Southeast-img.webp', 'tours');
$overviewId = importImage('https://www.solvivetravel.com/assets/images/ho_chi_minh_hq.jpg', 'tours');

$tour = Tour::create([
    'title' => 'An Epic Voyage Around Southeast Asia',
    'slug' => Str::slug('An Epic Voyage Around Southeast Asia'),
    'price' => '$25,995',
    'duration_days' => 16,
    'destinations_count' => 9,
    'max_guests' => '60 Guests Max',
    'countries' => 'Thailand, Vietnam, Brunei, Malaysia, Philippines',
    'hero_image' => $heroId,
    'overview_image' => $overviewId,
    'overview_heading' => 'Our deepest dive into Southeast Asia yet.',
    'overview_desc' => '<p>After an enriching pre-cruise exploration of Bangkok\'s culinary and spiritual traditions, board Crystal Serenity as our acclaimed Expedition Team and expert-led shore excursions uncover exotic destinations spanning Vietnam, Brunei, Malaysia and the Philippines — all while savoring the finest experience at sea.</p>',
    'is_published' => true,
    'highlights_heading' => 'What awaits you.',
    'differences_heading' => 'Why Choose an A&K Expedition Cruise?',
    'inclusions_heading' => 'All-inclusive, start to finish.',
    'accommodations_heading' => 'A palace on land, then a palace at sea.',
    'additional_infos_heading' => 'Additional information.',
]);

$highlights = "<ul>
<li>Kick things off in Thailand with enriching excursions and a pre-cruise stay at the iconic Mandarin Oriental, Bangkok.</li>
<li>Board Crystal Serenity's 14-day sailing from Bangkok to Hong Kong to experience the dining, entertainment, service and suites that have earned Crystal the title of \"World's Best Cruise.\"</li>
<li>Choose from a menu of included shore excursions and onboard enrichment spanning history, spiritual traditions, nature and wildlife, regional cuisines and active pursuits.</li>
<li>See how Bangkok, Ho Chi Minh City and Manila are redefining legacies once shaped by conflict and colonialism.</li>
<li>Explore the distinctive regional dishes of Thailand, Vietnam and the Philippines through exclusive culinary experiences.</li>
<li>Dig your toes into the white powder sands of Ko Kut and Boracay.</li>
<li>Encounter the palatial residence of the Sultan of Brunei and the biodiverse highlands of Malaysia's Kinabalu Park.</li>
</ul>";

$tour->highlights()->create(['content' => $highlights, 'sort_order' => 1]);

$differences = "<ul>
<li>Immersive itineraries, including pre- and post-cruise stays</li>
<li>Acclaimed Expedition Team</li>
<li>Choice of included shore excursions and onboard enrichment</li>
<li>All-inclusive from start to finish</li>
<li>Staff-to-guest ratio of almost 1:1</li>
</ul>";

$tour->differences()->create(['content' => $differences, 'sort_order' => 1]);

$inclusions = "<ul>
<li>A pre-cruise hotel stay, complete with excursions</li>
<li>Engaging onboard lectures and workshops from our Expedition Team</li>
<li>Your choice of expertly guided shore excursions</li>
<li>Nine world-class dining options, including the only Nobu restaurant at sea</li>
<li>Unlimited house drinks, including champagne, onboard</li>
<li>Airport meet-and-greet with private transfers</li>
<li>Crystal's celebrated lineup of nightly onboard entertainment</li>
<li>Private balcony and butler service</li>
<li>Laundry and shoeshine services</li>
<li>Ortigia bath amenities and Etro robes</li>
<li>Complimentary Wi-Fi and use of an in-suite tablet</li>
<li>English-speaking staff, including a doctor</li>
<li>Round-the-clock, on-call support from our travel experts</li>
<li>All staff and crew gratuities, port charges and taxes</li>
</ul>";

$tour->inclusions()->create(['content' => $inclusions, 'sort_order' => 1]);

$hotel1Id = importImage('https://www.solvivetravel.com/assets/images/bangkok_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Mandarin Oriental, Bangkok",
    'description' => "Fronting the Chao Phraya River with 135 years of history and legendary service. 374 exquisitely decorated rooms and suites with butler service, ten restaurants, Thai cooking classes, two pools, a state-of-the-art gym and an expansive spa.",
    'image' => $hotel1Id,
    'sort_order' => 1
]);

$hotel2Id = importImage('https://www.solvivetravel.com/assets/images/hero_landscape_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Crystal Serenity",
    'description' => "An industry-leading space-to-guest ratio, butler service in every suite, nine dining options including Chef Nobu Matsuhisa's only restaurant at sea, and the only Le Casino de Monte-Carlo on the ocean. Nearly one crew member for every guest.",
    'image' => $hotel2Id,
    'sort_order' => 2
]);

$additional_infos = "<ul>
<li>Active elements: uneven terrain at some sites; optional challenging hikes available</li>
<li>Minimum age: 6 years old</li>
<li>First group event: excursion on April 9</li>
<li>Last group event: disembarkation in Hong Kong on April 23 by 9:00 a.m., with transfer to the airport</li>
<li>Guaranteed to depart with a minimum of two guests</li>
</ul>";

$tour->additionalInfos()->create(['content' => $additional_infos, 'sort_order' => 1]);

echo "Epic Voyage Tour created successfully with images and single-block lists!\n";
