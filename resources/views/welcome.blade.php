<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Monitoring PKL - SMK Advance</title>

    <!-- Google Fonts: Instrument Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light text-slate">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="fw-bold text-primary fs-6">💻 SMK Advance</span>
                <span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">Monitoring PKL</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2 mt-2 mt-lg-0">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('koordinator'))
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm px-3 fw-medium">Dashboard Admin</a>
                                @elseif(Auth::user()->hasRole('pembimbing'))
                                    <a href="{{ route('pembimbing.dashboard') }}" class="btn btn-outline-primary btn-sm px-3 fw-medium">Dashboard Guru</a>
                                @elseif(Auth::user()->hasRole('industri'))
                                    <a href="{{ route('industri.dashboard') }}" class="btn btn-outline-primary btn-sm px-3 fw-medium">Dashboard Industri</a>
                                @elseif(Auth::user()->hasRole('siswa'))
                                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-primary btn-sm px-3 fw-medium">Dashboard Siswa</a>
                                @else
                                    <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm px-3 fw-medium">Dashboard</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-link nav-link btn-sm text-secondary px-3">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 fw-medium text-white">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 bg-white text-center border-bottom">
        <div class="container py-3">
            <h1 class="display-6 fw-bold text-primary mb-3">Monitoring PKL SMK Advance</h1>
            <p class="text-secondary mx-auto mb-4" style="max-width: 600px; font-size: 0.95rem; line-height: 1.6;">
                Platform terintegrasi yang memantau praktikk kerja lapangan siswa secara real-time, 
                mempermudah guru dalam pembimbingan, serta menyederhanakan administrasi penilaian bagi mitra industri.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="#fitur" class="btn btn-outline-secondary btn-sm px-4">Pelajari Fitur</a>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 text-white fw-medium">Mulai Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Roles Grid Section -->
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h5 fw-bold text-primary mb-2">Solusi untuk Semua Pihak</h2>
                <p class="text-secondary" style="font-size: 0.875rem;">Dirancang khusus untuk kenyamanan interaksi tiga pilar PKL</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <!-- Siswa Card -->
                <div class="col-md-4">
                    <div class="card h-100 p-4 bg-white">
                        <div class="mb-3 text-primary fs-4">👨‍🎓</div>
                        <h3 class="h6 fw-bold text-primary mb-2">Bagi Siswa</h3>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                            Kemudahan absensi harian berbasis lokasi (Geofencing), pencatatan jurnal aktivitas harian secara <em>Offline-First</em> (PWA), serta ekspor otomatis ke logbook fisik di akhir periode.
                        </p>
                    </div>
                </div>

                <!-- Guru Card -->
                <div class="col-md-4">
                    <div class="card h-100 p-4 bg-white">
                        <div class="mb-3 text-success fs-4">👩‍🏫</div>
                        <h3 class="h6 fw-bold text-primary mb-2">Bagi Guru & Pembimbing</h3>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                            Monitoring kehadiran real-time terverifikasi lokasi GPS, asisten AI untuk deteksi dini masalah (*Red-Flag*) pada jurnal siswa, dan optimasi rute peta untuk efisiensi kunjungan industri fisik.
                        </p>
                    </div>
                </div>

                <!-- Industri Card -->
                <div class="col-md-4">
                    <div class="card h-100 p-4 bg-white">
                        <div class="mb-3 text-info fs-4">🏢</div>
                        <h3 class="h6 fw-bold text-primary mb-2">Bagi Mitra Industri (DU-DI)</h3>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                            Akses instan menggunakan <em>Magic Link</em> WhatsApp/Email tanpa ribet password, rubrik evaluasi kompetensi dinamis sesuai jurusan siswa, serta akses *Talent Pool* untuk rekrutmen alumni terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 mt-auto">
        <div class="container text-center">
            <p class="text-secondary mb-0" style="font-size: 0.8rem;">
                &copy; {{ date('Y') }} SMK Advance Surabaya. Hak Cipta Dilindungi.
            </p>
            <p class="text-secondary mt-1 mb-0" style="font-size: 0.75rem;">
                Platform Monitoring PKL Terintegrasi v1.0
            </p>
        </div>
    </footer>

</body>
</html>
