<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianKompetensi extends Model
{
    use HasFactory;

    protected $table = 'penilaian_kompetensi';
    protected $primaryKey = 'id_penilaian_kompetensi';

    protected $fillable = [
        'id_penugasan_fk', 'id_siswa_fk', 'id_industri_penilai_fk',
        'nilai_rata_rata_kompetensi', 'catatan_umum', 'rekomendasi_industri',
        'status', 'tgl_penilaian'
    ];

    public function penugasan()
    {
        return $this->belongsTo(Penugasan::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa_fk', 'id_siswa');
    }

    public function industriPenilai()
    {
        return $this->belongsTo(User::class, 'id_industri_penilai_fk', 'id');
    }

    public function details()
    {
        return $this->hasMany(DetailPenilaianKompetensi::class, 'id_penilaian_kompetensi_fk', 'id_penilaian_kompetensi');
    }
}
