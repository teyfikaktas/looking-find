<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        try {
            if (in_array($lang, ['en', 'tr'])) {
                Session::put('locale', $lang);
                App::setLocale($lang);
                
                return redirect()
                    ->back()
                    ->with('locale_changed', true)
                    ->withCookie(cookie()->forever('locale', $lang));
            }
            
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('Dil değiştirme hatası: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}