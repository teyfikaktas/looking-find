<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/left-logo.png') }}" alt="Logo" class="w-32 h-auto">
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- E-posta Adresi -->
                <div>
                    <x-input-label for="email" :value="__('E-posta')" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Şifre -->
                <div>
                    <x-input-label for="password" :value="__('Şifre')" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Beni Hatırla -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Beni hatırla') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-500 underline" 
                            href="{{ route('password.request') }}">
                            Şifremi unuttum
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                        Giriş Yap
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>