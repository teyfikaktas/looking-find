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
        return Auth0::login(redirect()->intended()->getTargetUrl());
    }

    public function callback()
    {
        Auth0::callback();

        $user = Auth0::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Kullanıcıyı bul veya oluştur
        $localUser = User::updateOrCreate(
            ['email' => $user['email']],
            [
                'name' => $user['name'] ?? null,
                'auth0_id' => $user['sub'],
                'password' => Hash::make(Str::random(16)),
                'photo' => $user['picture'] ?? null,
                'country' => null,
                'city' => null
            ]
        );

        Auth::login($localUser);

        return redirect()->intended('home');
    }

    public function logout()
    {
        Auth::logout();
        
        return Auth0::logout(route('login'));
    }
}