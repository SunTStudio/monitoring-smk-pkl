<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasLog extends Model
{
    protected $table = 'aktivitas_log';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna_fk', 'tipe_aktivitas', 'deskripsi_aktivitas',
        'tabel_terdampak', 'id_record_terdampak', 'nilai_lama',
        'nilai_baru', 'ip_address', 'user_agent', 'tgl_aktivitas', 'status'
    ];

    protected $casts = [
        'nilai_lama' => 'array',
        'nilai_baru' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna_fk', 'id');
    }
}
