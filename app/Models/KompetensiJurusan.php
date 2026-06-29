<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetensiJurusan extends Model
{
    use HasFactory;

    protected $table = 'kompetensi_jurusan';
    protected $primaryKey = 'id_kompetensi';

    protected $fillable = [
        'jurusan', 'nama_aspek', 'deskripsi_aspek'
    ];

    public function detailPenilaianKompetensi()
    {
        return $this->hasMany(DetailPenilaianKompetensi::class, 'id_kompetensi_fk', 'id_kompetensi');
    }
}
