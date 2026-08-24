<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

use App\Models\Tour;

Route::get('/', function () {
    $featuredTours = Tour::where('is_published', true)
        ->orderBy('sort_order')
        ->take(3)
        ->get();
        
    $siteSetting = \App\Models\SiteSetting::first();
        
    return view('welcome', compact('featuredTours', 'siteSetting'));
});

// Since we haven't built the About/Contact pages yet, we'll route them to welcome as a placeholder, or just leave them.
// Let's create the Category and Detail routes!
Route::get('/small-group-tours', [TourController::class, 'category'])->defaults('slug', 'small-group-tours');
Route::get('/private-tours', [TourController::class, 'category'])->defaults('slug', 'private-tours');

// Static pages
Route::view('/about', 'about');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [\App\Http\Controllers\InquiryController::class, 'store'])->name('inquiry.store');

Route::get('/{slug}', [TourController::class, 'show']);
