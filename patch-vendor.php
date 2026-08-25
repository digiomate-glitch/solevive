<?php
$files = [
    __DIR__."/vendor/awcodes/filament-curator/src/Components/Modals/CuratorCuration.php",
    __DIR__."/vendor/awcodes/filament-curator/src/Components/Forms/Uploader.php"
];
foreach($files as $f) {
    if (file_exists($f)) {
        $content = file_get_contents($f);
        $content = str_replace("use Intervention\Image\Facades\Image;", "use Intervention\Image\ImageManagerStatic as Image;", $content);
        file_put_contents($f, $content);
        echo "Patched $f <br>";
    } else {
        echo "File not found: $f <br>";
    }
}

