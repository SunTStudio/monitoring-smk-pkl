<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\KunjunganIndustri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KunjunganIndustriController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_industri_fk' => 'required|exists:industri,id_industri',
            'tgl_kunjungan' => 'required|date',
            'catatan_monitoring' => 'required|string',
            'foto_kunjungan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072', // Maks 3MB
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_kunjungan')) {
            $foto = $request->file('foto_kunjungan');
            $fotoName = 'visitation_' . Auth::id() . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = 'storage/' . Storage::disk('public')->putFileAs('uploads/kunjungan', $foto, $fotoName);
        }

        KunjunganIndustri::create([
            'id_pembimbing_fk' => Auth::id(),
            'id_industri_fk' => $request->id_industri_fk,
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'catatan_monitoring' => $request->catatan_monitoring,
            'foto_kunjungan' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Log monitoring kunjungan industri berhasil dicatat.');
    }
}
