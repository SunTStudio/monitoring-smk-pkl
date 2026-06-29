<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\IndustriController;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\Monitoring\KehadiranController;
use App\Http\Controllers\Monitoring\LaporanHarianController;
use App\Http\Controllers\Monitoring\PenilaianController;
use App\Http\Controllers\Monitoring\KunjunganIndustriController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/magic-link', [MagicLinkController::class, 'showRequestForm'])->name('magic.request');
    Route::post('/magic-link', [MagicLinkController::class, 'sendMagicLink']);
    Route::get('/magic-link/login/{user}', [MagicLinkController::class, 'loginWithMagicLink'])->name('magic.login');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Kehadiran (Absensi)
    Route::post('/absen/check-in', [KehadiranController::class, 'checkIn'])->name('absen.checkin');
    Route::post('/absen/check-out', [KehadiranController::class, 'checkOut'])->name('absen.checkout');

    // Laporan Harian (Jurnal)
    Route::post('/laporan/store', [LaporanHarianController::class, 'store'])->name('laporan.store');
    Route::post('/laporan/review/{id}', [LaporanHarianController::class, 'review'])->name('laporan.review');

    // Penilaian
    Route::post('/nilai/sikap', [PenilaianController::class, 'storeSikap'])->name('nilai.sikap');
    Route::post('/nilai/kompetensi', [PenilaianController::class, 'storeKompetensi'])->name('nilai.kompetensi');
    Route::post('/nilai/finalisasi', [PenilaianController::class, 'finalisasi'])->name('nilai.finalisasi');

    // Kunjungan Industri
    Route::post('/kunjungan/store', [KunjunganIndustriController::class, 'store'])->name('kunjungan.store');

    // Dashboard routes per role
    Route::middleware('role:admin|koordinator')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            $siswaCount = \App\Models\Siswa::count();
            $siswaAktifCount = \App\Models\Penugasan::where('status', 'aktif')->count();
            $industriCount = \App\Models\Industri::count();
            
            $assignedSiswaIds = \App\Models\Penugasan::where('status', 'aktif')->pluck('id_siswa_fk')->toArray();
            $belumDitempatkanCount = \App\Models\Siswa::whereNotIn('id_siswa', $assignedSiswaIds)->count();

            return view('admin.dashboard', compact('siswaCount', 'siswaAktifCount', 'industriCount', 'belumDitempatkanCount'));
        })->name('admin.dashboard');

        // CRUD Master Data
        Route::resource('siswa', SiswaController::class);
        Route::resource('industri', IndustriController::class);
        Route::resource('penugasan', PenugasanController::class);
    });

    Route::middleware('role:pembimbing')->prefix('pembimbing')->group(function () {
        Route::get('/dashboard', function () {
            return view('pembimbing.dashboard');
        })->name('pembimbing.dashboard');
    });

    Route::middleware('role:industri')->prefix('industri')->group(function () {
        Route::get('/dashboard', function () {
            $penugasan = \App\Models\Penugasan::with(['siswa', 'industri'])
                ->where('id_pengguna_industri_fk', auth()->id())
                ->get();

            $siswaIds = $penugasan->pluck('id_siswa_fk')->toArray();
            $kehadiran = \App\Models\Kehadiran::with('siswa')
                ->whereIn('id_siswa_fk', $siswaIds)
                ->orderBy('tgl_absen', 'desc')
                ->orderBy('waktu_checkin', 'desc')
                ->get();

            return view('industri.dashboard', compact('penugasan', 'kehadiran'));
        })->name('industri.dashboard');
    });

    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/dashboard', function () {
            $siswa = \App\Models\Siswa::where('id_pengguna_fk', auth()->id())->first();
            $penugasanAktif = null;
            $kehadiranHariIni = null;
            if ($siswa) {
                $penugasanAktif = \App\Models\Penugasan::with('industri')
                    ->where('id_siswa_fk', $siswa->id_siswa)
                    ->where('status', 'aktif')
                    ->first();

                $kehadiranHariIni = \App\Models\Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
                    ->where('tgl_absen', date('Y-m-d'))
                    ->first();
            }

            return view('siswa.dashboard', compact('siswa', 'penugasanAktif', 'kehadiranHariIni'));
        })->name('siswa.dashboard');

        Route::get('/riwayat', function () {
            $siswa = \App\Models\Siswa::where('id_pengguna_fk', auth()->id())->first();
            $kehadiran = [];
            $laporan = [];
            if ($siswa) {
                $kehadiran = \App\Models\Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
                    ->orderBy('tgl_absen', 'desc')
                    ->get();
                $laporan = \App\Models\LaporanHarian::where('id_siswa_fk', $siswa->id_siswa)
                    ->orderBy('tgl_laporan', 'desc')
                    ->get();
            }
            return view('siswa.riwayat', compact('kehadiran', 'laporan'));
        })->name('siswa.riwayat');
    });
});
