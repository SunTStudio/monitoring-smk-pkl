<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Penugasan;
use App\Models\Industri;
use App\Models\Kehadiran;
use App\Models\LaporanHarian;
use App\Models\NilaiAkhir;
use App\Models\PenilaianSikap;
use App\Models\PenilaianKompetensi;
use App\Models\KompetensiJurusan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Admin/Koordinator Dashboard
     */
    public function admin()
    {
        $siswaCount = Siswa::count();
        $siswaAktifCount = Penugasan::where('status', 'aktif')->count();
        $industriCount = Industri::count();
        
        $assignedSiswaIds = Penugasan::where('status', 'aktif')->pluck('id_siswa_fk')->toArray();
        $belumDitempatkanCount = Siswa::whereNotIn('id_siswa', $assignedSiswaIds)->count();

        return view('admin.dashboard', compact('siswaCount', 'siswaAktifCount', 'industriCount', 'belumDitempatkanCount'));
    }

    /**
     * Pembimbing Dashboard
     */
    public function pembimbing(Request $request)
    {
        $penugasan = Penugasan::with(['siswa', 'industri'])
            ->where('id_pembimbing_fk', auth()->id())
            ->get();

        $siswaIds = $penugasan->pluck('id_siswa_fk')->toArray();

        $selectedSiswaId = $request->input('siswa_id');
        $selectedSiswa = null;
        $selectedPenugasan = null;
        $penilaianSikapExisting = null;
        $rataJurnalDudi = 0;
        $rataJurnalGuru = 0;
        $nilaiKehadiran = 0;
        $prediksiNilaiAkhir = 0;
        $nilaiAkhirExisting = null;

        if ($selectedSiswaId) {
            // BUG-19 fix: Validasi bahwa siswa adalah bimbingan pembimbing ini
            if (!in_array((int)$selectedSiswaId, $siswaIds)) {
                abort(403, 'Siswa ini bukan siswa bimbingan Anda.');
            }
            $selectedSiswa = Siswa::find($selectedSiswaId);
            if ($selectedSiswa) {
                $selectedPenugasan = $penugasan->where('id_siswa_fk', $selectedSiswa->id_siswa)->first();
                
                $penilaianSikapExisting = PenilaianSikap::where('id_siswa_fk', $selectedSiswa->id_siswa)
                    ->where('id_pembimbing_fk', auth()->id())
                    ->first();

                if ($selectedPenugasan) {
                    // Hitung Kehadiran
                    $totalHariPkl = $selectedPenugasan->durasi_hari ?? 0;
                    $totalHariHadir = Kehadiran::where('id_penugasan_fk', $selectedPenugasan->id_penugasan)
                        ->whereIn('status_kehadiran', ['hadir', 'izin'])
                        ->count();
                    $nilaiKehadiran = $totalHariPkl > 0 ? (($totalHariHadir / $totalHariPkl) * 100) : 0;
                    if ($nilaiKehadiran > 100) $nilaiKehadiran = 100;

                    // Hitung Rata Jurnal Guru (BUG-1 fix: cast ke float)
                    $rataJurnalGuru = (float) (LaporanHarian::where('id_siswa_fk', $selectedSiswa->id_siswa)
                        ->whereNotNull('nilai_guru')
                        ->avg('nilai_guru') ?? 0);

                    // Hitung Rata Jurnal DUDI (BUG-1 fix: cast ke float)
                    $rataJurnalDudi = (float) (LaporanHarian::where('id_siswa_fk', $selectedSiswa->id_siswa)
                        ->whereNotNull('nilai_dudi')
                        ->avg('nilai_dudi') ?? 0);

                    // Hitung Prediksi Nilai Akhir
                    $prediksiNilaiAkhir = ($nilaiKehadiran * 0.20) + ($rataJurnalGuru * 0.30) + ($rataJurnalDudi * 0.50);

                    $nilaiAkhirExisting = NilaiAkhir::where('id_siswa_fk', $selectedSiswa->id_siswa)
                        ->where('id_penugasan_fk', $selectedPenugasan->id_penugasan)
                        ->first();
                }
            }
        }

        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');

        // Filter kehadiran dan laporan jika siswa_id dipilih
        $kehadiranQuery = Kehadiran::with('siswa')->whereIn('id_siswa_fk', $siswaIds);
        $laporanJurnalQuery = LaporanHarian::with(['siswa', 'skillTags'])->whereIn('id_siswa_fk', $siswaIds);

        if ($selectedSiswaId) {
            $kehadiranQuery->where('id_siswa_fk', $selectedSiswaId);
            $laporanJurnalQuery->where('id_siswa_fk', $selectedSiswaId);
        }

        if ($tglMulai) {
            $kehadiranQuery->where('tgl_absen', '>=', $tglMulai);
            $laporanJurnalQuery->where('tgl_laporan', '>=', $tglMulai);
        }
        if ($tglAkhir) {
            $kehadiranQuery->where('tgl_absen', '<=', $tglAkhir);
            $laporanJurnalQuery->where('tgl_laporan', '<=', $tglAkhir);
        }

        $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->orderBy('waktu_checkin', 'desc')->get();
        $laporanJurnal = $laporanJurnalQuery->orderBy('tgl_laporan', 'desc')->get();

        $industriMitra = Industri::where('status', 'aktif')->get();

        return view('pembimbing.dashboard', compact(
            'penugasan', 'kehadiran', 'laporanJurnal', 'industriMitra',
            'selectedSiswaId', 'selectedSiswa', 'selectedPenugasan', 'penilaianSikapExisting',
            'rataJurnalDudi', 'rataJurnalGuru', 'nilaiKehadiran', 'prediksiNilaiAkhir', 'nilaiAkhirExisting',
            'tglMulai', 'tglAkhir'
        ));
    }

    /**
     * Industri Dashboard
     */
    public function industri(Request $request)
    {
        $penugasan = Penugasan::with(['siswa', 'industri'])
            ->where('id_pengguna_industri_fk', auth()->id())
            ->get();

        $siswaIds = $penugasan->pluck('id_siswa_fk')->toArray();
        
        $selectedSiswaId = $request->input('siswa_id');
        $selectedSiswa = null;
        $selectedPenugasan = null;
        $kompetensiAspek = [];
        $penilaianExisting = null;

        if ($selectedSiswaId) {
            // BUG-19 fix: Validasi bahwa siswa terdaftar di penugasan industri ini
            if (!in_array((int)$selectedSiswaId, $siswaIds)) {
                abort(403, 'Siswa ini bukan siswa yang ditugaskan ke industri Anda.');
            }
            $selectedSiswa = Siswa::find($selectedSiswaId);
            if ($selectedSiswa) {
                $selectedPenugasan = $penugasan->where('id_siswa_fk', $selectedSiswa->id_siswa)->first();
                $kompetensiAspek = KompetensiJurusan::untukJurusan($selectedSiswa->jurusan)->get();
                
                $penilaianExisting = PenilaianKompetensi::with('details')
                    ->where('id_siswa_fk', $selectedSiswa->id_siswa)
                    ->where('id_industri_penilai_fk', auth()->id())
                    ->first();
            }
        }

        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');

        // Filter kehadiran dan laporan jika siswa_id dipilih
        $kehadiranQuery = Kehadiran::with('siswa')->whereIn('id_siswa_fk', $siswaIds);
        $laporanJurnalQuery = LaporanHarian::with(['siswa', 'skillTags'])->whereIn('id_siswa_fk', $siswaIds);

        if ($selectedSiswaId) {
            $kehadiranQuery->where('id_siswa_fk', $selectedSiswaId);
            $laporanJurnalQuery->where('id_siswa_fk', $selectedSiswaId);
        }

        if ($tglMulai) {
            $kehadiranQuery->where('tgl_absen', '>=', $tglMulai);
            $laporanJurnalQuery->where('tgl_laporan', '>=', $tglMulai);
        }
        if ($tglAkhir) {
            $kehadiranQuery->where('tgl_absen', '<=', $tglAkhir);
            $laporanJurnalQuery->where('tgl_laporan', '<=', $tglAkhir);
        }

        $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->orderBy('waktu_checkin', 'desc')->get();
        $laporanJurnal = $laporanJurnalQuery->orderBy('tgl_laporan', 'desc')->get();

        return view('industri.dashboard', compact(
            'penugasan', 'kehadiran', 'laporanJurnal', 
            'selectedSiswaId', 'selectedSiswa', 'selectedPenugasan', 
            'kompetensiAspek', 'penilaianExisting',
            'tglMulai', 'tglAkhir'
        ));
    }

    /**
     * Siswa Dashboard
     */
    public function siswa()
    {
        $siswa = Siswa::where('id_pengguna_fk', auth()->id())->first();
        $penugasanAktif = null;
        $kehadiranHariIni = null;
        $nilaiAkhir = null;

        if ($siswa) {
            $penugasanAktif = Penugasan::with('industri')
                ->where('id_siswa_fk', $siswa->id_siswa)
                ->whereIn('status', ['aktif', 'selesai'])
                ->latest()
                ->first();

            $kehadiranHariIni = Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
                ->where('tgl_absen', date('Y-m-d'))
                ->first();

            if ($penugasanAktif) {
                $nilaiAkhir = NilaiAkhir::where('id_siswa_fk', $siswa->id_siswa)
                    ->where('id_penugasan_fk', $penugasanAktif->id_penugasan)
                    ->first();
            }
        }

        $skills = collect();
        if ($siswa) {
            $skills = KompetensiJurusan::where(function ($q) use ($siswa) {
                $q->where('jurusan', $siswa->jurusan)
                  ->orWhere('is_universal', true);
                if ($siswa->jurusan === 'Kimia') {
                    $q->orWhere('jurusan', 'Kimia Industri');
                }
            })->orderBy('kategori')->orderBy('urutan')->get();
        }

        return view('siswa.dashboard', compact('siswa', 'penugasanAktif', 'kehadiranHariIni', 'nilaiAkhir', 'skills'));
    }

    /**
     * Siswa Riwayat
     */
    public function siswaRiwayat(Request $request)
    {
        $siswa = Siswa::where('id_pengguna_fk', auth()->id())->first();
        $kehadiran = [];
        $laporan = [];
        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');
        
        if ($siswa) {
            $kehadiranQuery = Kehadiran::where('id_siswa_fk', $siswa->id_siswa);
            if ($tglMulai) $kehadiranQuery->where('tgl_absen', '>=', $tglMulai);
            if ($tglAkhir) $kehadiranQuery->where('tgl_absen', '<=', $tglAkhir);
            $kehadiran = $kehadiranQuery->orderBy('tgl_absen', 'desc')->get();

            $laporanQuery = LaporanHarian::where('id_siswa_fk', $siswa->id_siswa);
            if ($tglMulai) $laporanQuery->where('tgl_laporan', '>=', $tglMulai);
            if ($tglAkhir) $laporanQuery->where('tgl_laporan', '<=', $tglAkhir);
            $laporan = $laporanQuery->with('skillTags')->orderBy('tgl_laporan', 'desc')->get();
        }
        
        return view('siswa.riwayat', compact('kehadiran', 'laporan', 'tglMulai', 'tglAkhir'));
    }

    /**
     * Export Kehadiran ke CSV
     */
    public function siswaExportKehadiran(Request $request)
    {
        $siswa = Siswa::where('id_pengguna_fk', auth()->id())->first();
        if (!$siswa) return back();

        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');

        $query = Kehadiran::where('id_siswa_fk', $siswa->id_siswa);
        if ($tglMulai) $query->where('tgl_absen', '>=', $tglMulai);
        if ($tglAkhir) $query->where('tgl_absen', '<=', $tglAkhir);
        $kehadiran = $query->orderBy('tgl_absen', 'asc')->get();

        $suffix = ($tglMulai || $tglAkhir) ? "_{$tglMulai}_sd_{$tglAkhir}" : '';
        $filename = "Kehadiran_{$siswa->nama_lengkap}{$suffix}.csv";

        $callback = function () use ($kehadiran, $siswa) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            // Header info
            fputcsv($handle, ['REKAP KEHADIRAN PKL', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Nama Siswa', $siswa->nama_lengkap, '', '', '', '', ''], ';');
            fputcsv($handle, ['NIS', $siswa->nis, '', '', '', '', ''], ';');
            fputcsv($handle, ['Kelas / Jurusan', "{$siswa->kelas} / {$siswa->jurusan}", '', '', '', '', ''], ';');
            fputcsv($handle, ['Tanggal Export', now()->format('d/m/Y H:i'), '', '', '', '', ''], ';');
            fputcsv($handle, [], ';');

            // Column headers
            fputcsv($handle, ['No', 'Tanggal', 'Status Kehadiran', 'Jam Masuk', 'Jam Keluar', 'Total Jam Kerja', 'Lokasi Check-in', 'Keterangan'], ';');

            $no = 1;
            $hadir = 0; $alpa = 0; $izin = 0; $sakit = 0;
            foreach ($kehadiran as $k) {
                $status = $k->status_kehadiran ?? '-';
                if ($status === 'hadir') $hadir++;
                elseif ($status === 'alpa') $alpa++;
                elseif ($status === 'izin') $izin++;
                elseif ($status === 'sakit') $sakit++;

                fputcsv($handle, [
                    $no++,
                    Carbon::parse($k->tgl_absen)->format('d/m/Y'),
                    strtoupper($status),
                    $k->waktu_checkin ?? '-',
                    $k->waktu_checkout ?? '-',
                    $k->jam_kerja_real ? $k->jam_kerja_real . ' Jam' : '-',
                    $k->lokasi_checkin ?? '-',
                    $k->keterangan_izin ?? '-',
                ], ';');
            }

            // Summary
            $total = $kehadiran->count();
            fputcsv($handle, [], ';');
            fputcsv($handle, ['RINGKASAN', '', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Total Hari', $total, '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Hadir', $hadir, "({$hadir}/{$total})", '', '', '', '', ''], ';');
            fputcsv($handle, ['Alpa / Tidak Hadir', $alpa, '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Izin', $izin, '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Sakit', $sakit, '', '', '', '', '', ''], ';');
            $persenHadir = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
            fputcsv($handle, ['Persentase Kehadiran', "{$persenHadir}%", '', '', '', '', '', ''], ';');
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'application/vnd.ms-excel;charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Jurnal ke CSV
     */
    public function siswaExportJurnal(Request $request)
    {
        $siswa = Siswa::where('id_pengguna_fk', auth()->id())->first();
        if (!$siswa) return back();

        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');

        $query = LaporanHarian::where('id_siswa_fk', $siswa->id_siswa);
        if ($tglMulai) $query->where('tgl_laporan', '>=', $tglMulai);
        if ($tglAkhir) $query->where('tgl_laporan', '<=', $tglAkhir);
        $laporan = $query->orderBy('tgl_laporan', 'asc')->get();

        $suffix = ($tglMulai || $tglAkhir) ? "_{$tglMulai}_sd_{$tglAkhir}" : '';
        $filename = "Jurnal_Harian_{$siswa->nama_lengkap}{$suffix}.csv";

        $callback = function () use ($laporan, $siswa) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['REKAP JURNAL HARIAN PKL', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Nama Siswa', $siswa->nama_lengkap, '', '', '', '', ''], ';');
            fputcsv($handle, ['NIS', $siswa->nis, '', '', '', '', ''], ';');
            fputcsv($handle, ['Kelas / Jurusan', "{$siswa->kelas} / {$siswa->jurusan}", '', '', '', '', ''], ';');
            fputcsv($handle, ['Tanggal Export', now()->format('d/m/Y H:i'), '', '', '', '', ''], ';');
            fputcsv($handle, [], ';');

            fputcsv($handle, ['No', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Aktivitas Pekerjaan', 'Hasil / Output', 'Skill Dipraktikkan', 'Status', 'Nilai Guru', 'Nilai DU-DI', 'Feedback Pembimbing'], ';');

            $no = 1;
            $sumGuru = 0; $sumDudi = 0; $countNilaiGuru = 0; $countNilaiDudi = 0; $approved = 0; // BUG-11 fix: counter terpisah
            foreach ($laporan as $l) {
                if ($l->status === 'approved') $approved++;
                if ($l->nilai_guru) { $sumGuru += $l->nilai_guru; $countNilaiGuru++; }
                if ($l->nilai_dudi) { $sumDudi += $l->nilai_dudi; $countNilaiDudi++; }

                fputcsv($handle, [
                    $no++,
                    Carbon::parse($l->tgl_laporan)->format('d/m/Y'),
                    $l->jam_mulai_kerja ?? '-',
                    $l->jam_selesai_kerja ?? '-',
                    $l->aktivitas_pekerjaan,
                    $l->hasil_pekerjaan ?? '-',
                    $l->skill_dipraktikkan ?? '-',
                    strtoupper($l->status ?? 'draft'),
                    $l->nilai_guru ?? '-',
                    $l->nilai_dudi ?? '-',
                    $l->feedback_pembimbing ?? '-',
                ], ';');
            }

            $total = $laporan->count();
            fputcsv($handle, [], ';');
            fputcsv($handle, ['RINGKASAN', '', '', '', '', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Total Jurnal', $total, '', '', '', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Jurnal Disetujui', $approved, '', '', '', '', '', '', '', '', ''], ';');
            $avgGuru = $countNilaiGuru > 0 ? round($sumGuru / $countNilaiGuru, 2) : '-'; // BUG-11 fix
            $avgDudi = $countNilaiDudi > 0 ? round($sumDudi / $countNilaiDudi, 2) : '-'; // BUG-11 fix
            fputcsv($handle, ['Rata-rata Nilai Guru', $avgGuru, '', '', '', '', '', '', '', '', ''], ';');
            fputcsv($handle, ['Rata-rata Nilai DU-DI', $avgDudi, '', '', '', '', '', '', '', '', ''], ';');
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'application/vnd.ms-excel;charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Read notification and redirect to source page
     */
    public function readAndRedirectNotification($id)
    {
        $notif = Notifikasi::where('id_pengguna_tujuan_fk', auth()->id())
            ->findOrFail($id);

        if (!$notif->status_dibaca) {
            $notif->update([
                'status_dibaca' => true,
                'tgl_dibaca' => now(),
            ]);
        }

        // Redirect based on reference
        $targetLink = '/'; // fallback
        
        if ($notif->tipe_referensi === 'laporan_harian') {
            if (auth()->user()->hasRole('pembimbing')) {
                $targetLink = route('pembimbing.dashboard', ['siswa_id' => $notif->id_referensi]);
            } elseif (auth()->user()->hasRole('industri')) {
                $targetLink = route('industri.dashboard', ['siswa_id' => $notif->id_referensi]);
            }
        } elseif (in_array($notif->tipe_referensi, ['penilaian_sikap', 'penilaian_kompetensi', 'nilai_akhir'])) {
            $targetLink = route('siswa.dashboard');
        }

        return redirect($targetLink);
    }

    /**
     * Mark all user notifications as read
     */
    public function readAllNotifications()
    {
        Notifikasi::where('id_pengguna_tujuan_fk', auth()->id())
            ->where('status_dibaca', false)
            ->update([
                'status_dibaca' => true,
                'tgl_dibaca' => now(),
            ]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
