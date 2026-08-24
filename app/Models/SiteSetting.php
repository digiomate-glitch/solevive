<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function faviconMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'favicon');
    }

    public function headerLogoMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'header_logo');
    }

    public function footerLogoMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'footer_logo');
    }

    public function homeHeroImageMedia()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'home_hero_image');
    }
}
