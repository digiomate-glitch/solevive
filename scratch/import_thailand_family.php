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

$heroId = importImage('https://www.solvivetravel.com/assets/images/Thailand%20Family%20Adventure-img.webp', 'tours');
$overviewId = importImage('https://www.solvivetravel.com/assets/images/hero_landscape_hq.jpg', 'tours');

$slug = Str::slug('Thailand Family Adventure');
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
    'title' => 'Thailand Family Adventure',
    'slug' => Str::slug('Thailand Family Adventure'),
    'price' => '$6,495',
    'duration_days' => 10,
    'destinations_count' => null,
    'max_guests' => 'Private',
    'countries' => 'Thailand',
    'hero_image' => $heroId,
    'overview_image' => $overviewId,
    'overview_heading' => "Thailand, on your family's terms.",
    'overview_desc' => '<p>This tailormade journey brings the Solvive standard of restorative luxury to family travel — temples and elephants by day, quiet pool afternoons by choice, and enough breathing room that no one comes home needing a vacation from the vacation. Because it\'s private, the pacing, activity mix and hotel style flex entirely around the ages and energy levels in your party.</p>',
    'is_published' => true,
    'highlights_heading' => 'Designed around your family, not a fixed departure.',
    'differences_heading' => 'Why Choose an A&K Small Group Journey?',
    'inclusions_heading' => 'Every detail, handled.',
]);

$highlights = "<ul>
<li><strong>No shared itinerary.</strong> Every day is built around your family's interests, energy levels and ages — from toddlers to grandparents.</li>
<li><strong>Flexible pacing.</strong> Add rest days, swap an excursion, or linger somewhere your kids fall in love with.</li>
<li><strong>Handpicked, family-ready stays.</strong> Properties chosen for connecting rooms, pools, and space to spread out.</li>
<li><strong>One dedicated point of contact</strong> from first call to final transfer home.</li>
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
<li>A fully personalized, day-by-day itinerary built around your family</li>
</ul>";

$tour->inclusions()->create(['content' => $inclusions, 'sort_order' => 1]);

// Note: This tour doesn't have Accommodations or Additional Information listed in the HTML

echo "Thailand Family Adventure Tour created successfully with images and single-block lists!\n";
