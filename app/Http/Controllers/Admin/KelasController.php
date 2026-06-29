<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedTahun = $request->input('tahun_ajaran');

        $kelasQuery = Kelas::query();

        if ($search) {
            $kelasQuery->where(function($query) use ($search) {
                $query->where('nama_kelas', 'like', "%{$search}%")
                      ->orWhere('jurusan', 'like', "%{$search}%")
                      ->orWhere('tahun_ajaran', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($selectedTahun) {
            $kelasQuery->where('tahun_ajaran', $selectedTahun);
        }

        $kelas = $kelasQuery->with('siswa.nilaiAkhir')->get();
        $tahunAjaranList = Kelas::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        return view('admin.kelas.index', compact('kelas', 'search', 'tahunAjaranList', 'selectedTahun'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Cek jika masih ada siswa yang terdaftar di kelas ini
        if ($kelas->siswa()->count() > 0) {
            return back()->withErrors(['error' => 'Kelas tidak dapat dihapus karena masih ada siswa yang terdaftar di kelas ini.']);
        }

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
