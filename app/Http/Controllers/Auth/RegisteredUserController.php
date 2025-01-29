<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9])(?=.*[^A-Za-z0-9])/', // En az 1 sayı ve 1 özel karakter
            ],
            'name' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ], [
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.regex' => 'Şifre en az 1 sayı ve 1 özel karakter içermelidir.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'photo.max' => 'Fotoğraf boyutu en fazla 2MB olabilir.',
        ]);

        // Fotoğraf işleme
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
        }

        // User oluşturma
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'country' => $request->country,
            'city' => $request->city,
            'photo' => $photoPath,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}