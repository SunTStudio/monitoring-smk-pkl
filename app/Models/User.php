<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'username', 'email', 'password', 'status', 'catatan', 'id_industri_fk'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public function industriDetail()
    {
        return $this->belongsTo(Industri::class, 'id_industri_fk', 'id_industri');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_pengguna_fk', 'id');
    }

    public function penugasanSebagaiPembimbing()
    {
        return $this->hasMany(Penugasan::class, 'id_pembimbing_fk', 'id');
    }

    public function penugasanSebagaiIndustri()
    {
        return $this->hasMany(Penugasan::class, 'id_pengguna_industri_fk', 'id');
    }

    public function kunjunganIndustri()
    {
        return $this->hasMany(KunjunganIndustri::class, 'id_pembimbing_fk', 'id');
    }

    public function penilaianSikap()
    {
        return $this->hasMany(PenilaianSikap::class, 'id_pembimbing_fk', 'id');
    }

    public function penilaianKompetensi()
    {
        return $this->hasMany(PenilaianKompetensi::class, 'id_industri_penilai_fk', 'id');
    }
}
