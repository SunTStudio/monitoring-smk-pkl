<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penugasan;
use Illuminate\Support\Facades\Hash;

class DemoTahunLaluSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kelas Angkatan Tahun Lalu (2024/2025)
        $kelasRplLalu = Kelas::firstOrCreate([
            'nama_kelas' => 'XII - RPL (2024)',
            'jurusan' => 'RPL',
        ], [
            'tahun_ajaran' => '2024/2025',
            'keterangan' => 'Kelas RPL angkatan tahun ajaran lalu 2024/2025'
        ]);

        $kelasTkjLalu = Kelas::firstOrCreate([
            'nama_kelas' => 'XII - TKJ (2024)',
            'jurusan' => 'TKJ',
        ], [
            'tahun_ajaran' => '2024/2025',
            'keterangan' => 'Kelas TKJ angkatan tahun ajaran lalu 2024/2025'
        ]);

        // 2. Buat Akun Siswa 1 (Budi - RPL Tahun Lalu)
        $userBudi = User::updateOrCreate([
            'username' => '0041112223',
        ], [
            'name' => 'Budi Santoso (Alumni)',
            'email' => 'budi.alumni@smkadvance.sch.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        if (!$userBudi->hasRole('siswa')) {
            $userBudi->assignRole('siswa');
        }

        $siswaBudi = Siswa::updateOrCreate([
            'nisn' => '0041112223',
        ], [
            'nis' => '2425001',
            'nama_lengkap' => 'Budi Santoso',
            'id_kelas_fk' => $kelasRplLalu->id_kelas,
            'kelas' => $kelasRplLalu->nama_kelas,
            'jurusan' => $kelasRplLalu->jurusan,
            'no_hp' => '081222333444',
            'email' => $userBudi->email,
            'alamat' => 'Jl. Kenanga No. 12, Solo',
            'nama_orang_tua' => 'Bapak Joko Santoso',
            'no_hp_orang_tua' => '081222333555',
            'id_pengguna_fk' => $userBudi->id,
            'status' => 'selesai',
        ]);

        // 3. Buat Akun Siswa 2 (Citra - TKJ Tahun Lalu)
        $userCitra = User::updateOrCreate([
            'username' => '0049998887',
        ], [
            'name' => 'Citra Lestari (Alumni)',
            'email' => 'citra.alumni@smkadvance.sch.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        if (!$userCitra->hasRole('siswa')) {
            $userCitra->assignRole('siswa');
        }

        $siswaCitra = Siswa::updateOrCreate([
            'nisn' => '0049998887',
        ], [
            'nis' => '2425002',
            'nama_lengkap' => 'Citra Lestari',
            'id_kelas_fk' => $kelasTkjLalu->id_kelas,
            'kelas' => $kelasTkjLalu->nama_kelas,
            'jurusan' => $kelasTkjLalu->jurusan,
            'no_hp' => '087888999000',
            'email' => $userCitra->email,
            'alamat' => 'Jl. Mawar No. 45, Solo',
            'nama_orang_tua' => 'Bapak Hartono',
            'no_hp_orang_tua' => '087888999111',
            'id_pengguna_fk' => $userCitra->id,
            'status' => 'selesai',
        ]);

        // 4. Hubungkan Penugasan PKL Lalu (Selesai)
        Penugasan::updateOrCreate([
            'id_siswa_fk' => $siswaBudi->id_siswa,
            'id_industri_fk' => 1,
            'id_pembimbing_fk' => 2,
        ], [
            'tgl_mulai_pkl' => '2024-07-01',
            'tgl_selesai_pkl' => '2024-10-01',
            'durasi_hari' => 90,
            'status' => 'selesai',
            'catatan' => 'Siswa telah menyelesaikan kegiatan PKL angkatan lalu dengan baik.',
        ]);

        Penugasan::updateOrCreate([
            'id_siswa_fk' => $siswaCitra->id_siswa,
            'id_industri_fk' => 1,
            'id_pembimbing_fk' => 2,
        ], [
            'tgl_mulai_pkl' => '2024-07-01',
            'tgl_selesai_pkl' => '2024-10-01',
            'durasi_hari' => 90,
            'status' => 'selesai',
            'catatan' => 'Siswa telah menyelesaikan kegiatan PKL angkatan lalu dengan baik.',
        ]);

        // 5. Generate data absensi dan jurnal harian Budi Santoso selama sebulan penuh (Juli 2024)
        $penugasanBudi = Penugasan::where('id_siswa_fk', $siswaBudi->id_siswa)->first();
        
        $totalDays = 30;
        $sumGuru = 0;
        $sumDudi = 0;
        $workdaysCount = 0;
        
        for ($day = 1; $day <= $totalDays; $day++) {
            $date = sprintf('2024-07-%02d', $day);
            
            // Lewati hari Minggu (simulasi hari libur)
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek == 7) {
                continue;
            }
            
            $workdaysCount++;
            
            // Buat Absensi Hadir
            \App\Models\Kehadiran::updateOrCreate([
                'id_siswa_fk' => $siswaBudi->id_siswa,
                'id_penugasan_fk' => $penugasanBudi->id_penugasan,
                'tgl_absen' => $date,
            ], [
                'waktu_checkin' => '07:48:12',
                'waktu_checkout' => '17:03:45',
                'status_kehadiran' => 'hadir',
                'lokasi_checkin' => 'PT ABC Electronics HQ',
                'bukti_foto_checkin' => 'demo_bukti.jpg',
            ]);
            
            // Buat Jurnal Laporan Harian beserta Penilaian
            $nilaiGuru = rand(82, 94);
            $nilaiDudi = rand(85, 97);
            $sumGuru += $nilaiGuru;
            $sumDudi += $nilaiDudi;
            
            \App\Models\LaporanHarian::updateOrCreate([
                'id_siswa_fk' => $siswaBudi->id_siswa,
                'id_penugasan_fk' => $penugasanBudi->id_penugasan,
                'tgl_laporan' => $date,
            ], [
                'jam_mulai_kerja' => '08:00:00',
                'jam_selesai_kerja' => '17:00:00',
                'aktivitas_pekerjaan' => 'Pekerjaan harian pengembangan modul ' . $day . ': Analisis kebutuhan, pembuatan REST API, penulisan script unit test.',
                'hasil_pekerjaan' => 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.',
                'skill_dipraktikkan' => 'Laravel PHP, Bootstrap 5, MySQL',
                'status' => 'approved',
                'nilai_guru' => $nilaiGuru,
                'nilai_dudi' => $nilaiDudi,
            ]);
        }
        
        // Hitung Nilai Akhir
        $avgGuru = $sumGuru / $workdaysCount;
        $avgDudi = $sumDudi / $workdaysCount;
        $nilaiKehadiran = 100; // Hadir penuh di semua hari kerja
        
        $nilaiAkhir = ($nilaiKehadiran * 0.20) + ($avgGuru * 0.30) + ($avgDudi * 0.50);
        
        $grade = 'E';
        if ($nilaiAkhir >= 85) {
            $grade = 'A';
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B';
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C';
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'D';
        }
        
        \App\Models\NilaiAkhir::updateOrCreate([
            'id_siswa_fk' => $siswaBudi->id_siswa,
            'id_penugasan_fk' => $penugasanBudi->id_penugasan,
        ], [
            'nilai_kehadiran' => $nilaiKehadiran,
            'nilai_sikap_bobot' => round($avgGuru, 2),
            'nilai_kompetensi_bobot' => round($avgDudi, 2),
            'nilai_akhir_pkl' => round($nilaiAkhir, 2),
            'grade' => $grade,
            'status_kelulusan' => 'lulus',
            'no_sertifikat' => 'CERT-2024-RPL-088',
            'tgl_finalisasi' => '2024-10-01',
            'total_hari_hadir' => $workdaysCount,
            'total_hari_pkl' => $workdaysCount,
            'id_yang_finalisasi' => 2, // ID Pembimbing Guru
            'catatan' => 'Siswa menyelesaikan tugas tepat waktu dengan inisiatif dan kemandirian yang sangat baik.',
        ]);
    }
}
