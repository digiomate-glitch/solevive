<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourHighlight;
use App\Models\TourInclusion;
use App\Models\TourDifference;
use App\Models\TourAdditionalInfo;

class CleanCkeditorLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:clean-ckeditor-lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans CKEditor lists by removing unnecessary <p> tags inside <li> elements across all related tables.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            TourHighlight::class,
            TourInclusion::class,
            TourDifference::class,
            TourAdditionalInfo::class,
        ];

        foreach ($models as $modelClass) {
            $this->info("Cleaning " . class_basename($modelClass) . "...");
            $records = $modelClass::all();
            $count = 0;
            
            foreach ($records as $record) {
                // By simply resaving the model, the `CleansCkeditorContent` trait's saving event 
                // will automatically clean the content field if it needs cleaning.
                $originalContent = $record->content;
                
                // Trigger the saving event
                $record->save();
                
                if ($originalContent !== $record->content) {
                    $count++;
                }
            }
            $this->info("Cleaned $count records for " . class_basename($modelClass));
        }

        $this->info('Done!');
    }
}
