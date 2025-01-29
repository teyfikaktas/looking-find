<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Auth0\Laravel\Facade\Auth0;
use Auth0\Laravel\Contract\Auth0Contract;
class Auth0Controller extends Controller
{
    protected $auth0;

    public function __construct(Auth0Contract $auth0)
    {
        $this->auth0 = $auth0;
    }

    public function login()
    {
        return Auth0::withGuard('web')->login(route('callback'));
    }

    public function callback(Request $request)
    {
        // Auth0 exchange işlemi
        $this->auth0->exchange();
        
        // Kullanıcı bilgilerini al
        $userInfo = $this->auth0->getUser();

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

            // Session'a başarı mesajı ekle
            session()->flash('success', 'Successfully logged in!');

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            report($e); // Hatayı logla
            return redirect()->route('login')->with('error', 'An error occurred during authentication');
        }
    }

    public function logout()
    {
        Auth::logout();
        
        $returnTo = route('login');
        
        return redirect(
            $this->auth0->getSdk()
                ->authentication()
                ->getLogoutLink(
                    $returnTo,
                    ['client_id' => config('auth0.client_id')]
                )
        );
    }
}
