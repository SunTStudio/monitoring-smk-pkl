<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianSikap extends Model
{
    use HasFactory;

    protected $table = 'penilaian_sikap';
    protected $primaryKey = 'id_penilaian_sikap';

    protected $fillable = [
        'id_penugasan_fk', 'id_siswa_fk', 'id_pembimbing_fk', 'nilai_kedisiplinan',
        'nilai_kerjasama', 'nilai_tanggung_jawab', 'nilai_inisiatif',
        'nilai_rata_rata_sikap', 'catatan_kedisiplinan', 'catatan_kerjasama',
        'catatan_tanggung_jawab', 'catatan_inisiatif', 'catatan_umum',
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

    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'id_pembimbing_fk', 'id');
    }
}
