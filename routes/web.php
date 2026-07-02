<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\IndustriController;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Monitoring\KehadiranController;
use App\Http\Controllers\Monitoring\LaporanHarianController;
use App\Http\Controllers\Monitoring\PenilaianController;
use App\Http\Controllers\Monitoring\KunjunganIndustriController;
use App\Http\Controllers\DashboardController;
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
    Route::post('/magic-link', [MagicLinkController::class, 'sendMagicLink'])->middleware('throttle:5,1'); // BUG-16: Rate limiting
    Route::get('/magic-link/login/{user}', [MagicLinkController::class, 'loginWithMagicLink'])->name('magic.login');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Kehadiran (Absensi) — Khusus Siswa (BUG-7 fix)
    Route::middleware('role:siswa')->group(function () {
        Route::post('/absen/check-in', [KehadiranController::class, 'checkIn'])->name('absen.checkin');
        Route::post('/absen/check-out', [KehadiranController::class, 'checkOut'])->name('absen.checkout');

        // Laporan Harian / Jurnal — Submit oleh Siswa (BUG-8 fix)
        Route::post('/laporan/store', [LaporanHarianController::class, 'store'])->name('laporan.store');
    });

    // Review Laporan — Khusus Pembimbing & Industri (BUG-6 fix)
    Route::middleware('role:pembimbing|industri')->group(function () {
        Route::post('/laporan/review/{id}', [LaporanHarianController::class, 'review'])->name('laporan.review');
    });

    // Penilaian Sikap — Khusus Pembimbing (BUG-8 fix)
    Route::middleware('role:pembimbing')->group(function () {
        Route::post('/nilai/sikap', [PenilaianController::class, 'storeSikap'])->name('nilai.sikap');
    });

    // Penilaian Kompetensi — Khusus Industri (BUG-8 fix)
    Route::middleware('role:industri')->group(function () {
        Route::post('/nilai/kompetensi', [PenilaianController::class, 'storeKompetensi'])->name('nilai.kompetensi');
    });

    // Finalisasi & Export Nilai — Khusus Admin/Koordinator (BUG-8, BUG-13 fix)
    Route::middleware('role:admin|koordinator')->group(function () {
        Route::post('/nilai/finalisasi', [PenilaianController::class, 'finalisasi'])->name('nilai.finalisasi');
        Route::get('/nilai/export-excel', [PenilaianController::class, 'exportExcel'])->name('nilai.export');
    });

    // Cetak Rapor — Admin/Koordinator/Pembimbing + Siswa (sendiri) (BUG-12 fix)
    Route::middleware('role:admin|koordinator|pembimbing|siswa')->group(function () {
        Route::get('/nilai/cetak/{id_siswa}', [PenilaianController::class, 'cetakRapor'])->name('nilai.cetak');
    });

    // Kunjungan Industri — Khusus Pembimbing (BUG-8 fix)
    Route::middleware('role:pembimbing')->group(function () {
        Route::post('/kunjungan/store', [KunjunganIndustriController::class, 'store'])->name('kunjungan.store');
    });

    // Dashboard routes per role
    Route::middleware('role:admin|koordinator')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        // CRUD Master Data — Hanya route yang memiliki method di controller (BUG-4 fix)
        // Siswa
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

        // Kelas
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::put('/kelas/{kela}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/kelas/{kela}', [KelasController::class, 'destroy'])->name('kelas.destroy');

        // Industri
        Route::get('/industri', [IndustriController::class, 'index'])->name('industri.index');
        Route::post('/industri', [IndustriController::class, 'store'])->name('industri.store');
        Route::put('/industri/{industri}', [IndustriController::class, 'update'])->name('industri.update');
        Route::delete('/industri/{industri}', [IndustriController::class, 'destroy'])->name('industri.destroy');

        // Penugasan
        Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
        Route::post('/penugasan', [PenugasanController::class, 'store'])->name('penugasan.store');
        Route::put('/penugasan/{penugasan}', [PenugasanController::class, 'update'])->name('penugasan.update');
        Route::delete('/penugasan/{penugasan}', [PenugasanController::class, 'destroy'])->name('penugasan.destroy');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('role:pembimbing')->prefix('pembimbing')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pembimbing'])->name('pembimbing.dashboard');
    });

    Route::middleware('role:industri')->prefix('industri')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'industri'])->name('industri.dashboard');
    });

    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('siswa.dashboard');
        Route::get('/riwayat', [DashboardController::class, 'siswaRiwayat'])->name('siswa.riwayat');

        // Export Kehadiran ke Excel/CSV
        Route::get('/riwayat/export/kehadiran', [DashboardController::class, 'siswaExportKehadiran'])->name('siswa.export.kehadiran');

        // Export Jurnal Harian ke Excel/CSV
        Route::get('/riwayat/export/jurnal', [DashboardController::class, 'siswaExportJurnal'])->name('siswa.export.jurnal');
    });

    // Notifikasi
    Route::get('/notifikasi/read/{id}', [DashboardController::class, 'readAndRedirectNotification'])->name('notifikasi.read-and-redirect');
    Route::post('/notifikasi/read-all', [DashboardController::class, 'readAllNotifications'])->name('notifikasi.read-all');
});
