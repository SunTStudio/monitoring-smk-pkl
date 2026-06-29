<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiAkhir extends Model
{
    use HasFactory;

    protected $table = 'nilai_akhir';
    protected $primaryKey = 'id_nilai_akhir';

    protected $fillable = [
        'id_penugasan_fk', 'id_siswa_fk', 'periode_pkl', 'total_hari_pkl',
        'total_hari_hadir', 'nilai_kehadiran', 'nilai_sikap_bobot',
        'nilai_kompetensi_bobot', 'nilai_akhir_pkl', 'grade',
        'status_kelulusan', 'catatan_kelulusan', 'id_yang_finalisasi',
        'tgl_finalisasi', 'tgl_cetak', 'no_sertifikat', 'catatan'
    ];

    public function penugasan()
    {
        return $this->belongsTo(Penugasan::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa_fk', 'id_siswa');
    }

    public function yangFinalisasi()
    {
        return $this->belongsTo(User::class, 'id_yang_finalisasi', 'id');
    }
}
