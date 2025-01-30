<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/left-logo.png') }}" alt="Logo" class="w-32 h-auto">
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <!-- Normal Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- E-posta Adresi -->
                <div>
                    <x-input-label for="email" :value="__('E-posta')" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Şifre -->
                <div>
                    <x-input-label for="password" :value="__('Şifre')" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Beni Hatırla -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Beni hatırla') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-500 underline" href="{{ route('password.request') }}">
                        Şifremi unuttum
                    </a>
                    @endif
                    <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                        Giriş Yap
                    </x-primary-button>
                </div>
            </form>

            <!-- Auth0 Login Button -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">veya</span>
                    </div>
                </div>

                <a href="" class="mt-4 w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0C5.383 0 0 5.383 0 12C0 18.617 5.383 24 12 24C18.617 24 24 18.617 24 12C24 5.383 18.617 0 12 0ZM12 4.8C14.727 4.8 17.1 6.284 18.507 8.487C17.1 10.69 14.727 12.174 12 12.174C9.273 12.174 6.9 10.69 5.493 8.487C6.9 6.284 9.273 4.8 12 4.8ZM12 19.2C8.56 19.2 5.493 17.127 4.02 14.113C6.9 12.567 9.273 11.826 12 11.826C14.727 11.826 17.1 12.567 19.98 14.113C18.507 17.127 15.44 19.2 12 19.2Z" fill="currentColor"/>
                    </svg>
                    Google ile Giriş Yap
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>