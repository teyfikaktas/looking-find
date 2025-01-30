<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
                'regex:/^(?=.*[0-9])(?=.*[^A-Za-z0-9])/',
            ],
            'name' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
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
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $photoPath = $file->storeAs('public/profile-photos', $filename);
            // public/ önekini kaldır, çünkü URL'de kullanırken storage/ olarak erişeceğiz
            $photoPath = str_replace('public/', '', $photoPath);
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

        Auth::guard('web')->login($user);

        return redirect()->route('home');
    }
}