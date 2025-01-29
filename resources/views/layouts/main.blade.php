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
                                    <i class="fas fa-user-edit"></i> Profili Düzenle
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-columns"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-file-alt"></i> Başvurularım
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-register ms-2">
                            <i class="fas fa-user-plus me-2"></i>Kayıt Ol
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

    @yield('scripts')
</body>
</html>