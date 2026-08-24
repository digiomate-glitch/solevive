<?php
$dir = new RecursiveDirectoryIterator('vendor');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $f) {
    if($f->isFile() && $f->getExtension()=='php') {
        $content = file_get_contents($f->getPathname());
        if(strpos($content, 'usingDriver') !== false) {
            echo $f->getPathname() . "\n";
        }
    }
}
