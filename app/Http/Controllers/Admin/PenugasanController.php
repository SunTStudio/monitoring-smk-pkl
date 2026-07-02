<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenugasanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedTahun = $request->input('tahun_ajaran');

        $penugasanQuery = Penugasan::with(['siswa', 'industri', 'pembimbingSekolah', 'pembimbingIndustri'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                })->orWhereHas('industri', function ($q) use ($search) {
                    $q->where('nama_industri', 'like', "%{$search}%");
                })->orWhereHas('pembimbingSekolah', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });

        if ($selectedTahun) {
            $penugasanQuery->whereHas('siswa.kelasDetail', function ($q) use ($selectedTahun) {
                $q->where('tahun_ajaran', $selectedTahun);
            });
        }

        $penugasan = $penugasanQuery->get();

        // Mengambil siswa aktif yang BELUM memiliki penugasan aktif
        $siswa = Siswa::where('status', 'aktif')
            ->whereDoesntHave('penugasan', function ($query) {
                $query->where('status', 'aktif');
            })
            ->get();

        // Mengambil semua siswa aktif untuk form edit
        $allSiswa = Siswa::where('status', 'aktif')->get();

        $industri = Industri::where('status', 'aktif')->get();
        $pembimbing = User::role('pembimbing')->where('status', 'aktif')->get();
        $pembimbingIndustri = User::role('industri')->where('status', 'aktif')->get();
        $tahunAjaranList = Kelas::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        return view('admin.penugasan.index', compact('penugasan', 'siswa', 'allSiswa', 'industri', 'pembimbing', 'pembimbingIndustri', 'search', 'tahunAjaranList', 'selectedTahun'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa_fk' => 'required|array',
            'id_siswa_fk.*' => 'exists:siswa,id_siswa',
            'id_industri_fk' => 'required|exists:industri,id_industri',
            'id_pembimbing_fk' => 'required|exists:users,id',
            'id_pengguna_industri_fk' => 'required|exists:users,id',
            'tgl_mulai_pkl' => 'required|date',
            'tgl_selesai_pkl' => 'required|date|after_or_equal:tgl_mulai_pkl',
            'lokasi_kerja' => 'nullable|string|max:100',
            'divisi_departemen' => 'nullable|string|max:100',
            'pembimbing_industri' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,selesai,batal,on_leave',
            'catatan' => 'nullable|string',
        ]);

        // BUG-E fix: Verifikasi peran pengguna pembimbing dan industri
        $pembimbingUser = User::find($request->id_pembimbing_fk);
        if ($pembimbingUser && !$pembimbingUser->hasRole('pembimbing')) {
            return back()->withErrors(['id_pembimbing_fk' => 'Pengguna pembimbing yang dipilih tidak memiliki peran pembimbing sekolah.'])->withInput();
        }

        $industriUser = User::find($request->id_pengguna_industri_fk);
        if ($industriUser && !$industriUser->hasRole('industri')) {
            return back()->withErrors(['id_pengguna_industri_fk' => 'Pengguna industri yang dipilih tidak memiliki peran pembimbing industri.'])->withInput();
        }

        // Hitung otomatis durasi hari pkl
        $tglMulai = Carbon::parse($request->tgl_mulai_pkl);
        $tglSelesai = Carbon::parse($request->tgl_selesai_pkl);
        $durasiHari = $tglMulai->diffInDays($tglSelesai) + 1;

        $siswaIds = $request->id_siswa_fk;
        $created = 0;
        $skipped = [];

        foreach ($siswaIds as $siswaId) {
            // BUG-18 fix: Cek apakah siswa sudah memiliki penugasan aktif
            $existingAktif = Penugasan::where('id_siswa_fk', $siswaId)
                ->where('status', 'aktif')
                ->first();

            if ($existingAktif) {
                $siswaObj = Siswa::find($siswaId);
                $skipped[] = $siswaObj ? $siswaObj->nama_lengkap : "ID: {$siswaId}";
                continue;
            }

            Penugasan::create([
                'id_siswa_fk' => $siswaId,
                'id_industri_fk' => $request->id_industri_fk,
                'id_pembimbing_fk' => $request->id_pembimbing_fk,
                'id_pengguna_industri_fk' => $request->id_pengguna_industri_fk,
                'tgl_mulai_pkl' => $request->tgl_mulai_pkl,
                'tgl_selesai_pkl' => $request->tgl_selesai_pkl,
                'durasi_hari' => $durasiHari,
                'lokasi_kerja' => $request->lokasi_kerja,
                'divisi_departemen' => $request->divisi_departemen,
                'pembimbing_industri' => $request->pembimbing_industri,
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);
            $created++;
        }

        $message = "{$created} Alokasi penugasan PKL siswa berhasil dibuat.";
        if (!empty($skipped)) {
            $message .= ' Dilewati karena sudah memiliki penugasan aktif: ' . implode(', ', $skipped) . '.';
        }

        return redirect()->route('penugasan.index')->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $penugasan = Penugasan::findOrFail($id);

        $request->validate([
            'id_siswa_fk' => 'required|exists:siswa,id_siswa',
            'id_industri_fk' => 'required|exists:industri,id_industri',
            'id_pembimbing_fk' => 'required|exists:users,id',
            'id_pengguna_industri_fk' => 'required|exists:users,id',
            'tgl_mulai_pkl' => 'required|date',
            'tgl_selesai_pkl' => 'required|date|after_or_equal:tgl_mulai_pkl',
            'lokasi_kerja' => 'nullable|string|max:100',
            'divisi_departemen' => 'nullable|string|max:100',
            'pembimbing_industri' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,selesai,batal,on_leave',
            'catatan' => 'nullable|string',
        ]);

        // BUG-E fix: Verifikasi peran pengguna pembimbing dan industri
        $pembimbingUser = User::find($request->id_pembimbing_fk);
        if ($pembimbingUser && !$pembimbingUser->hasRole('pembimbing')) {
            return back()->withErrors(['id_pembimbing_fk' => 'Pengguna pembimbing yang dipilih tidak memiliki peran pembimbing sekolah.'])->withInput();
        }

        $industriUser = User::find($request->id_pengguna_industri_fk);
        if ($industriUser && !$industriUser->hasRole('industri')) {
            return back()->withErrors(['id_pengguna_industri_fk' => 'Pengguna industri yang dipilih tidak memiliki peran pembimbing industri.'])->withInput();
        }

        // Hitung otomatis durasi hari pkl
        $tglMulai = Carbon::parse($request->tgl_mulai_pkl);
        $tglSelesai = Carbon::parse($request->tgl_selesai_pkl);
        $durasiHari = $tglMulai->diffInDays($tglSelesai) + 1;

        $penugasan->update([
            'id_siswa_fk' => $request->id_siswa_fk,
            'id_industri_fk' => $request->id_industri_fk,
            'id_pembimbing_fk' => $request->id_pembimbing_fk,
            'id_pengguna_industri_fk' => $request->id_pengguna_industri_fk,
            'tgl_mulai_pkl' => $request->tgl_mulai_pkl,
            'tgl_selesai_pkl' => $request->tgl_selesai_pkl,
            'durasi_hari' => $durasiHari,
            'lokasi_kerja' => $request->lokasi_kerja,
            'divisi_departemen' => $request->divisi_departemen,
            'pembimbing_industri' => $request->pembimbing_industri,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('penugasan.index')->with('success', 'Penugasan PKL siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penugasan = Penugasan::findOrFail($id);

        // BUG-10 fix: Cek apakah penugasan memiliki data kehadiran atau laporan terkait
        if ($penugasan->kehadiran()->exists() || $penugasan->laporanHarian()->exists()) {
            return back()->withErrors(['error' => 'Penugasan tidak dapat dihapus karena sudah memiliki data kehadiran atau jurnal harian. Ubah status penugasan menjadi "batal" sebagai gantinya.']);
        }

        $penugasan->delete();

        return redirect()->route('penugasan.index')->with('success', 'Penugasan PKL siswa berhasil dihapus.');
    }
}
