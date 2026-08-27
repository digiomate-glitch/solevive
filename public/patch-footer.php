<?php
$file = __DIR__.'/../resources/views/components/footer.blade.php';
if (file_exists($file)) {
    $content = file_get_contents($file);
    $content = str_replace(
        "url('/cruising-the-mekong-angkor-wat')",
        "url('/cruising-the-mekong-and-angkor-wat')",
        $content
    );
    file_put_contents($file, $content);
    
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    
    echo 'Footer link patched and cache cleared successfully!';
} else {
    echo 'Footer file not found!';
}
