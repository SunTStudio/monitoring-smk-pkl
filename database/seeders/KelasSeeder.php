<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kombinasi kelas & jurusan unik dari siswa
        $uniqueClasses = Siswa::select('kelas', 'jurusan')
            ->distinct()
            ->get();

        foreach ($uniqueClasses as $item) {
            // Buat Kelas baru
            $kelas = Kelas::firstOrCreate([
                'nama_kelas' => $item->kelas,
                'jurusan' => $item->jurusan,
            ], [
                'keterangan' => 'Kelas Migrasi Otomatis ' . $item->kelas . ' ' . $item->jurusan
            ]);

            // Update siswa yang memilik kelas & jurusan tersebut
            Siswa::where('kelas', $item->kelas)
                ->where('jurusan', $item->jurusan)
                ->update(['id_kelas_fk' => $kelas->id_kelas]);
        }
    }
}
