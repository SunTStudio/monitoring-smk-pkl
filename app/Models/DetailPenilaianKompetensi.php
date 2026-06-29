<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPenilaianKompetensi extends Model
{
    use HasFactory;

    protected $table = 'detail_penilaian_kompetensi';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_penilaian_kompetensi_fk', 'id_kompetensi_fk', 'nilai', 'catatan'
    ];

    public function penilaianKompetensi()
    {
        return $this->belongsTo(PenilaianKompetensi::class, 'id_penilaian_kompetensi_fk', 'id_penilaian_kompetensi');
    }

    public function kompetensiJurusan()
    {
        return $this->belongsTo(KompetensiJurusan::class, 'id_kompetensi_fk', 'id_kompetensi');
    }
}
