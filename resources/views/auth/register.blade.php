<x-guest-layout>
    <!-- Laravel'in varsayılan logosunu kaldırmak için app.blade.php'de logo kısmını kaldırın -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/left-logo.png') }}" alt="Logo" class="w-48 h-auto">
            </div>

            <!-- Başlık -->
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">
                Hesap Oluştur
            </h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Ad Soyad -->
                <div>
                    <x-input-label for="name" value="Ad Soyad" class="text-gray-700" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="text" name="name" :value="old('name')" required autofocus placeholder="Ad Soyad giriniz" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" value="E-posta" class="text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="email" name="email" :value="old('email')" required placeholder="E-posta adresinizi giriniz" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Lokasyon -->
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Ülke -->
                    <div>
                        <x-input-label for="country" value="Ülke" class="text-gray-700" />
                        <x-text-input id="country" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="text" name="country" :value="old('country')" required placeholder="Ülke seçiniz" />
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>

                    <!-- Şehir -->
                    <div>
                        <x-input-label for="city" value="Şehir" class="text-gray-700" />
                        <x-text-input id="city" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="text" name="city" :value="old('city')" required placeholder="Şehir seçiniz" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                </div>

                <!-- Profil Fotoğrafı -->
                <div class="mt-4">
                    <x-input-label for="photo" value="Profil Fotoğrafı" class="text-gray-700" />
                    <div class="mt-1 flex items-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                            <img id="preview" src="{{ asset('images/default-avatar.png') }}" alt="Önizleme" class="w-full h-full rounded-full object-cover hidden">
                            <span id="placeholder" class="text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                        </div>
                        <input id="photo" type="file" name="photo" class="hidden" accept="image/*" />
                        <button type="button" onclick="document.getElementById('photo').click()" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Fotoğraf Seç
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <!-- Şifre Bölümü -->
                <div class="mt-4 space-y-4">
                    <div>
                        <x-input-label for="password" value="Şifre" class="text-gray-700" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="password" name="password" required placeholder="Şifrenizi giriniz" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Şifre Tekrar" class="text-gray-700" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="password" name="password_confirmation" required placeholder="Şifrenizi tekrar giriniz" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-indigo-600 hover:text-indigo-900" href="{{ route('login') }}">
                        Zaten hesabınız var mı?
                    </a>

                    <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700">
                        Kayıt Ol
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script>
        // Autocomplete
        $(document).ready(function() {
            $("#city").autocomplete({
                source: "{{ route('autocomplete.cities') }}",
                minLength: 2,
                select: function(event, ui) {
                    $("#city").val(ui.item.value);
                }
            }).autocomplete("instance")._renderItem = function(ul, item) {
                return $("<li>")
                    .append("<div class='px-4 py-2'>" + item.label + "</div>")
                    .appendTo(ul);
            };
        });

        // Fotoğraf önizleme
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    const placeholder = document.getElementById('placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 9999 !important;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 0.5rem 0;
            width: auto !important;
            min-width: 200px;
        }
        .ui-menu-item {
            margin: 0;
            padding: 0;
        }
        .ui-menu-item div {
            padding: 8px 16px;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .ui-menu-item div:hover {
            background-color: #f3f4f6;
        }
        .ui-state-active div {
            background-color: #e5e7eb !important;
            border: none !important;
        }
    </style>
</x-guest-layout>