<?php
use App\Models\Tour;
$t = Tour::find(8);
if ($t) {
    echo $t->slug . " | " . $t->title . "\n";
    echo "Highlights count: " . $t->highlights()->count() . "\n";
    foreach($t->highlights as $h) {
        echo $h->id . ": " . $h->content . "\n";
    }
} else {
    echo "Tour 8 not found.\n";
}
