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
        $locale = request()->cookie('app_locale');
        if ($locale && in_array($locale, ['en', 'tr'])) {
            app()->setLocale($locale);
        }
    }
}