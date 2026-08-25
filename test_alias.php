<?php require 'vendor/autoload.php'; class_alias('Intervention\Image\Facades\Image', 'Image'); require 'bootstrap/app.php'; dump(get_class(Image::getFacadeRoot()));
