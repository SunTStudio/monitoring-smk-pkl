<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedTahun = $request->input('tahun_ajaran');

        $siswaQuery = Siswa::with('kelasDetail');
        if ($search) {
            $siswaQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        if ($selectedTahun) {
            $siswaQuery->whereHas('kelasDetail', function($q) use ($selectedTahun) {
                $q->where('tahun_ajaran', $selectedTahun);
            });
        }

        $siswa = $siswaQuery->get()->groupBy('jurusan');

        $masterKelas = \App\Models\Kelas::all();
        $tahunAjaranList = \App\Models\Kelas::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        return view('admin.siswa.index', compact('siswa', 'search', 'masterKelas', 'tahunAjaranList', 'selectedTahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nis' => 'required|string|max:10|unique:siswa,nis',
            'id_kelas_fk' => 'required|exists:kelas,id_kelas',
            'no_hp' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:100',
            'no_hp_orang_tua' => 'nullable|string|max:15',
        ]);

        $kelasObj = \App\Models\Kelas::findOrFail($request->id_kelas_fk);

        DB::beginTransaction();

        try {
            // 1. Buat Akun User login
            $user = User::create([
                'name' => $request->name,
                'username' => $request->nisn, // Username default menggunakan NISN
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'aktif',
            ]);

            $user->assignRole('siswa');

            // 2. Buat Profil Siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->name,
                'id_kelas_fk' => $kelasObj->id_kelas,
                'kelas' => $kelasObj->nama_kelas,
                'jurusan' => $kelasObj->jurusan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'id_pengguna_fk' => $user->id,
                'status' => 'aktif',
            ]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambah siswa: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $id . ',id_siswa',
            'nis' => 'required|string|max:10|unique:siswa,nis,' . $id . ',id_siswa',
            'id_kelas_fk' => 'required|exists:kelas,id_kelas',
            'no_hp' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:100|unique:users,email,' . $siswa->id_pengguna_fk,
            'password' => ['nullable', Rules\Password::defaults()],
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:100',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'status' => 'required|in:aktif,selesai,dropout',
        ]);

        $kelasObj = \App\Models\Kelas::findOrFail($request->id_kelas_fk);

        DB::beginTransaction();

        try {
            // Update User Account
            $user = User::findOrFail($siswa->id_pengguna_fk);
            $userUpdate = [
                'name' => $request->name,
                'username' => $request->nisn,
                'email' => $request->email,
                'status' => $request->status === 'aktif' ? 'aktif' : 'non_aktif',
            ];

            if ($request->filled('password')) {
                $userUpdate['password'] = Hash::make($request->password);
            }

            $user->update($userUpdate);

            // Update Profil Siswa
            $siswa->update([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->name,
                'id_kelas_fk' => $kelasObj->id_kelas,
                'kelas' => $kelasObj->nama_kelas,
                'jurusan' => $kelasObj->jurusan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui siswa: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus akun user
            if ($siswa->id_pengguna_fk) {
                User::destroy($siswa->id_pengguna_fk);
            }

            // Hapus data siswa
            $siswa->delete();

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus siswa: ' . $e->getMessage()]);
        }
    }
}
