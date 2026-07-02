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
        'jurusan', 'nama_aspek', 'deskripsi_aspek',
        'kategori', 'bobot', 'urutan', 'is_universal'
    ];

    protected $casts = [
        'is_universal' => 'boolean',
        'bobot' => 'decimal:2',
    ];

    // Scope: only a specific jurusan + universal
    public function scopeUntukJurusan($query, string $jurusan)
    {
        return $query->where(function ($q) use ($jurusan) {
            $q->where('jurusan', $jurusan)->orWhere('is_universal', true);
        })->orderBy('kategori')->orderBy('urutan');
    }

    // Scope: only hardskill
    public function scopeHardSkill($query)
    {
        return $query->where('kategori', 'hardskill');
    }

    // Scope: only softskill
    public function scopeSoftSkill($query)
    {
        return $query->where('kategori', 'softskill');
    }

    public function detailPenilaianKompetensi()
    {
        return $this->hasMany(DetailPenilaianKompetensi::class, 'id_kompetensi_fk', 'id_kompetensi');
    }

    public function laporanHarian()
    {
        return $this->belongsToMany(
            LaporanHarian::class,
            'laporan_skill_tag',
            'id_kompetensi_fk',
            'id_laporan_fk',
            'id_kompetensi',
            'id_laporan'
        )->withTimestamps();
    }
}
