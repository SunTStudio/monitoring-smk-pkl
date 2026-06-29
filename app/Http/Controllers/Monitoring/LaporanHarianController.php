<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanHarianController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tgl_laporan' => 'required|date',
            'jam_mulai_kerja' => 'required',
            'jam_selesai_kerja' => 'required',
            'aktivitas_pekerjaan' => 'required|string',
            'hasil_pekerjaan' => 'nullable|string',
            'skill_dipraktikkan' => 'nullable|string',
            'kendala_hambatan' => 'nullable|string',
            'pembelajaran_didapat' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,png,jpeg,zip|max:5120', // Maks 5MB
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
            $file->move(public_path('uploads/laporan'), $fileName);
            $filePath = 'uploads/laporan/' . $fileName;
        }

        LaporanHarian::create([
            'id_penugasan_fk' => $penugasan->id_penugasan,
            'id_siswa_fk' => $siswa->id_siswa,
            'tgl_laporan' => $request->tgl_laporan,
            'jam_mulai_kerja' => $request->jam_mulai_kerja,
            'jam_selesai_kerja' => $request->jam_selesai_kerja,
            'jam_kerja_total' => round($jamTotal, 2),
            'aktivitas_pekerjaan' => $request->aktivitas_pekerjaan,
            'hasil_pekerjaan' => $request->hasil_pekerjaan,
            'skill_dipraktikkan' => $request->skill_dipraktikkan,
            'kendala_hambatan' => $request->kendala_hambatan,
            'pembelajaran_didapat' => $request->pembelajaran_didapat,
            'file_lampiran' => $filePath,
            'status' => 'submitted', // Langsung submitted setelah di-post
        ]);

        return redirect()->back()->with('success', 'Jurnal laporan harian berhasil disubmit.');
    }

    public function review(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'feedback_pembimbing' => 'nullable|string',
        ]);

        $laporan = LaporanHarian::findOrFail($id);

        $laporan->update([
            'status' => $request->status,
            'feedback_pembimbing' => $request->feedback_pembimbing,
            'id_pembimbing_review' => Auth::id(),
            'tgl_review' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Review laporan harian berhasil disimpan.');
    }
}
