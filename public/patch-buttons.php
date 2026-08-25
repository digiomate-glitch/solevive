<?php
$file = __DIR__.'/vendor/awcodes/filament-curator/src/Components/Modals/CuratorPanel.php';
if (file_exists($file)) {
    $content = file_get_contents($file);
    $content = str_replace(
        "->label(trans('curator::views.panel.edit_cancel'))",
        "->label('Deselect')",
        $content
    );
    file_put_contents($file, $content);
    echo 'Patched successfully!';
} else {
    echo 'File not found.';
}
