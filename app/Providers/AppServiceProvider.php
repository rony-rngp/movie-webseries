<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Cms;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (request()->getHost() != 'movie.test') {
            dd('Check your domain name in provider');
        }

        $footer_categories = Category::with('subcategories')->where('status', 1)->get()->toArray();
        $footer_categories_cunk = array_chunk($footer_categories, 3);
        $cms_pages = Cms::where('status', 1)->get();
        View::share(['footer_categories_cunk' => $footer_categories_cunk, 'cms_pages' => $cms_pages]);
    }
}
