<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Tour;
use App\Models\TourAccommodation;
use Awcodes\Curator\Models\Media;

class ImportMediaToCurator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-media-to-curator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing storage files into Curator Media Library';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting media import...');

        // 1. Process Tours
        $tours = Tour::all();
        foreach ($tours as $tour) {
            if ($tour->hero_image && !is_numeric($tour->hero_image)) {
                $mediaId = $this->createMediaFromPath($tour->hero_image);
                if ($mediaId) {
                    $tour->hero_image = $mediaId;
                }
            }
            if ($tour->overview_image && !is_numeric($tour->overview_image)) {
                $mediaId = $this->createMediaFromPath($tour->overview_image);
                if ($mediaId) {
                    $tour->overview_image = $mediaId;
                }
            }
            $tour->save();
        }

        // 2. Process Accommodations
        $accommodations = TourAccommodation::all();
        foreach ($accommodations as $acc) {
            if ($acc->image && !is_numeric($acc->image)) {
                $mediaId = $this->createMediaFromPath($acc->image);
                if ($mediaId) {
                    $acc->image = $mediaId;
                    $acc->save();
                }
            }
        }

        // 3. Process any other files in storage/app/public/tours and hotels
        $this->info('Scanning unlinked files...');
        $this->scanDirectory('tours');
        $this->scanDirectory('hotels');

        $this->info('Media import completed successfully.');
    }

    protected function createMediaFromPath($path)
    {
        if (!Storage::disk('public')->exists($path)) {
            $this->warn("File does not exist: {$path}");
            return null;
        }

        // Check if already in media table
        $existing = Media::where('path', $path)->first();
        if ($existing) {
            return $existing->id;
        }

        $size = Storage::disk('public')->size($path);
        $mime = Storage::disk('public')->mimeType($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = pathinfo($path, PATHINFO_FILENAME);
        $directory = dirname($path);
        
        $width = null;
        $height = null;
        if (str_contains($mime, 'image')) {
            $imageSize = @getimagesize(Storage::disk('public')->path($path));
            if ($imageSize) {
                $width = $imageSize[0];
                $height = $imageSize[1];
            }
        }

        $media = Media::create([
            'disk' => 'public',
            'directory' => $directory === '.' ? 'media' : $directory,
            'visibility' => 'public',
            'name' => $name,
            'path' => $path,
            'width' => $width,
            'height' => $height,
            'size' => $size,
            'type' => $mime,
            'ext' => $ext,
            'alt' => $name,
            'title' => $name,
        ]);

        return $media->id;
    }

    protected function scanDirectory($directory)
    {
        $files = Storage::disk('public')->files($directory);
        foreach ($files as $file) {
            $this->createMediaFromPath($file);
        }
    }
}
