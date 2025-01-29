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
        
        return $auth0->getSdk()->authentication()->getLoginLink(
            Str::random(40),
            config('auth0.guards.web.redirect_uri'),
            [
                'scope' => 'openid profile email',
                'response_type' => 'code'
            ]
        );
    }

    public function callback(Request $request)
    {
        $auth0 = app('auth0');
        $auth0->exchange();
        
        $userInfo = $auth0->getCredentials()->user;

        if (!$userInfo) {
            return redirect()->route('login');
        }

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
        
        return redirect(
            app('auth0')->getSdk()->authentication()->getLogoutLink(
                route('login')
            )
        );
    }
}