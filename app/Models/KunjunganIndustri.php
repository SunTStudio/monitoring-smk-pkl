<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KunjunganIndustri extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_industri';
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'id_pembimbing_fk', 'id_industri_fk', 'tgl_kunjungan',
        'catatan_monitoring', 'foto_kunjungan'
    ];

    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'id_pembimbing_fk', 'id');
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'id_industri_fk', 'id_industri');
    }
}
