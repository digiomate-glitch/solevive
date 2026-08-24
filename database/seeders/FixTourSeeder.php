<?php
use App\Models\Tour;

$tour = Tour::where('id', 8)->first();

if ($tour) {
    // Highlights
    $h = $tour->highlights->pluck('content')->implode('');
    if ($h) {
        // Strip <p> just in case it got wrapped again, or just let the trait clean it later
        $h = str_replace(['<p>', '</p>'], '', $h);
        $tour->highlights()->delete();
        $tour->highlights()->create(['content' => '<ul>' . $h . '</ul>']);
    }

    // Inclusions
    $inc = $tour->inclusions->pluck('content')->implode('');
    if ($inc) {
        $inc = str_replace(['<p>', '</p>'], '', $inc);
        $tour->inclusions()->delete();
        $tour->inclusions()->create(['content' => '<ul>' . $inc . '</ul>']);
    }

    // Differences
    $dif = $tour->differences->pluck('content')->implode('');
    if ($dif) {
        $dif = str_replace(['<p>', '</p>'], '', $dif);
        $tour->differences()->delete();
        $tour->differences()->create(['content' => '<ul>' . $dif . '</ul>']);
    }

    // Additional Infos
    $add = $tour->additionalInfos->pluck('content')->implode('');
    if ($add) {
        $add = str_replace(['<p>', '</p>'], '', $add);
        $tour->additionalInfos()->delete();
        $tour->additionalInfos()->create(['content' => '<ul>' . $add . '</ul>']);
    }

    echo "Tour fixed successfully!\n";
}
