<?php
require 'vendor/autoload.php';
try {
    $driver = new Illuminate\Image\Drivers\GdDriver();
    $method = new ReflectionMethod($driver, 'createManager');
    $method->setAccessible(true);
    $manager = $method->invoke($driver);
    echo get_class($manager);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
