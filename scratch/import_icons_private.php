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

$heroId = importImage('https://www.solvivetravel.com/assets/images/Icons%20of%20Southeast-img.webp', 'tours');
$overviewId = $heroId; // Both use the same image in the template

$tour = Tour::create([
    'title' => 'Icons of Southeast Asia: A Private Journey',
    'slug' => Str::slug('Icons of Southeast Asia: A Private Journey'),
    'price' => '$12,195',
    'duration_days' => 13,
    'destinations_count' => 6,
    'max_guests' => 'Private',
    'countries' => 'Southeast Asia',
    'hero_image' => $heroId,
    'overview_image' => $overviewId,
    'overview_heading' => 'A comprehensive adventure through Southeast Asia.',
    'overview_desc' => '<p>The nations of Vietnam, Laos, Cambodia and Thailand are united not just by geography but by a tangible heritage of influences from all corners of Asia. This comprehensive adventure that reveals historical, cultural and culinary treasures throughout the region, from karst-adorned Ha Long Bay and incomparable Angkor Wat to charming Luang Prabang and temple-laden Bangkok.</p>',
    'is_published' => true,
    'highlights_heading' => 'What awaits you.',
    'differences_heading' => 'Why Choose an A&K Private Ready-To-Book Journey?',
    'inclusions_heading' => 'Inclusions',
    'accommodations_heading' => 'Six destinations, legendary stays.',
    'additional_infos_heading' => 'Additional Information',
]);

$highlights = "<ul>
<li>Engage with the complex history of Vietnam, north and south, as you visit the infamous “Hanoi Hilton” and inspect the Cu Chi Tunnels, where you may meet with a Vietcong veteran</li>
<li>Glide among stunning limestone islands and watch the sun set and rise again during a relaxing overnight cruise on tranquil Ha Long Bay</li>
<li>Venture straight into the heart of daily life in Ho Chi Minh City, riding by cyclo through the streets at dawn to observe local life, stop for coffee and savor sensational pho at a culinary hotspot</li>
<li>Explore Cambodia’s most storied temples with an expert local guide, including Angkor Wat, Bayon and Ta Prohm, during a two-night sojourn in Siem Reap</li>
<li>In serene Luang Prabang, meet with locals in their home for a baci ceremony and take part in an alms-giving tradition that immerses you in the community’s spiritual life</li>
</ul>";

$tour->highlights()->create(['content' => $highlights, 'sort_order' => 1]);

$differences = "<ul>
<li>Travel privately, just you and your group</li>
<li>Highlight-filled itineraries designed by experts</li>
<li>Unique and exclusive experiences in every destination</li>
<li>The best luxury accommodations in every destination</li>
<li>Convenience of pre-set dates</li>
</ul>";

$tour->differences()->create(['content' => $differences, 'sort_order' => 1]);

$inclusions = "<ul>
<li>English-speaking local guides</li>
<li>Airport meet-and-greet with private transfers</li>
<li>Entrance fees and taxes</li>
<li>Daily breakfast, along with some meals</li>
<li>Round-the-clock, on-call support from A&K’s experts</li>
<li>Internal Air Included (Economy Class, $1,900 value) Hai Phong/Ho Chi Minh City; Ho Chi Minh City/Siem Reap; Siem Reap/Luang Prabang; Luang Prabang/Bangkok</li>
</ul>";

$tour->inclusions()->create(['content' => $inclusions, 'sort_order' => 1]);

$hotel1Id = importImage('https://www.solvivetravel.com/assets/images/hanoi_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Sofitel Legend Metropole Hanoi",
    'description' => "A French colonial landmark set in the heart of Hanoi, the Sofitel Legend Metropole Hanoi has hosted ambassadors, writers, statesmen and entrepreneurs for more than 100 years. This grand luxury hotel features 358 sumptuous rooms and suites, with those in the historic Heritage Wing reminiscent of 1920s France and those in the Opera Wing evoking neo-classical elegance. Three restaurants and three bars offer French, Vietnamese and Italian cuisine. Other amenities include a Jacuzzi, sauna, spa and fitness center. Located one hour by car from Noi Bai International Airport, the Sofitel Legend Metropole Hanoi is an ideal choice for guests seeking the elegance of a bygone era.",
    'image' => $hotel1Id,
    'sort_order' => 1
]);

$hotel2Id = importImage('https://www.solvivetravel.com/assets/images/hero_landscape_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Lyra Grandeur",
    'description' => "Lyra Grandeur cruises Vietnam’s scenic Ha Long and Lan Ha Bays with a stylish blend of a modern superyacht and Indochina ambiance. The luxuriously appointed ship has 33 cabins, each with an en-suite bath, panoramic views and private balconies. Onboard amenities include a restaurant, bar, plunge pool, Jacuzzi and waterslide.",
    'image' => $hotel2Id,
    'sort_order' => 2
]);

$hotel3Id = importImage('https://www.solvivetravel.com/assets/images/ho_chi_minh_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "The Reverie Saigon",
    'description' => "Perched atop the soaring Times Square Building, The Reverie Saigon is located in Ho Chi Minh City's upscale District 1. The contemporary luxury hotel features 286 eclectic guest rooms and suites with ornate Italian and Vietnamese touches that lend a sense of place. Five restaurants serve a variety of cuisine, including International, Chinese, and Vietnamese. Other amenities include a pool, fitness center, salon and spa. Located 30 minutes by car from Tan Son Nhat International Airport, The Reverie Saigon is an ideal choice for guests seeking panoramic views, ornate surroundings and a central address.",
    'image' => $hotel3Id,
    'sort_order' => 3
]);

$hotel4Id = importImage('https://www.solvivetravel.com/assets/images/siem_reap_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Raffles Grand Hotel d'Angkor",
    'description' => "A historic fixture of Siem Reap's French Quarter since 1932, Raffles Grand Hotel d'Angkor lies among 15 acres of beautifully landscaped gardens just five miles from Angkor Wat. This iconic grand luxury hotel's 119 guest rooms and suites feature Art Deco furnishings and Cambodian art. Five restaurants and bars offer a variety of cuisine, while the colonial atmosphere of The Conservatory is ideal for afternoon tea. Other amenities include a fitness center and a spa featuring a sauna, steam room and Jacuzzi. Raffles Grand Hotel d'Angkor is a perfect choice for guests seeking an elegant, historic property with landmark status.",
    'image' => $hotel4Id,
    'sort_order' => 4
]);

$hotel5Id = importImage('https://www.solvivetravel.com/assets/images/luang_prabang_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "La Résidence Phou Vao, Luang Prabang",
    'description' => "Perched atop a hill overlooking the UNESCO World Heritage Site of Luang Prabang, La Résidence Phou Vao, Luang Prabang hotel is famous for its tranquility, French-influenced local cuisine and open-air spa. Traditionally appointed with teak, silk and fresh cotton accents, each of the 34 suites in this luxury boutique hotel feature spacious bathrooms with free-form terrazzo baths. The hotel also features a stunning cliffside freshwater swimming pool. La Résidence Phou Vao, Luang Prabang is 15 minutes by car from Luang Prabang International Airport and is the perfect choice for travellers who want luxurious accommodations.",
    'image' => $hotel5Id,
    'sort_order' => 5
]);

$hotel6Id = importImage('https://www.solvivetravel.com/assets/images/bangkok_hq.jpg', 'hotels');
$tour->accommodations()->create([
    'hotel_name' => "Mandarin Oriental, Bangkok",
    'description' => "Fronting the banks of the iconic Chao Phraya River, the Mandarin Oriental, Bangkok lies within easy reach of the city's major attractions. World-renowned for its 135 years of rich history and legendary service, this grand luxury hotel's 374 exquisitely decorated rooms and suites feature plush amenities and butler service. The hotel also boasts ten restaurants. Other amenities include Thai cooking and culture classes, two swimming pools, a state-of-the-art gym, outdoor racquet courts and an expansive spa. Situated approximately 50 minutes by car from Suvarnabhumi Airport and a short walk from Bangkok's famous Skytrain, the Mandarin Oriental is the perfect choice for guests seeking the highest standards of luxury in the center of Bangkok's major attractions.",
    'image' => $hotel6Id,
    'sort_order' => 6
]);

$additional_infos = "<ul>
<li><strong>Active Elements:</strong> Includes walking over steep, uneven terrain</li>
<li><strong>Minimum Age:</strong> None</li>
<li><strong>Solo Traveller:</strong> Pricing is available upon request</li>
</ul>";

$tour->additionalInfos()->create(['content' => $additional_infos, 'sort_order' => 1]);

echo "Icons of Southeast Asia Private Tour created successfully with images and single-block lists!\n";
