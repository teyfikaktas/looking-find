<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <!-- Logo -->
        <div>
            <a href="/">
                <img src="{{ asset('images/left-logo.png') }}" alt="Logo" class="w-32">
            </a>
        </div>

        <div class="w-full sm:max-w-xl mt-6 px-8 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-row space-x-8">
                    <!-- Sol Taraf - Form Alanları -->
                    <div class="flex-1 space-y-4">
                        <!-- Ad -->
                        <div>
                            <x-input-label for="name" value="Ad:" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Soyad -->
                        <div>
                            <x-input-label for="surname" value="Soyad:" />
                            <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" />
                            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" value="Kullanıcı email:" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Şifre -->
                        <div>
                            <x-input-label for="password" value="Şifre:" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <div class="mt-1 text-sm text-gray-500">
                                En az 8 karakter, 1 sayı ve 1 özel karakter içermelidir
                            </div>
                        </div>

                        <!-- Şifre Tekrar -->
                        <div>
                            <x-input-label for="password_confirmation" value="Tekrar:" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Lokasyon -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="country" value="Ülke:" />
                                <select id="country" name="country" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="Türkiye">Türkiye</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="city" value="Şehir:" />
                                <select id="city" name="city" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                    <option value="İzmir">İzmir</option>
                                    <option value="Ankara">Ankara</option>
                                    <option value="İstanbul">İstanbul</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sağ Taraf - Fotoğraf Alanı -->
                    <div class="w-40 relative">
                        <div class="relative">
                            <div class="w-32 h-32 bg-gray-100 rounded-full overflow-hidden">
                                <img id="preview" src="{{ asset('images/default-avatar.png') }}" alt="Profil" class="w-full h-full object-cover">
                            </div>
                            <input id="photo" type="file" name="photo" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('photo').click()" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center absolute bottom-0 right-0 hover:bg-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kayıt Ol Butonu -->
                <div class="flex justify-start mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Kayıt OL
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <style>
        /* Input stilleri */
        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            width: 100%;
        }
        
        /* Select stilleri */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        /* Label stilleri */
        label {
            font-weight: 500;
        }

        /* Input focus stilleri */
        input:focus, select:focus {
            outline: none;
            border-color: #3b82f6;
            ring-color: #93c5fd;
        }
    </style>
</x-guest-layout>