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

$heroId = importImage('https://www.solvivetravel.com/assets/images/Luxury%20Tented%20Camps%20of%20Southeast%20Asia-img.webp', 'tours');
$overviewId = $heroId;

$slug = Str::slug('The Luxury Tented Camps of Southeast Asia');
$existingTour = Tour::where('slug', $slug)->first();
if ($existingTour) {
    $existingTour->highlights()->delete();
    $existingTour->differences()->delete();
    $existingTour->inclusions()->delete();
    $existingTour->accommodations()->delete();
    $existingTour->additionalInfos()->delete();
    $existingTour->delete();
}

$tour = Tour::create([
    'title' => 'The Luxury Tented Camps of Southeast Asia',
    'slug' => Str::slug('The Luxury Tented Camps of Southeast Asia'),
    'price' => '$38,795',
    'duration_days' => 15,
    'destinations_count' => 6,
    'max_guests' => 'Private',
    'countries' => 'Southeast Asia',
    'hero_image' => $heroId,
    'overview_image' => $overviewId,
    'overview_heading' => "Wilderness, without compromise.",
    'overview_desc' => '<p>For the traveler who wants proximity to nature without giving up an ounce of comfort, this journey moves privately through six destinations, threading together the region\'s most exceptional tented camps and lodges — canvas walls, thread-count linens, and some of the quietest mornings you\'ll ever spend.</p>',
    'is_published' => true,
    'highlights_heading' => 'The region\'s finest tented camps, in one itinerary.',
    'differences_heading' => 'Why Choose an A&K Small Group Journey?',
    'inclusions_heading' => 'Every detail, handled.',
]);

$highlights = "<ul>
<li><strong>Six destinations, one seamless private journey</strong> — routing and pacing shaped entirely around your interests.</li>
<li><strong>Handpicked tented camps and lodges</strong>, chosen for setting, design and genuine remoteness rather than proximity to a crowd.</li>
<li><strong>Restorative by design</strong> — quiet mornings, guided immersions, and space to simply be present in the landscape.</li>
<li><strong>Private transfers between every stop and round-the-clock support</strong> throughout the 15 days.</li>
</ul>";

$tour->highlights()->create(['content' => $highlights, 'sort_order' => 1]);

$differences = "<ul>
<li>Expert-designed journeys customized to suit you</li>
<li>Authentic and exclusive experiences</li>
<li>Hand-selected luxury hotels in every destination</li>
<li>Deeply knowledgeable, English-speaking local guides</li>
<li>Airport meet and greet with private transfers</li>
</ul>";

$tour->differences()->create(['content' => $differences, 'sort_order' => 1]);

$inclusions = "<ul>
<li>English-speaking local guides throughout</li>
<li>Airport meet-and-greet with private transfers</li>
<li>Entrance fees and taxes</li>
<li>Daily breakfast, along with some meals</li>
<li>Round-the-clock, on-call support from our travel experts</li>
<li>A fully personalized, day-by-day itinerary across all six destinations</li>
</ul>";

$tour->inclusions()->create(['content' => $inclusions, 'sort_order' => 1]);

echo "Luxury Tented Camps Tour created successfully with images and single-block lists!\n";
