<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-PKL Monitoring') - SMK Advance</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            font-size: 0.875rem; /* 14px */
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
        }
        .badge-role {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 20px;
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-2 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-shield-check text-primary me-2 fs-5"></i>
                <span>E-MONITORING <span class="text-primary">PKL</span></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Nav Links based on Role -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('koordinator'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/siswa*') ? 'active' : '' }}" href="{{ route('siswa.index') }}">
                                    <i class="bi bi-people me-1"></i> Siswa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/industri*') ? 'active' : '' }}" href="{{ route('industri.index') }}">
                                    <i class="bi bi-building me-1"></i> Industri
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/penugasan*') ? 'active' : '' }}" href="{{ route('penugasan.index') }}">
                                    <i class="bi bi-journal-check me-1"></i> Alokasi PKL
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->hasRole('pembimbing'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pembimbing/dashboard') ? 'active' : '' }}" href="{{ route('pembimbing.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard Guru
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->hasRole('industri'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('industri/dashboard') ? 'active' : '' }}" href="{{ route('industri.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard Industri
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->hasRole('siswa'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('siswa/dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard Siswa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('siswa/riwayat') ? 'active' : '' }}" href="{{ route('siswa.riwayat') }}">
                                    <i class="bi bi-calendar3 me-1"></i> Riwayat & Jurnal
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right Profile / Auth Action -->
                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle btn-sm d-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-6"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="badge bg-primary text-white badge-role text-uppercase">
                                    {{ Auth::user()->roles->first()->name ?? 'Pengguna' }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="profileDropdown">
                                <li>
                                    <div class="px-3 py-2 text-muted" style="font-size: 0.8rem;">
                                        Username: {{ Auth::user()->username }}<br>
                                        Email: {{ Auth::user()->email }}
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right"></i> Keluar Aplikasi
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sistem
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-start border-success border-4 py-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>
                    <div><strong>Sukses!</strong> {{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4 py-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-3"></i>
                    <div><strong>Gagal!</strong> {{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4 py-3 mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-octagon-fill text-danger fs-5 me-3 mt-1"></i>
                    <div>
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-muted py-3 mt-auto border-top border-secondary">
        <div class="container text-center">
            <p class="mb-0 small">&copy; {{ date('Y') }} E-Monitoring PKL SMK Advance. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
