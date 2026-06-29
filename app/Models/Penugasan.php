<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';
    protected $primaryKey = 'id_penugasan';

    protected $fillable = [
        'id_siswa_fk', 'id_industri_fk', 'id_pembimbing_fk', 'id_pengguna_industri_fk',
        'tgl_mulai_pkl', 'tgl_selesai_pkl', 'durasi_hari', 'lokasi_kerja',
        'divisi_departemen', 'pembimbing_industri', 'status', 'catatan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa_fk', 'id_siswa');
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'id_industri_fk', 'id_industri');
    }

    public function pembimbingSekolah()
    {
        return $this->belongsTo(User::class, 'id_pembimbing_fk', 'id');
    }

    public function pembimbingIndustri()
    {
        return $this->belongsTo(User::class, 'id_pengguna_industri_fk', 'id');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function laporanHarian()
    {
        return $this->hasMany(LaporanHarian::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function penilaianSikap()
    {
        return $this->hasMany(PenilaianSikap::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function penilaianKompetensi()
    {
        return $this->hasMany(PenilaianKompetensi::class, 'id_penugasan_fk', 'id_penugasan');
    }

    public function nilaiAkhir()
    {
        return $this->hasMany(NilaiAkhir::class, 'id_penugasan_fk', 'id_penugasan');
    }
}
