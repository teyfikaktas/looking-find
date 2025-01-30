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
<!-- Custom CSS içindeki stil güncellemeleri -->
<style>
    :root {
        --primary-purple: #6934FF;
        --primary-purple-hover: #5729D9;
        --secondary-purple: #8B5CF6;
        --light-purple: #EDE9FE;
    }

    .navbar-custom {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,.08);
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Login Button */
    .btn-login {
        background-color: transparent;
        border: 2px solid var(--primary-purple);
        color: var(--primary-purple);
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background-color: var(--light-purple);
        border-color: var(--primary-purple-hover);
        color: var(--primary-purple-hover);
        transform: translateY(-1px);
    }

    /* Register Button */
    .btn-register {
        background-color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        color: white;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background-color: var(--primary-purple-hover);
        border-color: var(--primary-purple-hover);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(105, 52, 255, 0.2);
    }

    /* Profil Dropdown Güncellemeleri */
    .profile-dropdown .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .profile-dropdown .dropdown-item:hover {
        background-color: var(--light-purple);
        color: var(--primary-purple);
    }

    .profile-dropdown .dropdown-item i {
        color: var(--primary-purple);
    }

    /* Dil Seçici Güncellemeleri */
    .language-switcher .dropdown-toggle {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .language-switcher .dropdown-toggle:hover {
        border-color: var(--primary-purple);
        background-color: var(--light-purple);
    }

    .language-switcher .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .language-switcher .dropdown-item:hover {
        background-color: var(--light-purple);
    }

    /* Çıkış Butonu */
    .btn-danger {
        background-color: #FF4B55;
        border-color: #FF4B55;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #E6434D;
        border-color: #E6434D;
        transform: translateY(-1px);
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
                            <img src="{{ asset('storage/public/' . Auth::user()->photo) }}" alt="Profil" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #6934FF;">

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
                
                // Ana Sayfa
                'discover_opportunities': 'Kariyer Fırsatlarını Keşfet',
                'job_listings': 'iş ilanı on binlerce şirket',
                'search_position': 'Pozisyon, Şirket',
                'search_city': 'Şehir veya İlçe',
                'find_job': 'İş Bul',
                
                // Popüler Aramalar
                'finance_specialist': 'Finans Uzmanı',
                'digital_marketing': 'Dijital Pazarlama Uzmanı',
                'software_developer': 'Yazılım Geliştirme Uzmanı',
                'project_manager': 'Proje Yöneticisi',
                'hr_specialist': 'İK Uzmanı',
                
                // Şehirler
                'istanbul': 'İstanbul',
                'ankara': 'Ankara',
                'izmir': 'İzmir',
                'bursa': 'Bursa',
                
                // İş İlanları
                'featured_jobs': 'Öne Çıkan İlanlar',
                'view_details': 'Detayları Gör',
                'no_jobs': 'İş ilanı bulunmamaktadır.',
                
                // Autocomplete
                'search_positions': 'Pozisyonlarda ara...',
                
                // Validation ve Uyarılar
                'required_field': 'Bu alan zorunludur',
                'min_characters': 'En az {min} karakter olmalıdır',
                'email_invalid': 'Geçerli bir e-posta adresi giriniz',
                'password_not_match': 'Şifreler eşleşmiyor',
                'success_message': 'Başarıyla güncellendi',
                'error_message': 'Bir hata oluştu',

                // Genel Kullanım
                'welcome': 'Hoş Geldiniz',
                'search': 'Ara',
                'notifications': 'Bildirimler',
                'settings': 'Ayarlar',
                'help': 'Yardım',
                'about': 'Hakkında',
                'contact': 'İletişim',
                'terms': 'Kullanım Şartları',
                'privacy': 'Gizlilik Politikası',

                // Form ve Butonlar
                'submit': 'Gönder',
                'cancel': 'İptal',
                'edit': 'Düzenle',
                'delete': 'Sil',
                'view': 'Görüntüle',
                'download': 'İndir',
                'upload': 'Yükle',
                'close': 'Kapat',
                'back': 'Geri',
                'next': 'İleri',

                // Tarih ve Zaman
                'date': 'Tarih',
                'time': 'Saat',
                'today': 'Bugün',
                'yesterday': 'Dün',
                'tomorrow': 'Yarın'
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
                
                // Home Page
                'discover_opportunities': 'Discover Career Opportunities',
                'job_listings': 'job listings from thousands of companies',
                'search_position': 'Position, Company',
                'search_city': 'City or District',
                'find_job': 'Find Job',
                
                // Popular Searches
                'finance_specialist': 'Finance Specialist',
                'digital_marketing': 'Digital Marketing Specialist',
                'software_developer': 'Software Developer',
                'project_manager': 'Project Manager',
                'hr_specialist': 'HR Specialist',
                
                // Cities
                'istanbul': 'Istanbul',
                'ankara': 'Ankara',
                'izmir': 'Izmir',
                'bursa': 'Bursa',
                
                // Job Listings
                'featured_jobs': 'Featured Jobs',
                'view_details': 'View Details',
                'no_jobs': 'No job postings available.',
                
                // Autocomplete
                'search_positions': 'Search positions...',
                
                // Validation and Alerts
                'required_field': 'This field is required',
                'min_characters': 'Must be at least {min} characters',
                'email_invalid': 'Please enter a valid email address',
                'password_not_match': 'Passwords do not match',
                'success_message': 'Successfully updated',
                'error_message': 'An error occurred',

                // General Usage
                'welcome': 'Welcome',
                'search': 'Search',
                'notifications': 'Notifications',
                'settings': 'Settings',
                'help': 'Help',
                'about': 'About',
                'contact': 'Contact',
                'terms': 'Terms of Service',
                'privacy': 'Privacy Policy',

                // Forms and Buttons
                'submit': 'Submit',
                'cancel': 'Cancel',
                'edit': 'Edit',
                'delete': 'Delete',
                'view': 'View',
                'download': 'Download',
                'upload': 'Upload',
                'close': 'Close',
                'back': 'Back',
                'next': 'Next',

                // Date and Time
                'date': 'Date',
                'time': 'Time',
                'today': 'Today',
                'yesterday': 'Yesterday',
                'tomorrow': 'Tomorrow'
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