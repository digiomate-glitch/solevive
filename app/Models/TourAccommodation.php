<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourAccommodation extends Model
{
    
    protected $guarded = [];


    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function media()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'image');
    }

}
