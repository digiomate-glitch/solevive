<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.header', function ($view) {
            $smallGroup = Category::where('slug', 'small-group-tours')->first();
            $private = Category::where('slug', 'private-tours')->first();

            $navSmallGroupTours = $smallGroup ? $smallGroup->tours()->where('is_published', true)->orderBy('sort_order')->get() : collect();
            $navPrivateTours = $private ? $private->tours()->where('is_published', true)->orderBy('sort_order')->get() : collect();

            $view->with(compact('navSmallGroupTours', 'navPrivateTours'));
        });
    }
}
