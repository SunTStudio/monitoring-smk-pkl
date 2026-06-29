# Data Akun Uji Coba (Demo Accounts) - E-Monitoring PKL SMK

Gunakan data akun di bawah ini untuk mencoba login ke sistem E-Monitoring PKL dengan berbagai peran pengguna.

## 1. Daftar Akun Pengujian

| Peran (Role) | Username (untuk Login) | Email | Password | Halaman Dashboard | Deskripsi Akun |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `admin@smkadvance.sch.id` | `password123` | `/admin/dashboard` | Akun administrator sekolah |
| **Guru Pembimbing** | `pembimbing` | `pembimbing@smkadvance.sch.id` | `password123` | `/pembimbing/dashboard` | Ibu Siti Nurhaliza, S.Pd. (RPL) |
| **Koordinator PKL** | `koordinator` | `koordinator@smkadvance.sch.id` | `password123` | `/admin/dashboard` | Bapak Bambang Riyanto, M.T. |
| **Mitra Industri (DU-DI)** | `industri` | `industri@smkadvance.sch.id` | `password123` | `/industri/dashboard` | PT ABC Electronics (Budi Utomo) |
| **Siswa 1 (RPL)** | `0051234567` | `siswa@smkadvance.sch.id` | `password123` | `/siswa/dashboard` | Ahmad Maulana (Aktif PKL di PT ABC) |
| **Siswa 2 (TKJ)** | `0067654321` | `dewi@smkadvance.sch.id` | `password123` | `/siswa/dashboard` | Dewi Lestari (Belum ditempatkan) |

*Catatan: Anda dapat login menggunakan **Username** atau **Email** di atas.*

---

## 2. Simulasi Login Industri (Magic Link)

Anda dapat mencoba metode login instan satu klik tanpa kata sandi khusus untuk peran industri:

1. Buka browser dan pergi ke halaman login, klik **Login Industri Tanpa Password** (atau akses `http://127.0.0.1:8000/magic-link`).
2. Masukkan email: `industri@smkadvance.sch.id`.
3. Klik tombol **Dapatkan Magic Link Masuk**.
4. Sistem akan mendeteksi lingkungan lokal dan memunculkan tombol kuning simulasi **Masuk Sebagai Industri Sekarang**. Klik tombol tersebut untuk masuk otomatis.

---

## 3. Registrasi Siswa Baru Mandiri

Selain menggunakan akun siswa yang di-seed di atas, Anda juga dapat mendaftar mandiri:
1. Akses halaman pendaftaran di `http://127.0.0.1:8000/register`.
2. Lengkapi formulir pendaftaran siswa baru.
3. Setelah klik **Daftarkan Akun**, Anda akan otomatis masuk ke `/siswa/dashboard`.
