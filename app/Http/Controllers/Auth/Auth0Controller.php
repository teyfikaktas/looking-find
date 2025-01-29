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
    
        return $auth0->getSdk()->login(
            null,       // $redirectUri
            null,       // $organization
            null,       // $invitation
            null,       // $screenHint
            null,       // $loginHint
            [
                'scope' => 'openid profile email',
            ]
        );
    }
    

    public function callback(Request $request)
    {
        $auth0 = app('auth0');
        // Kod değişimi
        $auth0->exchange();

        $credentials = $auth0->getCredentials();
        $userInfo = $credentials ? $credentials->user : null;

        if (! $userInfo) {
            return redirect()->route('login');
        }

        // Auth0 User => Laravel User eşleştirme
        $user = User::updateOrCreate(
            [ 'email' => $userInfo['email'] ],
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
            app('auth0')
                ->getSdk()
                ->authentication()
                ->getLogoutLink(route('login'))
        );
    }
}
