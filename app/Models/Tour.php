<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    
    protected $guarded = [];

    protected $casts = [
        'facts' => 'array',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
    public function highlights() {
        return $this->hasMany(TourHighlight::class)->orderBy('sort_order');
    }
    public function differences() {
        return $this->hasMany(TourDifference::class)->orderBy('sort_order');
    }
    public function inclusions() {
        return $this->hasMany(TourInclusion::class)->orderBy('sort_order');
    }
    public function accommodations() {
        return $this->hasMany(TourAccommodation::class)->orderBy('sort_order');
    }
    public function additionalInfos() {
        return $this->hasMany(TourAdditionalInfo::class)->orderBy('sort_order');
    }

    public function heroMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'hero_image');
    }

    public function overviewMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'overview_image');
    }
}
