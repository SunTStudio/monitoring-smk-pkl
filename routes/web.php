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
    Route::get('/nilai/cetak/{id_siswa}', [PenilaianController::class, 'cetakRapor'])->name('nilai.cetak');
    Route::get('/nilai/export-excel', [PenilaianController::class, 'exportExcel'])->name('nilai.export');

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
        Route::resource('kelas', KelasController::class);
        Route::resource('industri', IndustriController::class);
        Route::resource('penugasan', PenugasanController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware('role:pembimbing')->prefix('pembimbing')->group(function () {
        Route::get('/dashboard', function () {
            $penugasan = \App\Models\Penugasan::with(['siswa', 'industri'])
                ->where('id_pembimbing_fk', auth()->id())
                ->get();

            $siswaIds = $penugasan->pluck('id_siswa_fk')->toArray();

            $selectedSiswaId = request('siswa_id');
            $selectedSiswa = null;
            $selectedPenugasan = null;
            $penilaianSikapExisting = null;
            $rataJurnalDudi = 0;
            $rataJurnalGuru = 0;
            $nilaiKehadiran = 0;
            $prediksiNilaiAkhir = 0;
            $nilaiAkhirExisting = null;

            if ($selectedSiswaId) {
                $selectedSiswa = \App\Models\Siswa::find($selectedSiswaId);
                if ($selectedSiswa) {
                    $selectedPenugasan = $penugasan->where('id_siswa_fk', $selectedSiswa->id_siswa)->first();
                    
                    $penilaianSikapExisting = \App\Models\PenilaianSikap::where('id_siswa_fk', $selectedSiswa->id_siswa)
                        ->where('id_pembimbing_fk', auth()->id())
                        ->first();

                    if ($selectedPenugasan) {
                        // Hitung Kehadiran
                        $totalHariPkl = $selectedPenugasan->durasi_hari ?? 0;
                        $totalHariHadir = \App\Models\Kehadiran::where('id_penugasan_fk', $selectedPenugasan->id_penugasan)
                            ->whereIn('status_kehadiran', ['hadir', 'izin'])
                            ->count();
                        $nilaiKehadiran = $totalHariPkl > 0 ? (($totalHariHadir / $totalHariPkl) * 100) : 0;
                        if ($nilaiKehadiran > 100) $nilaiKehadiran = 100;

                        // Hitung Rata Jurnal Guru
                        $rataJurnalGuru = \App\Models\LaporanHarian::where('id_siswa_fk', $selectedSiswa->id_siswa)
                            ->whereNotNull('nilai_guru')
                            ->avg('nilai_guru') ?? 0;

                        // Hitung Rata Jurnal DUDI
                        $rataJurnalDudi = \App\Models\LaporanHarian::where('id_siswa_fk', $selectedSiswa->id_siswa)
                            ->whereNotNull('nilai_dudi')
                            ->avg('nilai_dudi') ?? 0;

                        // Hitung Prediksi Nilai Akhir
                        $prediksiNilaiAkhir = ($nilaiKehadiran * 0.20) + ($rataJurnalGuru * 0.30) + ($rataJurnalDudi * 0.50);

                        $nilaiAkhirExisting = \App\Models\NilaiAkhir::where('id_siswa_fk', $selectedSiswa->id_siswa)
                            ->where('id_penugasan_fk', $selectedPenugasan->id_penugasan)
                            ->first();
                    }
                }
            }

            // Filter kehadiran dan laporan jika siswa_id dipilih
            $kehadiranQuery = \App\Models\Kehadiran::with('siswa')->whereIn('id_siswa_fk', $siswaIds);
            $laporanJurnalQuery = \App\Models\LaporanHarian::with('siswa')->whereIn('id_siswa_fk', $siswaIds);

            if ($selectedSiswaId) {
                $kehadiranQuery->where('id_siswa_fk', $selectedSiswaId);
                $laporanJurnalQuery->where('id_siswa_fk', $selectedSiswaId);
            }

            $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->orderBy('waktu_checkin', 'desc')->get();
            $laporanJurnal = $laporanJurnalQuery->orderBy('tgl_laporan', 'desc')->get();

            $industriMitra = \App\Models\Industri::where('status', 'aktif')->get();

            return view('pembimbing.dashboard', compact(
                'penugasan', 'kehadiran', 'laporanJurnal', 'industriMitra',
                'selectedSiswaId', 'selectedSiswa', 'selectedPenugasan', 'penilaianSikapExisting',
                'rataJurnalDudi', 'rataJurnalGuru', 'nilaiKehadiran', 'prediksiNilaiAkhir', 'nilaiAkhirExisting'
            ));
        })->name('pembimbing.dashboard');
    });

    Route::middleware('role:industri')->prefix('industri')->group(function () {
        Route::get('/dashboard', function () {
            $penugasan = \App\Models\Penugasan::with(['siswa', 'industri'])
                ->where('id_pengguna_industri_fk', auth()->id())
                ->get();

            $siswaIds = $penugasan->pluck('id_siswa_fk')->toArray();
            
            $selectedSiswaId = request('siswa_id');
            $selectedSiswa = null;
            $selectedPenugasan = null;
            $kompetensiAspek = [];
            $penilaianExisting = null;

            if ($selectedSiswaId) {
                $selectedSiswa = \App\Models\Siswa::find($selectedSiswaId);
                if ($selectedSiswa) {
                    $selectedPenugasan = $penugasan->where('id_siswa_fk', $selectedSiswa->id_siswa)->first();
                    $kompetensiAspek = \App\Models\KompetensiJurusan::where('jurusan', $selectedSiswa->jurusan)->get();
                    
                    $penilaianExisting = \App\Models\PenilaianKompetensi::with('details')
                        ->where('id_siswa_fk', $selectedSiswa->id_siswa)
                        ->where('id_industri_penilai_fk', auth()->id())
                        ->first();
                }
            }

            // Filter kehadiran dan laporan jika siswa_id dipilih
            $kehadiranQuery = \App\Models\Kehadiran::with('siswa')->whereIn('id_siswa_fk', $siswaIds);
            $laporanJurnalQuery = \App\Models\LaporanHarian::with('siswa')->whereIn('id_siswa_fk', $siswaIds);

            if ($selectedSiswaId) {
                $kehadiranQuery->where('id_siswa_fk', $selectedSiswaId);
                $laporanJurnalQuery->where('id_siswa_fk', $selectedSiswaId);
            }

            $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->orderBy('waktu_checkin', 'desc')->get();
            $laporanJurnal = $laporanJurnalQuery->orderBy('tgl_laporan', 'desc')->get();

            return view('industri.dashboard', compact(
                'penugasan', 'kehadiran', 'laporanJurnal', 
                'selectedSiswaId', 'selectedSiswa', 'selectedPenugasan', 
                'kompetensiAspek', 'penilaianExisting'
            ));
        })->name('industri.dashboard');
    });

    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/dashboard', function () {
            $siswa = \App\Models\Siswa::where('id_pengguna_fk', auth()->id())->first();
            $penugasanAktif = null;
            $kehadiranHariIni = null;
            $nilaiAkhir = null;

            if ($siswa) {
                $penugasanAktif = \App\Models\Penugasan::with('industri')
                    ->where('id_siswa_fk', $siswa->id_siswa)
                    ->whereIn('status', ['aktif', 'selesai'])
                    ->latest()
                    ->first();

                $kehadiranHariIni = \App\Models\Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
                    ->where('tgl_absen', date('Y-m-d'))
                    ->first();

                if ($penugasanAktif) {
                    $nilaiAkhir = \App\Models\NilaiAkhir::where('id_siswa_fk', $siswa->id_siswa)
                        ->where('id_penugasan_fk', $penugasanAktif->id_penugasan)
                        ->first();
                }
            }

            return view('siswa.dashboard', compact('siswa', 'penugasanAktif', 'kehadiranHariIni', 'nilaiAkhir'));
        })->name('siswa.dashboard');

        Route::get('/riwayat', function (\Illuminate\Http\Request $request) {
            $siswa = \App\Models\Siswa::where('id_pengguna_fk', auth()->id())->first();
            $kehadiran = [];
            $laporan = [];
            $tglMulai = $request->input('tgl_mulai');
            $tglAkhir = $request->input('tgl_akhir');
            if ($siswa) {
                $kehadiranQuery = \App\Models\Kehadiran::where('id_siswa_fk', $siswa->id_siswa);
                if ($tglMulai) $kehadiranQuery->where('tgl_absen', '>=', $tglMulai);
                if ($tglAkhir) $kehadiranQuery->where('tgl_absen', '<=', $tglAkhir);
                $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->get();

                $laporanQuery = \App\Models\LaporanHarian::where('id_siswa_fk', $siswa->id_siswa);
                if ($tglMulai) $laporanQuery->where('tgl_laporan', '>=', $tglMulai);
                if ($tglAkhir) $laporanQuery->where('tgl_laporan', '<=', $tglAkhir);
                $laporan = $laporanQuery->orderBy('tgl_laporan', 'desc')->get();
            }
            return view('siswa.riwayat', compact('kehadiran', 'laporan', 'tglMulai', 'tglAkhir'));
        })->name('siswa.riwayat');
    });
});
