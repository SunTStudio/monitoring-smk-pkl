<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    // Radius geofencing default dalam satuan meter
    protected $allowedRadius = 100; 

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'bukti_foto' => 'required|image|max:2048', // Maks 2MB
            'status_kehadiran' => 'required|in:hadir,izin,sakit',
            'keterangan_izin' => 'nullable|string',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->withErrors(['error' => 'Anda bukan merupakan akun siswa.']);
        }

        // 1. Cari Penugasan Aktif Siswa
        $penugasan = Penugasan::where('id_siswa_fk', $siswa->id_siswa)
            ->where('status', 'aktif')
            ->first();

        if (!$penugasan) {
            return back()->withErrors(['error' => 'Anda belum terdaftar dalam penugasan PKL aktif.']);
        }

        // Cek apakah sudah absen hari ini
        $hariIni = Carbon::today()->toDateString();
        $sudahAbsen = Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
            ->where('tgl_absen', $hariIni)
            ->first();

        if ($sudahAbsen) {
            return back()->withErrors(['error' => 'Anda sudah melakukan absensi hari ini.']);
        }

        // 2. Validasi Geofencing (Hanya jika status_kehadiran = 'hadir')
        if ($request->status_kehadiran === 'hadir') {
            $industri = $penugasan->industri;

            if ($industri && $industri->latitude && $industri->longitude) {
                $jarak = $this->calculateDistance(
                    $request->latitude,
                    $request->longitude,
                    $industri->latitude,
                    $industri->longitude
                );

                if ($jarak > $this->allowedRadius) {
                    return back()->withErrors([
                        'error' => 'Posisi Anda terlalu jauh dari lokasi industri (' . round($jarak) . ' meter dari koordinat kantor). Batas aman adalah ' . $this->allowedRadius . ' meter.'
                    ]);
                }
            } else {
                // Jika koordinat industri belum di-set oleh admin, abaikan geofencing dlu demi kelancaran absen
            }
        }

        // 3. Simpan Bukti Foto Check-in
        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $foto = $request->file('bukti_foto');
            $fotoName = 'checkin_' . $siswa->id_siswa . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/absensi'), $fotoName);
            $fotoPath = 'uploads/absensi/' . $fotoName;
        }

        // 4. Buat Record Absensi
        Kehadiran::create([
            'id_penugasan_fk' => $penugasan->id_penugasan,
            'id_siswa_fk' => $siswa->id_siswa,
            'tgl_absen' => $hariIni,
            'status_kehadiran' => $request->status_kehadiran,
            'waktu_checkin' => Carbon::now()->toTimeString(),
            'lokasi_checkin' => $request->latitude . ',' . $request->longitude,
            'bukti_foto_checkin' => $fotoPath,
            'keterangan_izin' => $request->keterangan_izin,
            'id_pengguna_input' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Absensi masuk berhasil dicatat.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'bukti_foto' => 'required|image|max:2048',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->withErrors(['error' => 'Anda bukan merupakan akun siswa.']);
        }

        $hariIni = Carbon::today()->toDateString();

        // Cari record absensi check-in hari ini
        $kehadiran = Kehadiran::where('id_siswa_fk', $siswa->id_siswa)
            ->where('tgl_absen', $hariIni)
            ->first();

        if (!$kehadiran) {
            return back()->withErrors(['error' => 'Anda belum melakukan absensi masuk hari ini.']);
        }

        if ($kehadiran->waktu_checkout) {
            return back()->withErrors(['error' => 'Anda sudah melakukan absensi keluar hari ini.']);
        }

        // 1. Simpan Foto Checkout
        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $foto = $request->file('bukti_foto');
            $fotoName = 'checkout_' . $siswa->id_siswa . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/absensi'), $fotoName);
            $fotoPath = 'uploads/absensi/' . $fotoName;
        }

        // 2. Hitung Jam Kerja Riil
        $waktuCheckin = Carbon::parse($kehadiran->waktu_checkin);
        $waktuCheckout = Carbon::now();
        $jamKerjaReal = $waktuCheckin->diffInMinutes($waktuCheckout) / 60;

        // 3. Update Record
        $kehadiran->update([
            'waktu_checkout' => $waktuCheckout->toTimeString(),
            'bukti_foto_checkout' => $fotoPath,
            'jam_kerja_real' => round($jamKerjaReal, 2),
        ]);

        return redirect()->back()->with('success', 'Absensi keluar berhasil dicatat. Total jam kerja: ' . round($jamKerjaReal, 2) . ' jam.');
    }

    /**
     * Hitung jarak antara dua koordinat menggunakan rumus Haversine (meter)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
