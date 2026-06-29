<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'pembimbing');

        $query = User::with(['roles', 'industriDetail']);

        if ($activeTab === 'pembimbing') {
            $query->role('pembimbing');
        } elseif ($activeTab === 'industri') {
            $query->role('industri');
        } elseif ($activeTab === 'staf') {
            $query->whereHas('roles', function($q) {
                $q->whereIn('name', ['admin', 'koordinator']);
            });
        } elseif ($activeTab === 'siswa') {
            $query->role('siswa');
        } else {
            $activeTab = 'pembimbing';
            $query->role('pembimbing');
        }

        $users = $query->get();
        $roles = Role::all();
        $industriList = \App\Models\Industri::all();

        return view('admin.users.index', compact('users', 'roles', 'activeTab', 'industriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:aktif,non_aktif',
            'id_industri_fk' => 'nullable|exists:industri,id_industri',
            'catatan' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'catatan' => $request->catatan,
            'id_industri_fk' => $request->role === 'industri' ? $request->id_industri_fk : null,
        ]);

        $user->assignRole($request->role);

        $tab = 'pembimbing';
        if ($request->role === 'industri') {
            $tab = 'industri';
        } elseif ($request->role === 'siswa') {
            $tab = 'siswa';
        } elseif ($request->role === 'admin' || $request->role === 'koordinator') {
            $tab = 'staf';
        }

        return redirect()->route('users.index', ['tab' => $tab])->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => 'required|string|email|max:100|unique:users,email,' . $id,
            'password' => ['nullable', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:aktif,non_aktif',
            'id_industri_fk' => 'nullable|exists:industri,id_industri',
            'catatan' => 'nullable|string',
        ]);

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'id_industri_fk' => $request->role === 'industri' ? $request->id_industri_fk : null,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);
        $user->syncRoles([$request->role]);

        $tab = 'pembimbing';
        if ($request->role === 'industri') {
            $tab = 'industri';
        } elseif ($request->role === 'siswa') {
            $tab = 'siswa';
        } elseif ($request->role === 'admin' || $request->role === 'koordinator') {
            $tab = 'staf';
        }

        return redirect()->route('users.index', ['tab' => $tab])->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $tab = 'pembimbing';
        if ($user->hasRole('industri')) {
            $tab = 'industri';
        } elseif ($user->hasRole('siswa')) {
            $tab = 'siswa';
        } elseif ($user->hasRole('admin') || $user->hasRole('koordinator')) {
            $tab = 'staf';
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index', ['tab' => $tab])->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        // Cek jika user ini berelasi sebagai siswa
        if ($user->hasRole('siswa') && \App\Models\Siswa::where('id_pengguna_fk', $user->id)->exists()) {
            return redirect()->route('users.index', ['tab' => $tab])->with('error', 'Akun ini terhubung ke data siswa master. Harap hapus data siswa terlebih dahulu di Manajemen Siswa.');
        }

        $user->delete();

        return redirect()->route('users.index', ['tab' => $tab])->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
