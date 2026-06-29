<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $industri = Industri::with('penugasan.siswa')->when($search, function ($query, $search) {
            return $query->where('nama_industri', 'like', "%{$search}%")
                         ->orWhere('jenis_industri', 'like', "%{$search}%")
                         ->orWhere('kota', 'like', "%{$search}%")
                         ->orWhere('nama_kontak_person', 'like', "%{$search}%");
        })->get();

        return view('admin.industri.index', compact('industri', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_industri' => 'required|string|max:150',
            'jenis_industri' => 'nullable|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'nullable|string|max:50',
            'propinsi' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:15',
            'email_industri' => 'nullable|email|max:100',
            'nama_kontak_person' => 'nullable|string|max:100',
            'jabatan_kontak' => 'nullable|string|max:50',
            'no_hp_kontak' => 'nullable|string|max:15',
            'kapasitas_siswa' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:aktif,non_aktif,archived',
            'catatan' => 'nullable|string',
        ]);

        Industri::create($validated);

        return redirect()->route('industri.index')->with('success', 'Data industri berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $industri = Industri::findOrFail($id);

        $validated = $request->validate([
            'nama_industri' => 'required|string|max:150',
            'jenis_industri' => 'nullable|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'nullable|string|max:50',
            'propinsi' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:15',
            'email_industri' => 'nullable|email|max:100',
            'nama_kontak_person' => 'nullable|string|max:100',
            'jabatan_kontak' => 'nullable|string|max:50',
            'no_hp_kontak' => 'nullable|string|max:15',
            'kapasitas_siswa' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:aktif,non_aktif,archived',
            'catatan' => 'nullable|string',
        ]);

        $industri->update($validated);

        return redirect()->route('industri.index')->with('success', 'Data industri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $industri = Industri::findOrFail($id);
        $industri->delete();

        return redirect()->route('industri.index')->with('success', 'Data industri berhasil dihapus.');
    }
}
