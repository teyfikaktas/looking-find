<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery ve UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Lodash -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <style>
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .search-btn {
            background-color: #0d6efd;
            color: white;
            padding: 0.5rem 1rem;
        }
        .search-btn:hover {
            background-color: #0b5ed7;
            color: white;
        }
        .profile-dropdown .dropdown-toggle::after {
            display: none;
        }
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .profile-dropdown .dropdown-menu {
            right: 0;
            left: auto;
            min-width: 260px;
            margin-top: 0.5rem;
        }
        .user-name {
            font-weight: 500;
            color: #333;
            margin-left: 10px;
        }
        .dropdown-item {
            padding: 0.7rem 1.5rem;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        .btn-login, .btn-register {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        .navbar-brand img {
            height: 40px;
            transition: transform 0.2s;
        }
        .navbar-brand img:hover {
            transform: scale(1.05);
        }
        /* Dil seçici stilleri */
        .language-switcher {
            margin-right: 15px;
        }
        .language-switcher .dropdown-toggle {
            display: flex;
            align-items: center;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
        }
        .language-switcher .dropdown-toggle:hover {
            background: #f8f9fa;
        }
        .language-flag {
            width: 20px;
            height: 15px;
            margin-right: 5px;
        }
    </style>

    @yield('styles')
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/left-logo.png') }}" alt="Logo" height="40">
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <!-- Dil seçici -->
                <div class="language-switcher">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://flagcdn.com/w20/tr.png" alt="Türkçe" class="language-flag" id="selectedFlag">
                            <span id="selectedLang">TR</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-lang="tr" data-flag="tr">
                                    <img src="https://flagcdn.com/w20/tr.png" alt="Türkçe" class="language-flag"> Türkçe
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-lang="en" data-flag="gb">
                                    <img src="https://flagcdn.com/w20/gb.png" alt="English" class="language-flag"> English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                @auth
                    <div class="dropdown profile-dropdown">
                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil" class="profile-image">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Profil" class="profile-image">
                                @endif
                                <span class="ms-2 d-none d-lg-inline user-name">{{ Auth::user()->name }}</span>
                            </div>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="profileDropdown">
                            <li class="dropdown-header px-4 py-3">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit"></i> <span data-translate="profile_edit">Profili Düzenle</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-columns"></i> <span data-translate="dashboard">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-file-alt"></i> <span data-translate="applications">Başvurularım</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-sign-out-alt"></i> <span data-translate="logout">Çıkış Yap</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i><span data-translate="login">Giriş Yap</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-register ms-2">
                            <i class="fas fa-user-plus me-2"></i><span data-translate="register">Kayıt Ol</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Dil değiştirici script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const translations = {
            'tr': {
                // Navbar ve Profil Dropdown
                'profile_edit': 'Profili Düzenle',
                'dashboard': 'Dashboard',
                'applications': 'Başvurularım',
                'logout': 'Çıkış Yap',
                'login': 'Giriş Yap',
                'register': 'Kayıt Ol',
                
                // Profil Düzenleme Sayfası
                'profile_information': 'Profil Bilgileri',
                'profile_info_text': 'Profil bilgilerinizi ve email adresinizi güncelleyin.',
                'name': 'İsim',
                'email': 'E-posta',
                'save': 'Kaydet',
                'saved': 'Kaydedildi',
                
                // Şifre Güncelleme
                'update_password': 'Şifre Güncelleme',
                'update_password_text': 'Güvenliğiniz için uzun ve karmaşık bir şifre kullanın.',
                'current_password': 'Mevcut Şifre',
                'new_password': 'Yeni Şifre',
                'confirm_password': 'Şifre Tekrar',
                
                // Profil Fotoğrafı
                'profile_photo': 'Profil Fotoğrafı',
                'select_photo': 'Fotoğraf Seç',
                'remove_photo': 'Fotoğrafı Kaldır',
                
                // Hesap Silme
                'delete_account': 'Hesabı Sil',
                'delete_account_text': 'Hesabınız silindiğinde, tüm kaynakları ve verileri kalıcı olarak silinecektir.',
                'delete_account_button': 'Hesabı Sil',
                
                // Validation ve Uyarılar
                'required_field': 'Bu alan zorunludur',
                'min_characters': 'En az {min} karakter olmalıdır',
                'email_invalid': 'Geçerli bir e-posta adresi giriniz',
                'password_not_match': 'Şifreler eşleşmiyor',
                'success_message': 'Başarıyla güncellendi',
                'error_message': 'Bir hata oluştu'
            },
            'en': {
                // Navbar and Profile Dropdown
                'profile_edit': 'Edit Profile',
                'dashboard': 'Dashboard',
                'applications': 'My Applications',
                'logout': 'Logout',
                'login': 'Login',
                'register': 'Register',
                
                // Profile Edit Page
                'profile_information': 'Profile Information',
                'profile_info_text': 'Update your profile information and email address.',
                'name': 'Name',
                'email': 'Email',
                'save': 'Save',
                'saved': 'Saved',
                
                // Password Update
                'update_password': 'Update Password',
                'update_password_text': 'Use a long, random password to stay secure.',
                'current_password': 'Current Password',
                'new_password': 'New Password',
                'confirm_password': 'Confirm Password',
                
                // Profile Photo
                'profile_photo': 'Profile Photo',
                'select_photo': 'Select Photo',
                'remove_photo': 'Remove Photo',
                
                // Account Deletion
                'delete_account': 'Delete Account',
                'delete_account_text': 'Once your account is deleted, all of its resources and data will be permanently deleted.',
                'delete_account_button': 'Delete Account',
                
                // Validation and Alerts
                'required_field': 'This field is required',
                'min_characters': 'Must be at least {min} characters',
                'email_invalid': 'Please enter a valid email address',
                'password_not_match': 'Passwords do not match',
                'success_message': 'Successfully updated',
                'error_message': 'An error occurred'
            }
        };

        // Dil değiştirme işlevi
        function changeLang(lang) {
            const elements = document.querySelectorAll('[data-translate]');
            elements.forEach(element => {
                const key = element.getAttribute('data-translate');
                if (translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });
            
            // Placeholder'ları güncelle
            const placeholders = document.querySelectorAll('[data-translate-placeholder]');
            placeholders.forEach(element => {
                const key = element.getAttribute('data-translate-placeholder');
                if (translations[lang][key]) {
                    element.placeholder = translations[lang][key];
                }
            });
            
            // Title'ları güncelle
            const titles = document.querySelectorAll('[data-translate-title]');
            titles.forEach(element => {
                const key = element.getAttribute('data-translate-title');
                if (translations[lang][key]) {
                    element.title = translations[lang][key];
                }
            });
            
// Seçili dili güncelle
document.getElementById('selectedLang').textContent = lang.toUpperCase();
            document.getElementById('selectedFlag').src = `https://flagcdn.com/w20/${lang === 'en' ? 'gb' : 'tr'}.png`;
            
            // Dili localStorage'a kaydet
            localStorage.setItem('selectedLang', lang);
        }

        // Dil seçeneklerine tıklama olayı
        document.querySelectorAll('.dropdown-item[data-lang]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                changeLang(this.getAttribute('data-lang'));
            });
        });

        // Sayfa yüklendiğinde kaydedilmiş dili kontrol et
        const savedLang = localStorage.getItem('selectedLang') || 'tr';
        changeLang(savedLang);
    });
    </script>

    @yield('scripts')
</body>
</html>