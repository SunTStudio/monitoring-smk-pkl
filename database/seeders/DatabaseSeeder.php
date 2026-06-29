<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Spatie Roles
        $roles = ['admin', 'pembimbing', 'koordinator', 'industri', 'siswa'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Membuat Akun Admin Default
        $admin = User::firstOrCreate(
            ['email' => 'admin@smkadvance.sch.id'],
            [
                'name' => 'Admin Sekolah',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Akun admin utama sistem monitoring PKL.',
            ]
        );

        // Assign Role ke Admin
        $admin->assignRole('admin');

        // 3. Membuat Contoh Akun Pembimbing Sekolah (Guru)
        $pembimbing = User::firstOrCreate(
            ['email' => 'pembimbing@smkadvance.sch.id'],
            [
                'name' => 'Ibu Siti Nurhaliza, S.Pd.',
                'username' => 'pembimbing',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Guru Pembimbing Jurusan RPL.',
            ]
        );
        $pembimbing->assignRole('pembimbing');

        // 4. Membuat Contoh Akun Koordinator PKL
        $koordinator = User::firstOrCreate(
            ['email' => 'koordinator@smkadvance.sch.id'],
            [
                'name' => 'Bapak Bambang Riyanto, M.T.',
                'username' => 'koordinator',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Koordinator PKL Sekolah.',
            ]
        );
        $koordinator->assignRole('koordinator');

        // 5. Membuat Contoh Akun Industri (DU-DI)
        $industri = User::firstOrCreate(
            ['email' => 'industri@smkadvance.sch.id'],
            [
                'name' => 'PT ABC Electronics (Budi)',
                'username' => 'industri',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Akun Mitra Industri DU-DI.',
            ]
        );
        $industri->assignRole('industri');

        // 6. Membuat Contoh Mitra Industri di Tabel Industri
        $mitra = \App\Models\Industri::firstOrCreate(
            ['nama_industri' => 'PT ABC Electronics'],
            [
                'jenis_industri' => 'Software Development',
                'alamat_lengkap' => 'Jl. Genteng Kali No. 10',
                'kota' => 'Surabaya',
                'propinsi' => 'Jawa Timur',
                'no_telp' => '0315551234',
                'email_industri' => 'info@abcelectronics.co.id',
                'nama_kontak_person' => 'Budi Utomo',
                'jabatan_kontak' => 'HRD Manager',
                'no_hp_kontak' => '08123456789',
                'kapasitas_siswa' => 5,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'status' => 'aktif',
            ]
        );

        // 7. Membuat Contoh Akun Siswa 1 (Ahmad Maulana)
        $userSiswa1 = User::firstOrCreate(
            ['email' => 'siswa@smkadvance.sch.id'],
            [
                'name' => 'Ahmad Maulana',
                'username' => '0051234567', // Username = NISN
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Akun login siswa Ahmad.',
            ]
        );
        $userSiswa1->assignRole('siswa');

        $siswa1 = \App\Models\Siswa::firstOrCreate(
            ['nisn' => '0051234567'],
            [
                'nis' => '12345',
                'nama_lengkap' => 'Ahmad Maulana',
                'kelas' => 'XII',
                'jurusan' => 'RPL',
                'no_hp' => '082233445566',
                'email' => 'siswa@smkadvance.sch.id',
                'alamat' => 'Jl. Dharmahusada Indah No. 50, Surabaya',
                'nama_orang_tua' => 'Slamet Maulana',
                'no_hp_orang_tua' => '081122334455',
                'id_pengguna_fk' => $userSiswa1->id,
                'status' => 'aktif',
            ]
        );

        // 8. Membuat Contoh Akun Siswa 2 (Dewi Lestari)
        $userSiswa2 = User::firstOrCreate(
            ['email' => 'dewi@smkadvance.sch.id'],
            [
                'name' => 'Dewi Lestari',
                'username' => '0067654321', // Username = NISN
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'catatan' => 'Akun login siswa Dewi.',
            ]
        );
        $userSiswa2->assignRole('siswa');

        \App\Models\Siswa::firstOrCreate(
            ['nisn' => '0067654321'],
            [
                'nis' => '12346',
                'nama_lengkap' => 'Dewi Lestari',
                'kelas' => 'XII',
                'jurusan' => 'TKJ',
                'no_hp' => '087788990011',
                'email' => 'dewi@smkadvance.sch.id',
                'alamat' => 'Jl. Gubeng Kertajaya No. 12, Surabaya',
                'nama_orang_tua' => 'Hendro Lestari',
                'no_hp_orang_tua' => '087788889999',
                'id_pengguna_fk' => $userSiswa2->id,
                'status' => 'aktif',
            ]
        );

        // 9. Membuat Contoh Alokasi Penugasan PKL (Ahmad Maulana ditempatkan di PT ABC Electronics)
        \App\Models\Penugasan::firstOrCreate(
            [
                'id_siswa_fk' => $siswa1->id_siswa,
                'id_industri_fk' => $mitra->id_industri,
            ],
            [
                'id_pembimbing_fk' => $pembimbing->id,
                'id_pengguna_industri_fk' => $industri->id,
                'tgl_mulai_pkl' => Carbon::now()->toDateString(),
                'tgl_selesai_pkl' => Carbon::now()->addMonths(3)->toDateString(),
                'durasi_hari' => 90,
                'lokasi_kerja' => 'Main Office Surabaya',
                'divisi_departemen' => 'IT Support & Development',
                'pembimbing_industri' => 'Budi Utomo',
                'status' => 'aktif',
                'catatan' => 'Penugasan perdana uji coba sistem.',
            ]
        );
    }
}
