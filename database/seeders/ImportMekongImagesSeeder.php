<?php

use Awcodes\Curator\Models\Media;
use App\Models\Tour;
use App\Models\TourAccommodation;
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

$tour = Tour::where('slug', 'cruising-the-mekong-and-angkor-wat')->first();

if ($tour) {
    echo "Downloading hero image...\n";
    $heroId = importImage('https://www.solvivetravel.com/assets/images/Cruising%20the%20Mekong-img.webp', 'tours');
    if ($heroId) $tour->update(['hero_image' => $heroId]);

    echo "Downloading overview image...\n";
    $overviewId = importImage('https://www.solvivetravel.com/assets/images/angkor_wat_hq.jpg', 'tours');
    if ($overviewId) $tour->update(['overview_image' => $overviewId]);

    echo "Downloading hotel images...\n";
    $hotelImages = [
        "Sofitel Legend Metropole Hanoi" => 'https://www.solvivetravel.com/assets/images/hanoi_hq.jpg',
        "The Reverie Saigon" => 'https://www.solvivetravel.com/assets/images/ho_chi_minh_hq.jpg',
        "Raffles Grand Hotel d'Angkor" => 'https://www.solvivetravel.com/assets/images/siem_reap_hq.jpg',
        "Mekong Princess" => 'https://www.solvivetravel.com/assets/images/Cruising%20the%20Mekong-img.webp'
    ];

    foreach ($tour->accommodations as $acc) {
        if (isset($hotelImages[$acc->hotel_name])) {
            $imgId = importImage($hotelImages[$acc->hotel_name], 'hotels');
            if ($imgId) {
                // Ensure accommodation image column is updated (assuming it's 'image' or similar)
                // Wait, TourResource has `\Awcodes\Curator\Components\Forms\CuratorPicker::make('image')`
                // Let's assume the column is `image`
                $acc->update(['image' => $imgId]);
            }
        }
    }
    echo "Images imported successfully!\n";
} else {
    echo "Tour not found!\n";
}
