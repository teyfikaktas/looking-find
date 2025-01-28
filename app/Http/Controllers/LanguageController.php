<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        // Geçerli dilleri kontrol et
        if (!in_array($lang, ['en', 'tr'])) {
            return redirect()->back();
        }

        // Session'a dili kaydet
        Session::put('locale', $lang);
        
        // Uygulamanın dilini değiştir
        App::setLocale($lang);
        
        // Cookie'ye de kaydet (opsiyonel)
        return redirect()->back()->withCookie(cookie()->forever('locale', $lang));
    }
}