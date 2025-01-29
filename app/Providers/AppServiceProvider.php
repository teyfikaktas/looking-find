<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (request()->hasCookie('locale')) {
            app()->setLocale(request()->cookie('locale'));
        }
    }
    
}