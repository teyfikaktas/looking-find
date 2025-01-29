<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth0\Laravel\Facade\Auth0;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class Auth0Controller extends Controller
{
    public function login()
    {
        return Auth0::withScope(['openid', 'profile', 'email'])
            ->withAudience('https://github.com/auth0/laravel-auth0')
            ->redirect();
    }

    public function callback()
    {
        // Credentials'ı al
        $credentials = Auth0::getCredentials();

        if (!$credentials) {
            return redirect()->route('login');
        }

        $userInfo = $credentials->user();

        // Kullanıcıyı bul veya oluştur
        $user = User::updateOrCreate(
            ['email' => $userInfo['email']],
            [
                'name' => $userInfo['name'] ?? null,
                'auth0_id' => $userInfo['sub'],
                'password' => Hash::make(Str::random(16)),
                'photo' => $userInfo['picture'] ?? null,
                'country' => null,
                'city' => null
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        
        return Auth0::logout(
            returnTo: route('login')
        );
    }
}