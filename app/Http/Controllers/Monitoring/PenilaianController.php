<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\PenilaianSikap;
use App\Models\PenilaianKompetensi;
use App\Models\DetailPenilaianKompetensi;
use App\Models\NilaiAkhir;
use App\Models\Penugasan;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenilaianController extends Controller
{
    /**
     * Input Penilaian Sikap (Oleh Guru Pembimbing)
     */
    public function storeSikap(Request $request)
    {
        $request->validate([
            'id_penugasan_fk' => 'required|exists:penugasan,id_penugasan',
            'id_siswa_fk' => 'required|exists:siswa,id_siswa',
            'nilai_kedisiplinan' => 'required|integer|between:0,100',
            'nilai_kerjasama' => 'required|integer|between:0,100',
            'nilai_tanggung_jawab' => 'required|integer|between:0,100',
            'nilai_inisiatif' => 'required|integer|between:0,100',
            'catatan_kedisiplinan' => 'nullable|string',
            'catatan_kerjasama' => 'nullable|string',
            'catatan_tanggung_jawab' => 'nullable|string',
            'catatan_inisiatif' => 'nullable|string',
            'catatan_umum' => 'nullable|string',
            'status' => 'required|in:draft,submitted,finalized',
        ]);

        $meanSikap = ($request->nilai_kedisiplinan + $request->nilai_kerjasama + $request->nilai_tanggung_jawab + $request->nilai_inisiatif) / 4;

        PenilaianSikap::updateOrCreate(
            [
                'id_penugasan_fk' => $request->id_penugasan_fk,
                'id_siswa_fk' => $request->id_siswa_fk,
                'id_pembimbing_fk' => Auth::id(),
            ],
            [
                'nilai_kedisiplinan' => $request->nilai_kedisiplinan,
                'nilai_kerjasama' => $request->nilai_kerjasama,
                'nilai_tanggung_jawab' => $request->nilai_tanggung_jawab,
                'nilai_inisiatif' => $request->nilai_inisiatif,
                'nilai_rata_rata_sikap' => round($meanSikap, 2),
                'catatan_kedisiplinan' => $request->catatan_kedisiplinan,
                'catatan_kerjasama' => $request->catatan_kerjasama,
                'catatan_tanggung_jawab' => $request->catatan_tanggung_jawab,
                'catatan_inisiatif' => $request->catatan_inisiatif,
                'catatan_umum' => $request->catatan_umum,
                'status' => $request->status,
                'tgl_penilaian' => Carbon::now()->toDateString(),
            ]
        );

        return redirect()->back()->with('success', 'Penilaian sikap berhasil disimpan.');
    }

    /**
     * Input Penilaian Kompetensi Teknis (Oleh Pembimbing Industri / DU-DI)
     */
    public function storeKompetensi(Request $request)
    {
        $request->validate([
            'id_penugasan_fk' => 'required|exists:penugasan,id_penugasan',
            'id_siswa_fk' => 'required|exists:siswa,id_siswa',
            'catatan_umum' => 'nullable|string',
            'rekomendasi_industri' => 'nullable|string',
            'scores' => 'required|array', // format: [id_kompetensi => ['nilai' => X, 'catatan' => Y]]
            'scores.*.nilai' => 'required|integer|between:0,100',
            'scores.*.catatan' => 'nullable|string',
            'status' => 'required|in:draft,submitted,finalized',
        ]);

        DB::beginTransaction();

        try {
            // Hitung rata-rata nilai kompetensi teknis
            $totalNilai = 0;
            $jumlahAspek = count($request->scores);

            foreach ($request->scores as $compData) {
                $totalNilai += $compData['nilai'];
            }

            $meanKompetensi = $jumlahAspek > 0 ? ($totalNilai / $jumlahAspek) : 0;

            // 1. Buat/Update Header Penilaian
            $penilaianHeader = PenilaianKompetensi::updateOrCreate(
                [
                    'id_penugasan_fk' => $request->id_penugasan_fk,
                    'id_siswa_fk' => $request->id_siswa_fk,
                    'id_industri_penilai_fk' => Auth::id(),
                ],
                [
                    'nilai_rata_rata_kompetensi' => round($meanKompetensi, 2),
                    'catatan_umum' => $request->catatan_umum,
                    'rekomendasi_industri' => $request->rekomendasi_industri,
                    'status' => $request->status,
                    'tgl_penilaian' => Carbon::now()->toDateString(),
                ]
            );

            // 2. Hapus detail lama & input detail baru
            DetailPenilaianKompetensi::where('id_penilaian_kompetensi_fk', $penilaianHeader->id_penilaian_kompetensi)->delete();

            foreach ($request->scores as $idKompetensi => $compData) {
                DetailPenilaianKompetensi::create([
                    'id_penilaian_kompetensi_fk' => $penilaianHeader->id_penilaian_kompetensi,
                    'id_kompetensi_fk' => $idKompetensi,
                    'nilai' => $compData['nilai'],
                    'catatan' => $compData['catatan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Penilaian aspek kompetensi industri berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan penilaian: ' . $e->getMessage()]);
        }
    }

    /**
     * Finalisasi Nilai Akhir & Penentuan Kelulusan (Oleh Admin/Koordinator)
     */
    public function finalisasi(Request $request)
    {
        $request->validate([
            'id_penugasan_fk' => 'required|exists:penugasan,id_penugasan',
            'id_siswa_fk' => 'required|exists:siswa,id_siswa',
            'periode_pkl' => 'nullable|string|max:20',
            'no_sertifikat' => 'nullable|string|max:50|unique:nilai_akhir,no_sertifikat',
            'catatan' => 'nullable|string',
        ]);

        $penugasan = Penugasan::findOrFail($request->id_penugasan_fk);

        // 1. Hitung Kehadiran
        // Hitung total hari kerja PKL (durasi)
        $totalHariPkl = $penugasan->durasi_hari ?? 0;

        // Hitung total hadir & izin
        $totalHariHadir = Kehadiran::where('id_penugasan_fk', $penugasan->id_penugasan)
            ->whereIn('status_kehadiran', ['hadir', 'izin'])
            ->count();

        // Nilai Kehadiran: (Jumlah Hadir / Total Hari Kerja PKL) * 100
        $nilaiKehadiran = $totalHariPkl > 0 ? (($totalHariHadir / $totalHariPkl) * 100) : 0;
        if ($nilaiKehadiran > 100) $nilaiKehadiran = 100;

        // 2. Ambil Nilai Rata-Rata Sikap (Dari Nilai Jurnal Guru, fallback ke PenilaianSikap)
        $rataJurnalGuru = \App\Models\LaporanHarian::where('id_siswa_fk', $request->id_siswa_fk)
            ->whereNotNull('nilai_guru')
            ->avg('nilai_guru');
        
        if ($rataJurnalGuru !== null) {
            $nilaiSikap = (float)$rataJurnalGuru;
        } else {
            $penilaianSikap = PenilaianSikap::where('id_penugasan_fk', $penugasan->id_penugasan)
                ->where('status', 'finalized')
                ->first();
            $nilaiSikap = $penilaianSikap ? (float)$penilaianSikap->nilai_rata_rata_sikap : 0.0;
        }

        // 3. Ambil Nilai Rata-Rata Kompetensi (Dari Nilai Jurnal DUDI, fallback ke PenilaianKompetensi)
        $rataJurnalDudi = \App\Models\LaporanHarian::where('id_siswa_fk', $request->id_siswa_fk)
            ->whereNotNull('nilai_dudi')
            ->avg('nilai_dudi');

        if ($rataJurnalDudi !== null) {
            $nilaiKompetensi = (float)$rataJurnalDudi;
        } else {
            $penilaianKompetensi = PenilaianKompetensi::where('id_penugasan_fk', $penugasan->id_penugasan)
                ->where('status', 'finalized')
                ->first();
            $nilaiKompetensi = $penilaianKompetensi ? (float)$penilaianKompetensi->nilai_rata_rata_kompetensi : 0.0;
        }

        // 4. Hitung Nilai Akhir Berbobot (Kehadiran 20%, Sikap 30%, Kompetensi 50%)
        $nilaiAkhir = ($nilaiKehadiran * 0.20) + ($nilaiSikap * 0.30) + ($nilaiKompetensi * 0.50);

        // Tentukan Grade
        if ($nilaiAkhir >= 85) {
            $grade = 'A';
            $statusKelulusan = 'lulus';
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B';
            $statusKelulusan = 'lulus';
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C';
            $statusKelulusan = 'remedial';
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'D';
            $statusKelulusan = 'tidak_lulus';
        } else {
            $grade = 'E';
            $statusKelulusan = 'tidak_lulus';
        }

        NilaiAkhir::updateOrCreate(
            [
                'id_penugasan_fk' => $request->id_penugasan_fk,
                'id_siswa_fk' => $request->id_siswa_fk,
            ],
            [
                'periode_pkl' => $request->periode_pkl ?? Carbon::parse($penugasan->tgl_mulai_pkl)->format('Y'),
                'total_hari_pkl' => $totalHariPkl,
                'total_hari_hadir' => $totalHariHadir,
                'nilai_kehadiran' => round($nilaiKehadiran, 2),
                'nilai_sikap_bobot' => round($nilaiSikap, 2),
                'nilai_kompetensi_bobot' => round($nilaiKompetensi, 2),
                'nilai_akhir_pkl' => round($nilaiAkhir, 2),
                'grade' => $grade,
                'status_kelulusan' => $statusKelulusan,
                'id_yang_finalisasi' => Auth::id(),
                'tgl_finalisasi' => Carbon::now(),
                'no_sertifikat' => $request->no_sertifikat,
                'catatan' => $request->catatan,
            ]
        );

        return redirect()->back()->with('success', 'Nilai akhir PKL berhasil difinalisasi dengan nilai: ' . round($nilaiAkhir, 2) . ' (Grade ' . $grade . ').');
    }

    /**
     * Cetak Rapor Nilai PKL (Cetak/PDF via browser)
     */
    public function cetakRapor($id_siswa)
    {
        $siswa = \App\Models\Siswa::with(['kelasDetail'])->findOrFail($id_siswa);
        $penugasan = \App\Models\Penugasan::with(['industri', 'pembimbingSekolah'])
            ->where('id_siswa_fk', $id_siswa)
            ->first();

        if (!$penugasan) {
            return back()->with('error', 'Siswa belum memiliki penugasan PKL.');
        }

        $nilaiAkhir = NilaiAkhir::where('id_siswa_fk', $id_siswa)
            ->where('id_penugasan_fk', $penugasan->id_penugasan)
            ->first();

        if (!$nilaiAkhir) {
            return back()->with('error', 'Nilai akhir PKL belum difinalisasi oleh Guru Pembimbing.');
        }

        return view('admin.nilai.cetak', compact('siswa', 'penugasan', 'nilaiAkhir'));
    }

    /**
     * Export Hasil Nilai PKL ke Excel/CSV
     */
    public function exportExcel()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=nilai_pkl_smk_advance_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $results = NilaiAkhir::with(['siswa.kelasDetail', 'penugasan.industri', 'penugasan.pembimbingSekolah'])->get();

        $columns = [
            'No', 'NISN', 'NIS', 'Nama Lengkap', 'Kelas', 'Jurusan', 'Tahun Ajaran',
            'Industri Mitra', 'Guru Pembimbing', 'Nilai Kehadiran (20%)', 
            'Nilai Sikap (30%)', 'Nilai Kompetensi (50%)', 'Nilai Akhir PKL', 
            'Grade', 'Status Kelulusan', 'No Sertifikat', 'Tanggal Finalisasi'
        ];

        $callback = function() use($results, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to support Excel opening with UTF-8 encoding
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, $columns, ';');
            
            foreach ($results as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->siswa->nisn,
                    $row->siswa->nis,
                    $row->siswa->nama_lengkap,
                    $row->siswa->kelas,
                    $row->siswa->jurusan,
                    $row->siswa->kelasDetail->tahun_ajaran ?? '-',
                    $row->penugasan->industri->nama_industri ?? '-',
                    $row->penugasan->pembimbingSekolah->name ?? '-',
                    $row->nilai_kehadiran,
                    $row->nilai_sikap_bobot,
                    $row->nilai_kompetensi_bobot,
                    $row->nilai_akhir_pkl,
                    $row->grade,
                    ucfirst(str_replace('_', ' ', $row->status_kelulusan)),
                    $row->no_sertifikat ?? '-',
                    $row->tgl_finalisasi ? Carbon::parse($row->tgl_finalisasi)->format('d-m-Y') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
