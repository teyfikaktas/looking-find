<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth0\Login\Auth0Controller as Auth0BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class Auth0Controller extends Auth0BaseController
{
    public function login()
    {
        return app('auth0')->login(
            null,
            null,
            ['scope' => 'openid profile email'],
            'code'
        );
    }

    public function callback()
    {
        $auth0User = app('auth0')->getUser();
    
        if (!$auth0User) {
            return redirect()->route('login');
        }
    
        // Kullanıcıyı bul veya oluştur
        $user = User::updateOrCreate(
            ['email' => $auth0User['email']],
            [
                'name' => $auth0User['name'] ?? null,
                'auth0_id' => $auth0User['sub'],
                'password' => Hash::make(str_random(16)),
                // Google'dan gelen ek bilgiler
                'photo' => $auth0User['picture'] ?? null, // Google profil fotoğrafı
                'country' => null, // Google'dan alamıyoruz
                'city' => null     // Google'dan alamıyoruz
            ]
        );
    
        Auth::login($user);
    
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        
        return app('auth0')->logout(
            route('login')
        );
    }
}