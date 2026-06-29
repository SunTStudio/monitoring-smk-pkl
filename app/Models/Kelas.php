<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas', 'jurusan', 'tahun_ajaran', 'keterangan'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas_fk', 'id_kelas');
    }
}
