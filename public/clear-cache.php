<?php
require __DIR__."/../vendor/autoload.php";
$app = require_once __DIR__."/../bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Illuminate\Support\Facades\Artisan::call("optimize:clear");
echo "Cache cleared successfully!<br>";
echo nl2br(\Illuminate\Support\Facades\Artisan::output());

