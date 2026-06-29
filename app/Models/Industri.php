<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Industri extends Model
{
    use HasFactory;

    protected $table = 'industri';
    protected $primaryKey = 'id_industri';

    protected $fillable = [
        'nama_industri', 'jenis_industri', 'alamat_lengkap', 'kota', 'propinsi',
        'no_telp', 'email_industri', 'nama_kontak_person', 'jabatan_kontak', 'no_hp_kontak',
        'kapasitas_siswa', 'latitude', 'longitude', 'status', 'catatan'
    ];

    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'id_industri_fk', 'id_industri');
    }

    public function kunjunganIndustri()
    {
        return $this->hasMany(KunjunganIndustri::class, 'id_industri_fk', 'id_industri');
    }
}
