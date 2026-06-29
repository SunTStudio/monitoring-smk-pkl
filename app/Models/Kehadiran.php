<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';

    protected $fillable = [
        'id_penugasan_fk', 'id_siswa_fk', 'tgl_absen', 'status_kehadiran',
        'waktu_checkin', 'waktu_checkout', 'jam_kerja_real', 'lokasi_checkin',
        'bukti_foto_checkin', 'bukti_foto_checkout', 'keterangan_izin',
        'id_pengguna_input', 'catatan'
    ];

    public function penugasan()
    {
        return $this->belongsTo(Penugasan::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa_fk', 'id_siswa');
    }

    public function penggunaInput()
    {
        return $this->belongsTo(User::class, 'id_pengguna_input', 'id');
    }
}
