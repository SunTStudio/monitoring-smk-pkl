<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_penugasan_fk', 'id_siswa_fk', 'tgl_laporan', 'jam_mulai_kerja',
        'jam_selesai_kerja', 'jam_kerja_total', 'aktivitas_pekerjaan',
        'hasil_pekerjaan', 'skill_dipraktikkan', 'kendala_hambatan',
        'pembelajaran_didapat', 'file_lampiran', 'status',
        'feedback_pembimbing', 'id_pembimbing_review', 'tgl_review'
    ];

    public function penugasan()
    {
        return $this->belongsTo(Penugasan::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa_fk', 'id_siswa');
    }

    public function pembimbingReview()
    {
        return $this->belongsTo(User::class, 'id_pembimbing_review', 'id');
    }
}
