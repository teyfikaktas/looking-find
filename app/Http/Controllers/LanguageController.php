<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Uygulamanın dilini değiştirir.
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'tr'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        }
        return Redirect::back();
    }
}
