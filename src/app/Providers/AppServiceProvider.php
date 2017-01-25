<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('firstNoSpace', function($attribute, $value, $parameters) {
            return preg_match("#^\S#i", $value);
        });  
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         
    }
}
