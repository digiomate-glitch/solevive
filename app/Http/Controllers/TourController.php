<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tour;

class TourController extends Controller
{
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $tours = $category->tours()->where('is_published', true)->orderBy('sort_order')->get();
        
        return view('tours.category', compact('category', 'tours'));
    }

    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)
                    ->where('is_published', true)
                    ->with(['highlights', 'inclusions', 'accommodations', 'additionalInfos', 'categories'])
                    ->firstOrFail();
                    
        $primaryCategory = $tour->categories->first();
        $relatedTours = collect();
        
        if ($primaryCategory) {
            $relatedTours = $primaryCategory->tours()
                                ->where('tours.id', '!=', $tour->id)
                                ->where('is_published', true)
                                ->take(2)
                                ->get();
        }
                    
        return view('tours.detail', compact('tour', 'primaryCategory', 'relatedTours'));
    }
}
