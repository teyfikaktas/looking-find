<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap application services.
     */
    public function boot()
    {
        // Eğer session'da bir dil seçildiyse bunu uygula
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    }

    /**
     * Register application services.
     */
    public function register()
    {
        //
    }
}
