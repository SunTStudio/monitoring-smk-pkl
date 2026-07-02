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

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 4px 8px;
            font-size: 0.85rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 4px 12px;
            font-size: 0.85rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
            background-color: #0f172a !important;
            border-color: #0f172a !important;
            color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_paginate .page-link {
            color: #334155;
            border-radius: 6px;
            margin: 0 2px;
        }
        table.dataTable {
            border-collapse: collapse !important;
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }
        table.dataTable thead th {
            border-bottom: 2px solid #e2e8f0 !important;
        }
    </style>

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
        
        /* Premium Custom Dropdown styling */
        .dropdown-menu-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
            padding: 8px;
            background-color: #ffffff;
        }
        .dropdown-menu-custom .dropdown-item {
            font-weight: 500;
            color: #475569;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
        }
        .dropdown-menu-custom .dropdown-item i {
            font-size: 1.1rem;
            transition: transform 0.2s ease;
        }
        .dropdown-menu-custom .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .dropdown-menu-custom .dropdown-item:hover i {
            transform: scale(1.1);
        }
        .dropdown-menu-custom .dropdown-item.active {
            background-color: #0f172a;
            color: #ffffff;
        }
        .dropdown-menu-custom .dropdown-item.active i {
            color: #ffffff !important;
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
                                <a class="nav-link {{ request()->is('admin/kelas*') ? 'active' : '' }}" href="{{ route('kelas.index') }}">
                                    <i class="bi bi-folder2-open me-1"></i> Kelas
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
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-person-gear me-1"></i> Akun
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
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('industri/dashboard*') ? 'active' : '' }}" href="#" id="industriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-building me-1"></i> Dashboard Industri
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom mt-2 shadow" aria-labelledby="industriDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('industri/dashboard') && !request('tab') ? 'active' : '' }}" href="{{ route('industri.dashboard', request()->only(['siswa_id', 'tgl_mulai', 'tgl_akhir'])) }}">
                                            <i class="bi bi-speedometer2 me-2 text-warning"></i> Dashboard Utama
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('tab') == 'kehadiran' ? 'active' : '' }}" href="{{ route('industri.dashboard', array_merge(request()->only(['siswa_id', 'tgl_mulai', 'tgl_akhir']), ['tab' => 'kehadiran'])) }}">
                                            <i class="bi bi-geo-alt-fill me-2 text-danger"></i> Log Kehadiran Siswa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request('tab') == 'jurnal' ? 'active' : '' }}" href="{{ route('industri.dashboard', array_merge(request()->only(['siswa_id', 'tgl_mulai', 'tgl_akhir']), ['tab' => 'jurnal'])) }}">
                                            <i class="bi bi-journal-richtext me-2 text-primary"></i> Jurnal Harian Siswa
                                        </a>
                                    </li>
                                </ul>
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
                        {{-- BUG-15 fix: Notifikasi sekarang di-inject oleh ViewServiceProvider --}}
                        {{-- $unreadNotifications dan $allNotifications sudah tersedia via ViewComposer --}}
                        <div class="dropdown me-3">
                            <button class="btn btn-link text-white position-relative p-1" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                <i class="bi bi-bell fs-5"></i>
                                @if($unreadNotifications->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.25em 0.5em;">
                                        {{ $unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0" aria-labelledby="notificationDropdown" style="width: 320px; font-size: 0.825rem; max-height: 400px; overflow-y: auto;">
                                <li class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                                    <h6 class="fw-bold mb-0 text-dark">Notifikasi</h6>
                                    @if($unreadNotifications->count() > 0)
                                        <form action="{{ route('notifikasi.read-all') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">
                                                Tandai Semua Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </li>
                                @forelse($allNotifications as $notif)
                                    @php
                                        // Dynamic action link resolver
                                        $targetLink = '#';
                                        if ($notif->tipe_referensi === 'laporan_harian') {
                                            if (Auth::user()->hasRole('pembimbing')) {
                                                $targetLink = route('pembimbing.dashboard', ['siswa_id' => $notif->id_referensi]);
                                            } elseif (Auth::user()->hasRole('industri')) {
                                                $targetLink = route('industri.dashboard', ['siswa_id' => $notif->id_referensi]);
                                            }
                                        } elseif (in_array($notif->tipe_referensi, ['penilaian_sikap', 'penilaian_kompetensi', 'nilai_akhir'])) {
                                            $targetLink = route('siswa.dashboard');
                                        }
                                        
                                        $bgClass = $notif->status_dibaca ? '' : 'bg-light border-start border-primary border-3';
                                        $iconClass = 'bi-info-circle text-info';
                                        if ($notif->tipe_notifikasi === 'success') $iconClass = 'bi-check-circle text-success';
                                        if ($notif->tipe_notifikasi === 'warning') $iconClass = 'bi-exclamation-triangle text-warning';
                                        if ($notif->tipe_notifikasi === 'error') $iconClass = 'bi-exclamation-octagon text-danger';
                                    @endphp
                                    <li class="{{ $bgClass }}">
                                        <a class="dropdown-item d-flex gap-3 px-3 py-2.5 text-wrap border-bottom align-items-start" href="{{ route('notifikasi.read-and-redirect', $notif->id_notifikasi) }}">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <i class="bi {{ $iconClass }} fs-6"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark">{{ $notif->judul_notifikasi }}</div>
                                                <div class="text-secondary small mt-0.5" style="line-height: 1.25;">{{ $notif->pesan_notifikasi }}</div>
                                                <div class="text-muted small mt-1" style="font-size: 0.7rem;">
                                                    {{ \Carbon\Carbon::parse($notif->tgl_notifikasi)->diffForHumans() }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="p-4 text-center text-muted">
                                        <i class="bi bi-bell-slash fs-4 mb-2 d-block text-secondary"></i>
                                        Tidak ada notifikasi baru
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Profile Dropdown -->
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
            <p class="mb-0 small text-light">&copy; {{ date('Y') }} E-Monitoring PKL SMK Advance. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery and DataTables CDN JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto initialize datatables
            $('.datatable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari Cepat:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
