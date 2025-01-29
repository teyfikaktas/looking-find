<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'tr'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
            
            // Debug için ekleyelim
            \Log::info('Dil değiştirme:', [
                'Seçilen dil' => $lang,
                'Session dili' => Session::get('locale'),
                'Uygulama dili' => App::getLocale()
            ]);
    
            // Redirect yerine url()->previous() kullanalım
            return redirect(url()->previous())->withCookie('locale', $lang);
        }
        
        return back();
    }
}