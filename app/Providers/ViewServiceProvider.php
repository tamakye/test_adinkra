<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['*'], function ($view) {

            $view->with('countries', cache()->rememberForever('countries', function () {
                return \App\Models\Country::orderBy('name', 'asc')->get();
            }));

            $view->with('regions', cache()->rememberForever('regions', function () {
                return \App\Models\Region::orderBy('name', 'asc')->get();
            }));

            $view->with('page', cache()->rememberForever('page', function () {
                return Page::first();
            }));
        });

    }
}
