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
        return Auth0::withGuard('web')->login(route('callback'));
    }

    public function callback(Request $request)
    {
        // Auth0 exchange işlemi
        Auth0::exchange();
        
        // Kullanıcı bilgilerini al
        $userInfo = Auth0::getUser();

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
        
        return redirect(
            Auth0::getSdk()
                ->authentication()
                ->getLogoutLink(
                    route('login'),
                    ['client_id' => config('auth0.client_id')]
                )
        );
    }
}