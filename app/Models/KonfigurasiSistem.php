<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonfigurasiSistem extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi_sistem';
    protected $primaryKey = 'id_konfigurasi';

    protected $fillable = [
        'nama_konfigurasi', 'nilai_konfigurasi', 'tipe_data', 'deskripsi'
    ];
}
