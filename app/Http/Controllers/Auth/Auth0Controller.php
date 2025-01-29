<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class Auth0Controller extends Controller
{
    public function login()
    {
        $auth0 = app('auth0');
        
        return redirect(
            $auth0->getSdk()->authentication()->getLoginLink(
                config('auth0.redirectUri'),
                [
                    'scope' => 'openid profile email',
                ]
            )
        );
    }

    public function callback()
    {
        $auth0 = app('auth0');
        $userInfo = $auth0->getUser();

        if (!$userInfo) {
            return redirect()->route('login');
        }

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
        
        return app('auth0')->logout([
            'returnTo' => route('login')
        ]);
    }
}