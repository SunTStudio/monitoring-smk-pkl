<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\KompetensiJurusan;
use App\Models\Penugasan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanHarianController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tgl_laporan'          => 'required|date',
            'jam_mulai_kerja'      => 'required',
            'jam_selesai_kerja'    => 'required',
            'aktivitas_pekerjaan'  => 'required|string',
            'hasil_pekerjaan'      => 'nullable|string',
            'skill_dipraktikkan'   => 'nullable|string',
            'kendala_hambatan'     => 'nullable|string',
            'pembelajaran_didapat' => 'nullable|string',
            'file_lampiran'        => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'skill_ids'            => 'nullable|array',
            'skill_ids.*'          => 'integer|exists:kompetensi_jurusan,id_kompetensi',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->withErrors(['error' => 'Anda bukan merupakan akun siswa.']);
        }

        $penugasan = Penugasan::where('id_siswa_fk', $siswa->id_siswa)
            ->where('status', 'aktif')
            ->first();

        if (!$penugasan) {
            return back()->withErrors(['error' => 'Anda belum terdaftar dalam penugasan PKL aktif.']);
        }

        // Hitung total jam kerja jurnal
        $mulai = Carbon::parse($request->jam_mulai_kerja);
        $selesai = Carbon::parse($request->jam_selesai_kerja);
        $jamTotal = $mulai->diffInMinutes($selesai) / 60;

        // Unggah File Lampiran
        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = 'laporan_' . $siswa->id_siswa . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'storage/' . Storage::disk('public')->putFileAs('uploads/laporan', $file, $fileName);
        }

        $laporan = LaporanHarian::create([
            'id_penugasan_fk'      => $penugasan->id_penugasan,
            'id_siswa_fk'          => $siswa->id_siswa,
            'tgl_laporan'          => $request->tgl_laporan,
            'jam_mulai_kerja'      => $request->jam_mulai_kerja,
            'jam_selesai_kerja'    => $request->jam_selesai_kerja,
            'jam_kerja_total'      => round($jamTotal, 2),
            'aktivitas_pekerjaan'  => $request->aktivitas_pekerjaan,
            'hasil_pekerjaan'      => $request->hasil_pekerjaan,
            'skill_dipraktikkan'   => $request->skill_dipraktikkan,
            'kendala_hambatan'     => $request->kendala_hambatan,
            'pembelajaran_didapat' => $request->pembelajaran_didapat,
            'file_lampiran'        => $filePath,
            'status'               => 'submitted',
        ]);

        // Simpan skill tag yang dipilih siswa (many-to-many)
        if ($request->filled('skill_ids')) {
            $laporan->skillTags()->sync($request->input('skill_ids'));
        }

        // Kirim Notifikasi ke Pembimbing & Industri
        if ($penugasan->id_pembimbing_fk) {
            Notifikasi::create([
                'id_pengguna_tujuan_fk' => $penugasan->id_pembimbing_fk,
                'judul_notifikasi' => 'Jurnal Baru: ' . $siswa->nama_lengkap,
                'pesan_notifikasi' => 'Siswa ' . $siswa->nama_lengkap . ' telah mengisi jurnal baru tanggal ' . Carbon::parse($request->tgl_laporan)->format('d M Y') . '.',
                'tipe_notifikasi' => 'info',
                'kategori' => 'laporan',
                'id_referensi' => $siswa->id_siswa,
                'tipe_referensi' => 'laporan_harian',
            ]);
        }

        if ($penugasan->id_pengguna_industri_fk) {
            Notifikasi::create([
                'id_pengguna_tujuan_fk' => $penugasan->id_pengguna_industri_fk,
                'judul_notifikasi' => 'Jurnal Baru: ' . $siswa->nama_lengkap,
                'pesan_notifikasi' => 'Siswa ' . $siswa->nama_lengkap . ' telah mengisi jurnal baru tanggal ' . Carbon::parse($request->tgl_laporan)->format('d M Y') . '.',
                'tipe_notifikasi' => 'info',
                'kategori' => 'laporan',
                'id_referensi' => $siswa->id_siswa,
                'tipe_referensi' => 'laporan_harian',
            ]);
        }

        return redirect()->back()->with('success', 'Jurnal laporan harian berhasil disubmit.');
    }

    public function review(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'feedback_pembimbing' => 'nullable|string',
            'nilai' => 'nullable|integer|between:1,100',
        ]);

        $laporan = LaporanHarian::findOrFail($id);
        $penugasan = $laporan->penugasan;

        if (!$penugasan) {
            abort(403, 'Laporan ini tidak memiliki penugasan aktif.');
        }

        $user = Auth::user();
        if ($user->hasRole('pembimbing')) {
            if ($penugasan->id_pembimbing_fk !== $user->id) {
                abort(403, 'Anda tidak berwenang mereview laporan siswa ini.');
            }
        } elseif ($user->hasRole('industri')) {
            if ($penugasan->id_pengguna_industri_fk !== $user->id) {
                abort(403, 'Anda tidak berwenang mereview laporan siswa ini.');
            }
        }

        $data = [
            'status' => $request->status,
            'feedback_pembimbing' => $request->feedback_pembimbing,
            'id_pembimbing_review' => Auth::id(),
            'tgl_review' => Carbon::now(),
        ];

        if ($request->filled('nilai')) { // BUG-2 fix: filled() instead of has()
            if (Auth::user()->hasRole('industri')) {
                $data['nilai_dudi'] = $request->nilai;
            } else {
                $data['nilai_guru'] = $request->nilai;
            }
        }

        $laporan->update($data);

        return redirect()->back()->with('success', 'Review laporan harian berhasil disimpan.');
    }
}
