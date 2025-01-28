<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Cookie'den dil tercihi kontrolü
        $locale = request()->cookie('locale');
        
        // Session'dan dil tercihi kontrolü
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        
        // Geçerli bir dil ise ayarla
        if (in_array($locale, ['en', 'tr'])) {
            App::setLocale($locale);
        }
    }
}