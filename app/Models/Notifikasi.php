<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_pengguna_tujuan_fk', 'judul_notifikasi', 'pesan_notifikasi',
        'tipe_notifikasi', 'kategori', 'id_referensi', 'tipe_referensi',
        'status_dibaca', 'tgl_dibaca', 'tgl_notifikasi', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna_tujuan_fk', 'id');
    }
}
