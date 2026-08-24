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

$heroId = importImage('https://www.solvivetravel.com/assets/images/Ultimate%20Thailand%20Adventure-img.webp', 'tours');
$overviewId = $heroId;

$slug = Str::slug('Ultimate Thailand Adventure');
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
    'title' => 'Ultimate Thailand Adventure',
    'slug' => Str::slug('Ultimate Thailand Adventure'),
    'price' => '$13,395',
    'duration_days' => 11,
    'destinations_count' => 4,
    'max_guests' => 'Private',
    'countries' => 'Thailand',
    'hero_image' => $heroId,
    'overview_image' => $overviewId,
    'overview_heading' => "The definitive private Thailand.",
    'overview_desc' => '<p>For travelers who want to go deeper than a first-time itinerary allows, this journey moves privately through four of Thailand\'s most distinct destinations — pairing ancient temples and living culture with genuine stillness. Every stop, pace and inclusion is shaped around what your party wants more of, and less of.</p>',
    'is_published' => true,
    'highlights_heading' => 'Depth, at your own pace.',
    'differences_heading' => 'Why Choose an A&K Small Group Journey?',
    'inclusions_heading' => 'Every detail, handled.',
]);

$highlights = "<ul>
<li><strong>Four destinations, no compromises.</strong> Time allotted where you want it, not where a fixed group schedule requires it.</li>
<li><strong>Access beyond the guidebook.</strong> Local guides open doors to experiences that mirror our authenticity-first approach — never a tourist trap.</li>
<li><strong>Restorative by design.</strong> Built-in quiet and reflection, not wall-to-wall sightseeing.</li>
<li><strong>Private transfers and a dedicated point of contact</strong> throughout, with round-the-clock support.</li>
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
<li>A fully personalized, day-by-day itinerary across all four destinations</li>
</ul>";

$tour->inclusions()->create(['content' => $inclusions, 'sort_order' => 1]);

echo "Ultimate Thailand Adventure Tour created successfully with images and single-block lists!\n";
