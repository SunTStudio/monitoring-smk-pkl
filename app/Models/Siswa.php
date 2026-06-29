<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nisn', 'nis', 'nama_lengkap', 'kelas', 'jurusan',
        'no_hp', 'email', 'alamat', 'nama_orang_tua', 'no_hp_orang_tua',
        'id_pengguna_fk', 'status', 'id_kelas_fk'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna_fk', 'id');
    }

    public function kelasDetail()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas_fk', 'id_kelas');
    }

    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'id_siswa_fk', 'id_siswa');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_siswa_fk', 'id_siswa');
    }

    public function laporanHarian()
    {
        return $this->hasMany(LaporanHarian::class, 'id_siswa_fk', 'id_siswa');
    }

    public function penilaianSikap()
    {
        return $this->hasMany(PenilaianSikap::class, 'id_siswa_fk', 'id_siswa');
    }

    public function penilaianKompetensi()
    {
        return $this->hasMany(PenilaianKompetensi::class, 'id_siswa_fk', 'id_siswa');
    }

    public function nilaiAkhir()
    {
        return $this->hasMany(NilaiAkhir::class, 'id_siswa_fk', 'id_siswa');
    }
}
