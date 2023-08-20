<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
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
          // return true if setup is completed
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->access_level == 'admin'; 
        });
        // check if category is parent
        Blade::if('isParent', function($category){

            return empty($category->category_id);
        });

        // check if category is child
        Blade::if('isChild', function($category){

            return !empty($category->category_id);
        });
    }
}
