<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Auth0\Laravel\Facade\Auth0;

class Auth0Controller extends Controller
{
    public function login()
    {
        $auth0 = app('auth0');
        
        return $auth0->getSdk()->login(
            route('auth0.callback'),  // 'callback' yerine 'auth0.callback' kullanın
            null,    // organization
            null,    // invitation
            null,    // screen hint
            null,    // login hint
            [
                'scope' => 'openid profile email',
            ]
        );
    }

    public function callback(Request $request)
    {
        $auth0 = app('auth0');
        
        // Auth0 exchange işlemi
        $auth0->exchange();
        
        // Kullanıcı bilgilerini al
        $credentials = $auth0->getCredentials();
        $userInfo = $credentials ? $credentials->user : null;

        if (!$userInfo) {
            return redirect()->route('login')->with('error', 'Authentication failed');
        }

        try {
            // Kullanıcıyı bul veya oluştur
            $user = User::updateOrCreate(
                ['email' => $userInfo['email']],
                [
                    'name' => $userInfo['name'] ?? $userInfo['nickname'] ?? null,
                    'auth0_id' => $userInfo['sub'],
                    'password' => Hash::make(Str::random(16)),
                    'photo' => $userInfo['picture'] ?? null,
                    'country' => null,
                    'city' => null,
                    'email_verified' => $userInfo['email_verified'] ?? false,
                ]
            );

            // Kullanıcıyı giriş yaptır
            Auth::login($user);

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('login')->with('error', 'An error occurred during authentication');
        }
    }

    public function logout()
    {
        Auth::logout();
        
        $auth0 = app('auth0');
        
        return redirect(
            $auth0->getSdk()
                ->authentication()
                ->getLogoutLink(
                    route('login'),
                    ['client_id' => config('auth0.client_id')]
                )
        );
    }
}