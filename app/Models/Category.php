<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $guarded = [];


    public function tours() {
        return $this->belongsToMany(Tour::class)->orderBy('sort_order');
    }

}
