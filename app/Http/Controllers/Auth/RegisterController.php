<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nis' => 'required|string|max:10|unique:siswa,nis',
            'kelas' => 'required|string|max:5',
            'jurusan' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:100',
            'no_hp_orang_tua' => 'nullable|string|max:15',
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat User Account
            $user = User::create([
                'name' => $request->name,
                'username' => $request->nisn, // Username disamakan dengan NISN siswa
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'aktif',
            ]);

            // Assign Spatie Role 'siswa'
            $user->assignRole('siswa');

            // 2. Buat Data Profil Siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->name,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'id_pengguna_fk' => $user->id,
                'status' => 'aktif',
            ]);

            DB::commit();

            // Login otomatis setelah registrasi
            Auth::login($user);

            return redirect('/siswa/dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan sistem saat mendaftar: ' . $e->getMessage(),
            ])->withInput();
        }
    }
}
