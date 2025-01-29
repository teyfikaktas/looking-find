<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (Cookie::has('locale')) {
            app()->setLocale(Cookie::get('locale'));
        }
    }
    
}