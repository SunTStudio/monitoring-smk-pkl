# KONSEP WEBSITE MONITORING PKL SMK ADVANCE
## Dari Registrasi Hingga Cetak Nilai

---

## DAFTAR ISI
1. [Gambaran Umum Sistem](#gambaran-umum-sistem)
2. [User Roles & Permissions](#user-roles--permissions)
3. [Modul & Fitur Utama](#modul--fitur-utama)
4. [Struktur Database](#struktur-database)
5. [Alur Proses Lengkap](#alur-proses-lengkap)
6. [Teknologi Stack](#teknologi-stack)
7. [Mockup Interface](#mockup-interface)
8. [Keamanan & Validasi](#keamanan--validasi)
9. [Timeline Implementasi](#timeline-implementasi)
10. [Keunggulan Sistem](#keunggulan-sistem)

---

## GAMBARAN UMUM SISTEM

Website monitoring PKL SMK Advance adalah platform terintegrasi yang dirancang untuk:

- **Memantau** praktik kerja lapangan siswa secara real-time
- **Mengelola** data siswa, industri, dan pembimbing
- **Menilai** siswa berdasarkan multi-kriteria (sikap, kompetensi, kehadiran)
- **Menghasilkan** laporan dan sertifikat otomatis
- **Mengintegrasikan** data antara sekolah, siswa, dan industri

### Target Users
- **Admin Sekolah** - Mengelola sistem keseluruhan
- **Pembimbing Sekolah** - Monitor siswa & input nilai
- **Siswa** - Input laporan harian & lihat nilai
- **Industri/DU-DI** - Nilai siswa & monitoring kehadiran (dipermudah dengan Magic Link WhatsApp/Email tanpa password)
- **Koordinator PKL** - Validasi data & monitoring umum

---

## USER ROLES & PERMISSIONS

### 1. ADMIN
**Deskripsi**: Pengelola sistem utama

**Hak Akses**:
- ✓ Kelola user (tambah, edit, hapus)
- ✓ Setup periode PKL dan tahun ajaran
- ✓ Manage daftar industri
- ✓ Assign siswa ke industri
- ✓ Assign pembimbing ke siswa
- ✓ Backup & maintenance database
- ✓ Lihat laporan komprehensif
- ✓ Validasi data final
- ✓ Generate laporan sistem

**Dashboard Utama**:
- Statistik keseluruhan sistem
- List semua siswa & status
- List semua industri & kapasitas
- Monitoring kehadiran real-time
- Button finalisasi & cetak nilai

---

### 2. PEMBIMBING SEKOLAH
**Deskripsi**: Pembimbing akademik yang monitor siswa

**Hak Akses**:
- ✓ Lihat siswa yang dibimbing
- ✓ Input nilai sikap/perilaku (4 aspek)
- ✓ Monitor kehadiran siswa
- ✓ Review daily log siswa
- ✓ Beri feedback/komentar
- ✓ Generate sertifikat PKL
- ✓ Lihat grafik progress
- ✓ Export laporan siswa
- ✗ Input nilai kompetensi (hanya industri)
- ✗ Manage user atau sistem

**Dashboard Utama**:
- Ringkasan siswa bimbing (total, hadir, alpa)
- List siswa dengan status
- Form input nilai sikap
- Notifikasi siswa yang alpa
- Chart progress per siswa

---

### 3. SISWA
**Deskripsi**: Peserta PKL

**Hak Akses**:
- ✓ Login & lihat profil
- ✓ Submit daily log (jurnal harian)
- ✓ Upload bukti aktivitas (foto/file)
- ✓ Lihat feedback pembimbing
- ✓ Lihat nilai sementara
- ✓ Lihat transkrip nilai
- ✓ Download sertifikat
- ✗ Edit nilai
- ✗ Lihat data siswa lain
- ✗ Akses sistem admin

**Dashboard Utama**:
- Info PKL (industri, pembimbing, durasi)
- Countdown sisa hari PKL
- Progress kehadiran (progress bar)
- Form submit laporan harian
- Upload bukti aktivitas
- Nilai sementara
- Feedback dari pembimbing & industri

---

### 4. INDUSTRI/DU-DI
**Deskripsi**: Pihak industri sebagai tempat PKL

**Hak Akses**:
- ✓ Login khusus industri (atau via Magic Link WhatsApp/Email tanpa password)
- ✓ Lihat daftar siswa di industri mereka
- ✓ Input nilai kompetensi (5 aspek)
- ✓ Monitor kehadiran siswa
- ✓ Beri feedback/rating siswa
- ✓ Generate surat rekomendasi
- ✓ Export laporan siswa
- ✗ Input nilai sikap (hanya pembimbing)
- ✗ Kelola data industri lain
- ✗ Edit sistem

**Dashboard Utama**:
- List siswa di industri mereka
- Form input nilai kompetensi
- Monitoring kehadiran harian
- Upload feedback/rekomendasi
- Chart performa siswa
- Export laporan

---

### 5. KOORDINATOR PKL
**Deskripsi**: Koordinator PKL di sekolah

**Hak Akses**:
- ✓ Kelola alokasi siswa ke industri
- ✓ Monitor progress keseluruhan
- ✓ Generate laporan kondisional
- ✓ Validasi data sebelum cetak
- ✓ Lihat statistik PKL
- ✓ Generate undangan PKL
- ✓ Koordinasi dengan pembimbing & industri
- ✓ Export data untuk kepala sekolah

**Dashboard Utama**:
- Statistik PKL (total siswa, industri, pembimbing)
- Status keseluruhan siswa
- Monitoring progress per periode
- List tugas validasi
- Generate laporan periodik

---

## MODUL & FITUR UTAMA

### MODUL 1: REGISTRASI & SETUP
**Tujuan**: Persiapan awal PKL dengan input data lengkap

#### 1.1 Pendaftaran Siswa
- Input data siswa (NIS, nama, kelas, jurusan)
- Data kontak (no HP, email, alamat)
- Data orang tua
- Kelengkapan dokumen (SK surat tugas, surat rekomendasi)
- Verifikasi dokumen oleh admin

#### 1.2 Daftar Industri
- Kelola daftar perusahaan/industri
- Detail industri (nama, alamat, bidang, kontak person)
- Integrasi koordinat GPS Industri (Latitude & Longitude) untuk pencocokan Geofencing
- Kapasitas kuota siswa per industri
- Status aktif/non-aktif
- Info pembimbing industri

#### 1.3 Penugasan Pembimbing
- Admin assign pembimbing per siswa
- Pembimbing bisa kelola list siswa
- Pemetaan Aspek Kompetensi Dinamis berdasarkan Jurusan siswa (RPL, TKJ, dll.)
- Set tgl mulai & selesai PKL
- Notifikasi ke pembimbing

#### 1.4 Validasi Data
- Cek kelengkapan data siswa
- Verifikasi dokumen upload
- Konfirmasi alokasi industri
- Status ready untuk mulai

---

### MODUL 2: DAILY MONITORING
**Tujuan**: Monitoring real-time aktivitas PKL harian

#### 2.1 Absensi Harian
- Check-in otomatis berbasis lokasi atau manual
- Smart Geofencing: Pencocokan otomatis koordinat GPS check-in siswa dengan koordinat lokasi industri (peringatan jika jarak > 100m)
- Sistem catat waktu check-in & check-out
- Status: Hadir, Alpa, Izin, Sakit
- Upload bukti foto check-in
- Alert otomatis jika terlambat

#### 2.2 Daily Journal/Laporan Harian
- Siswa input aktivitas apa yang dilakukan
- Offline-First Journaling (PWA): Menyimpan draf laporan secara lokal jika tidak ada sinyal internet, sinkronisasi otomatis saat online
- Jam mulai & jam selesai
- Deskripsi detail pekerjaan
- Skill yang dipraktikkan
- Kendala/hambatan (optional)
- Pembelajaran yang didapat

#### 2.3 Progress Tracker
- Timeline aktivitas per minggu
- Ringkasan pekerjaan yang sudah dilakukan
- Visualisasi progress (progress bar)
- Milestone achieved
- Catatan pembimbing

#### 2.4 Notifikasi Alert
- Email/SMS/WhatsApp jika siswa terlambat
- Notifikasi jika siswa alpa
- Reminder submit laporan harian
- AI-Assisted Red-Flag Alert: Deteksi kata kunci bermasalah pada jurnal siswa (seperti "sakit dipaksa kerja", "tidak dikasih tugas") untuk peringatan instan ke pembimbing
- Alert ke pembimbing jika ada masalah
- Dashboard notifications

#### 2.5 Upload Bukti
- Upload foto kegiatan
- Upload dokumen/sertifikat
- Upload file laporan
- File management & storage

---

### MODUL 3: PENILAIAN BERTAHAP
**Tujuan**: Penilaian komprehensif dengan berbagai aspek

#### 3.1 Nilai Sikap (Input Pembimbing)
Penilaian dengan skala 0-100 untuk aspek:
- **Kedisiplinan**: Ketepatan waktu, mematuhi aturan
- **Kerjasama**: Bekerja dalam tim, komunikasi
- **Tanggung Jawab**: Menyelesaikan tugas, dapat dipercaya
- **Inisiatif**: Ide baru, proaktif, pengembangan diri

Fitur:
- Form input nilai untuk setiap aspek
- Rubrik penilaian (descriptor)
- Catatan/komentar untuk setiap aspek
- Review dan finalisasi

#### 3.2 Nilai Kompetensi (Input Industri)
Penilaian dengan skala 0-100 untuk aspek kompetensi yang bersifat dinamis (mengikuti Jurusan siswa, diambil dari tabel kompetensi_jurusan).
Contoh Aspek Umum:
- **Kualitas Kerja**: Hasil kerja memenuhi standar industri
- **Kecepatan Kerja**: Efisiensi & produktivitas
- **Kedisiplinan Kerja**: Ketaatan pada SOP & K3
- **Komunikasi**: Interaksi dengan tim & atasan
- **Pengembangan Diri**: Belajar & improvement

Fitur:
- Form input dinamis dari pihak industri (sesuai jurusan siswa)
- Rubrik penilaian detail per kompetensi
- Catatan feedback dan rekomendasi rekrutmen (Talent Pool)
- Approve/finalisasi

#### 3.3 Nilai Kehadiran (Otomatis)
Perhitungan otomatis:
- Total hari hadir / total hari PKL × 100%
- Penalti untuk izin/sakit (optional)
- Perhitungan real-time

#### 3.4 Perhitungan Nilai Akhir (Otomatis)
Formula perhitungan:
```
Nilai Sikap = (Kedisiplinan + Kerjasama + Tanggung Jawab + Inisiatif) / 4 × 30%
Nilai Kompetensi = (Rata-rata Nilai Aspek Dinamis Jurusan) × 50%
Nilai Kehadiran = (Hari Hadir / Total Hari) × 100 × 20%

NILAI AKHIR PKL = Nilai Sikap + Nilai Kompetensi + Nilai Kehadiran

Grade:
- A: 85-100
- B: 75-84
- C: 65-74
- D: <65 (Remedial)
```

#### 3.5 Review & Finalisasi
- Koordinator review semua nilai
- Pembandaran nilai antar siswa
- Flag nilai yang tidak logis
- Finalisasi batch
- Locked (tidak bisa diubah)

---

### MODUL 4: LAPORAN & OUTPUT
**Tujuan**: Generate berbagai dokumen & laporan

#### 4.1 Transkrip Nilai
- PDF dengan detail penilaian lengkap
- Include: siswa, industri, pembimbing, nilai detail
- Grafik perbandingan nilai
- Rekomendasi (A/B/C/D)
- Ekspor Logbook Harian digital lengkap untuk arsip fisik
- Tanda tangan digital

#### 4.2 Sertifikat PKL
- Template otomatis tercetak rapi
- Include: nama siswa, industri, durasi, nilai
- Barcode/QR-Code unique untuk verifikasi keaslian sertifikat secara online
- Watermark/security
- Siap print/digital

#### 4.3 Lembar Evaluasi Industri
- Form evaluasi dari industri tertulis rapi
- Include: feedback, rekomendasi, ttd
- PDF format

#### 4.4 Laporan Koordinasi
- Excel dengan semua siswa & status
- Include: nilai, industri, pembimbing, status
- Sortable & filterable
- Untuk kepala sekolah & admin

#### 4.5 Analisis Performa
- Chart perbandingan nilai antar industri
- Statistik kehadiran
- Top performers
- Risk students (nilai rendah)
- Trend analysis

#### 4.6 Export & Import
- Export data ke Excel
- Import data dari Excel
- Backup database
- Import nilai dari template

---

## STRUKTUR DATABASE

### TABEL 1: PENGGUNA
```
Tabel: pengguna
├─ id_pengguna (INT, Primary Key, Auto Increment)
├─ nama_pengguna (VARCHAR 100, Unique)
├─ kata_sandi_hash (VARCHAR 255)
├─ email (VARCHAR 100, Unique)
├─ peran (ENUM: admin, pembimbing, siswa, industri, koordinator)
├─ status (ENUM: aktif, non_aktif, suspended)
├─ tgl_dibuat (TIMESTAMP)
├─ tgl_diubah (TIMESTAMP)
└─ catatan (TEXT)

Index: UNIQUE(nama_pengguna), UNIQUE(email), Index(peran)
```

---

### TABEL 2: SISWA
```
Tabel: siswa
├─ id_siswa (INT, Primary Key, Auto Increment)
├─ nisn (VARCHAR 20, Unique)
├─ nis (VARCHAR 10)
├─ nama_lengkap (VARCHAR 100)
├─ kelas (VARCHAR 5) -- contoh: XII-A
├─ jurusan (VARCHAR 50) -- contoh: RPL, TKJ, AK
├─ no_hp (VARCHAR 15)
├─ email (VARCHAR 100)
├─ alamat (TEXT)
├─ nama_orang_tua (VARCHAR 100)
├─ no_hp_orang_tua (VARCHAR 15)
├─ id_pengguna_fk (INT, Foreign Key ke pengguna)
├─ tgl_dibuat (TIMESTAMP)
└─ status (ENUM: aktif, selesai, dropout)

Index: UNIQUE(nisn), UNIQUE(nis), Index(kelas), Index(jurusan)
```

---

### TABEL 3: INDUSTRI
```
Tabel: industri
├─ id_industri (INT, Primary Key, Auto Increment)
├─ nama_industri (VARCHAR 150)
├─ jenis_industri (VARCHAR 50) -- contoh: Manufaktur, IT, Perdagangan
├─ alamat_lengkap (TEXT)
├─ kota (VARCHAR 50)
├─ propinsi (VARCHAR 50)
├─ no_telp (VARCHAR 15)
├─ email_industri (VARCHAR 100)
├─ nama_kontak_person (VARCHAR 100)
├─ jabatan_kontak (VARCHAR 50)
├─ no_hp_kontak (VARCHAR 15)
├─ kapasitas_siswa (INT) -- berapa siswa bisa ditampung
├─ latitude (DECIMAL 10, 8) -- koordinat GPS
├─ longitude (DECIMAL 11, 8) -- koordinat GPS
├─ status (ENUM: aktif, non_aktif, archived)
├─ tgl_didaftarkan (TIMESTAMP)
├─ tgl_diubah (TIMESTAMP)
└─ catatan (TEXT)

Index: Index(nama_industri), Index(jenis_industri), Index(kota)
```

---

### TABEL 4: PENUGASAN
```
Tabel: penugasan
├─ id_penugasan (INT, Primary Key, Auto Increment)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ id_industri_fk (INT, Foreign Key ke industri)
├─ id_pembimbing_fk (INT, Foreign Key ke pengguna/pembimbing)
├─ id_pengguna_industri_fk (INT, Foreign Key ke pengguna/industri)
├─ tgl_mulai_pkl (DATE)
├─ tgl_selesai_pkl (DATE)
├─ durasi_hari (INT) -- otomatis hitung
├─ lokasi_kerja (VARCHAR 100)
├─ divisi_departemen (VARCHAR 100)
├─ pembimbing_industri (VARCHAR 100)
├─ status (ENUM: aktif, selesai, batal, on_leave)
├─ tgl_penugasan (TIMESTAMP)
├─ tgl_selesai_penugasan (TIMESTAMP)
└─ catatan (TEXT)

Index: Index(id_siswa), Index(id_industri), Index(status)
Foreign Key: id_siswa_fk -> siswa.id_siswa
Foreign Key: id_industri_fk -> industri.id_industri
Foreign Key: id_pembimbing_fk -> pengguna.id_pengguna
```

---

### TABEL 5: KEHADIRAN
```
Tabel: kehadiran
├─ id_kehadiran (INT, Primary Key, Auto Increment)
├─ id_penugasan_fk (INT, Foreign Key ke penugasan)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ tgl_absen (DATE)
├─ status_kehadiran (ENUM: hadir, alpa, izin, sakit, cuti)
├─ waktu_checkin (TIME)
├─ waktu_checkout (TIME)
├─ jam_kerja_real (DECIMAL 5,2) -- dalam jam, otomatis hitung
├─ lokasi_checkin (VARCHAR 100) -- koordinat GPS
├─ bukti_foto_checkin (VARCHAR 255) -- path file
├─ bukti_foto_checkout (VARCHAR 255) -- path file
├─ keterangan_izin (TEXT) -- jika status izin/sakit
├─ id_pengguna_input (INT, Foreign Key ke pengguna)
├─ tgl_input (TIMESTAMP)
└─ catatan (TEXT)

Index: Index(id_siswa_fk), Index(tgl_absen), Index(status_kehadiran)
Foreign Key: id_penugasan_fk -> penugasan.id_penugasan
Foreign Key: id_siswa_fk -> siswa.id_siswa
```

---

### TABEL 6: LAPORAN_HARIAN
```
Tabel: laporan_harian
├─ id_laporan (INT, Primary Key, Auto Increment)
├─ id_penugasan_fk (INT, Foreign Key ke penugasan)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ tgl_laporan (DATE)
├─ jam_mulai_kerja (TIME)
├─ jam_selesai_kerja (TIME)
├─ jam_kerja_total (DECIMAL 5,2)
├─ aktivitas_pekerjaan (TEXT) -- deskripsi apa yang dikerjakan
├─ hasil_pekerjaan (TEXT) -- output/hasil
├─ skill_dipraktikkan (TEXT) -- skill apa saja, comma separated
├─ kendala_hambatan (TEXT) -- optional
├─ pembelajaran_didapat (TEXT) -- apa yang dipelajari
├─ file_lampiran (VARCHAR 255) -- path file jika ada
├─ status (ENUM: draft, submitted, approved, rejected)
├─ feedback_pembimbing (TEXT)
├─ id_pembimbing_review (INT, Foreign Key ke pengguna)
├─ tgl_review (TIMESTAMP)
├─ tgl_dibuat (TIMESTAMP)
└─ tgl_diubah (TIMESTAMP)

Index: Index(id_siswa_fk), Index(tgl_laporan), Index(status)
Foreign Key: id_penugasan_fk -> penugasan.id_penugasan
Foreign Key: id_siswa_fk -> siswa.id_siswa
Foreign Key: id_pembimbing_review -> pengguna.id_pengguna
```

---

### TABEL 7: PENILAIAN_SIKAP
```
Tabel: penilaian_sikap
├─ id_penilaian_sikap (INT, Primary Key, Auto Increment)
├─ id_penugasan_fk (INT, Foreign Key ke penugasan)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ id_pembimbing_fk (INT, Foreign Key ke pengguna/pembimbing)
├─ nilai_kedisiplinan (INT) -- 0-100
├─ nilai_kerjasama (INT) -- 0-100
├─ nilai_tanggung_jawab (INT) -- 0-100
├─ nilai_inisiatif (INT) -- 0-100
├─ nilai_rata_rata_sikap (DECIMAL 5,2) -- otomatis hitung
├─ catatan_kedisiplinan (TEXT)
├─ catatan_kerjasama (TEXT)
├─ catatan_tanggung_jawab (TEXT)
├─ catatan_inisiatif (TEXT)
├─ catatan_umum (TEXT)
├─ status (ENUM: draft, submitted, finalized)
├─ tgl_penilaian (DATE)
├─ tgl_input (TIMESTAMP)
└─ tgl_diubah (TIMESTAMP)

Index: Index(id_siswa_fk), Index(id_pembimbing_fk), Index(status)
Foreign Key: id_penugasan_fk -> penugasan.id_penugasan
Foreign Key: id_siswa_fk -> siswa.id_siswa
Foreign Key: id_pembimbing_fk -> pengguna.id_pengguna
```

---

### TABEL 8: PENILAIAN_KOMPETENSI
```
Tabel: penilaian_kompetensi
├─ id_penilaian_kompetensi (INT, Primary Key, Auto Increment)
├─ id_penugasan_fk (INT, Foreign Key ke penugasan)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ id_industri_penilai_fk (INT, Foreign Key ke pengguna/industri)
├─ nilai_rata_rata_kompetensi (DECIMAL 5,2) -- rata-rata nilai dari detail_penilaian_kompetensi
├─ catatan_umum (TEXT)
├─ rekomendasi_industri (TEXT) -- feedback rekrutmen / catatan khusus industri
├─ status (ENUM: draft, submitted, finalized)
├─ tgl_penilaian (DATE)
├─ tgl_input (TIMESTAMP)
└─ tgl_diubah (TIMESTAMP)

Index: Index(id_siswa_fk), Index(id_industri_penilai_fk), Index(status)
Foreign Key: id_penugasan_fk -> penugasan.id_penugasan
Foreign Key: id_siswa_fk -> siswa.id_siswa
Foreign Key: id_industri_penilai_fk -> pengguna.id_pengguna
```

---

### TABEL 9: NILAI_AKHIR
```
Tabel: nilai_akhir
├─ id_nilai_akhir (INT, Primary Key, Auto Increment)
├─ id_penugasan_fk (INT, Foreign Key ke penugasan)
├─ id_siswa_fk (INT, Foreign Key ke siswa)
├─ periode_pkl (VARCHAR 20) -- contoh: 2024/1
├─ total_hari_pkl (INT) -- durasi PKL
├─ total_hari_hadir (INT) -- hari hadir
├─ nilai_kehadiran (DECIMAL 5,2) -- (hadir/total) * 100 * 20%
├─ nilai_sikap_bobot (DECIMAL 5,2) -- nilai_sikap * 30%
├─ nilai_kompetensi_bobot (DECIMAL 5,2) -- nilai_kompetensi * 50%
├─ nilai_akhir_pkl (DECIMAL 5,2) -- total semua bobot
├─ grade (ENUM: A, B, C, D, E) -- berdasarkan range
├─ status_kelulusan (ENUM: lulus, remedial, tidak_lulus)
├─ catatan_kelulusan (TEXT)
├─ id_yang_finalisasi (INT, Foreign Key ke pengguna/koordinator)
├─ tgl_finalisasi (TIMESTAMP)
├─ tgl_cetak (TIMESTAMP)
├─ no_sertifikat (VARCHAR 50, Unique)
└─ catatan (TEXT)

Index: UNIQUE(no_sertifikat), Index(id_siswa_fk), Index(grade)
Foreign Key: id_penugasan_fk -> penugasan.id_penugasan
Foreign Key: id_siswa_fk -> siswa.id_siswa
Foreign Key: id_yang_finalisasi -> pengguna.id_pengguna
```

---

### TABEL 10: NOTIFIKASI
```
Tabel: notifikasi
├─ id_notifikasi (INT, Primary Key, Auto Increment)
├─ id_pengguna_tujuan_fk (INT, Foreign Key ke pengguna)
├─ judul_notifikasi (VARCHAR 150)
├─ pesan_notifikasi (TEXT)
├─ tipe_notifikasi (ENUM: info, warning, error, success)
├─ kategori (ENUM: absen, laporan, nilai, sistem, umum)
├─ id_referensi (INT) -- bisa referensi ke tabel lain
├─ tipe_referensi (VARCHAR 50) -- nama tabel referensi
├─ status_dibaca (BOOLEAN, default: false)
├─ tgl_dibaca (TIMESTAMP)
├─ tgl_notifikasi (TIMESTAMP)
└─ catatan (TEXT)

Index: Index(id_pengguna_tujuan_fk), Index(status_dibaca), Index(tgl_notifikasi)
Foreign Key: id_pengguna_tujuan_fk -> pengguna.id_pengguna
```

---

### TABEL 11: AKTIVITAS_LOG
```
Tabel: aktivitas_log
├─ id_log (INT, Primary Key, Auto Increment)
├─ id_pengguna_fk (INT, Foreign Key ke pengguna)
├─ tipe_aktivitas (VARCHAR 100) -- contoh: LOGIN, CREATE, UPDATE, DELETE
├─ deskripsi_aktivitas (TEXT)
├─ tabel_terdampak (VARCHAR 50)
├─ id_record_terdampak (INT)
├─ nilai_lama (JSON) -- untuk audit trail
├─ nilai_baru (JSON) -- untuk audit trail
├─ ip_address (VARCHAR 50)
├─ user_agent (VARCHAR 255)
├─ tgl_aktivitas (TIMESTAMP)
└─ status (ENUM: sukses, gagal)

Index: Index(id_pengguna_fk), Index(tipe_aktivitas), Index(tgl_aktivitas)
Foreign Key: id_pengguna_fk -> pengguna.id_pengguna
```

---

### TABEL 12: KONFIGURASI_SISTEM
```
Tabel: konfigurasi_sistem
├─ id_konfigurasi (INT, Primary Key, Auto Increment)
├─ nama_konfigurasi (VARCHAR 100, Unique)
├─ nilai_konfigurasi (TEXT)
├─ tipe_data (ENUM: string, integer, decimal, boolean, json)
├─ deskripsi (TEXT)
├─ tgl_dibuat (TIMESTAMP)
└─ tgl_diubah (TIMESTAMP)

Contoh data:
- bobot_nilai_sikap = 30
- bobot_nilai_kompetensi = 50
- bobot_nilai_kehadiran = 20
- min_nilai_lulus = 65
- threshold_warning_absen = 3
- durasi_session_menit = 30
```

---

### TABEL 13: KOMPETENSI_JURUSAN
```
Tabel: kompetensi_jurusan
├─ id_kompetensi (INT, Primary Key, Auto Increment)
├─ jurusan (VARCHAR 50) -- contoh: RPL, TKJ
├─ nama_aspek (VARCHAR 100) -- contoh: Pemrograman Web, Routing & Switching
├─ deskripsi_aspek (TEXT)
└─ tgl_dibuat (TIMESTAMP)

Index: Index(jurusan)
```

---

### TABEL 14: KUNJUNGAN_INDUSTRI
```
Tabel: kunjungan_industri
├─ id_kunjungan (INT, Primary Key, Auto Increment)
├─ id_pembimbing_fk (INT, Foreign Key ke pengguna)
├─ id_industri_fk (INT, Foreign Key ke industri)
├─ tgl_kunjungan (DATE)
├─ catatan_monitoring (TEXT)
├─ foto_kunjungan (VARCHAR 255)
└─ tgl_input (TIMESTAMP)

Index: Index(id_pembimbing_fk), Index(id_industri_fk), Index(tgl_kunjungan)
Foreign Key: id_pembimbing_fk -> pengguna.id_pengguna
Foreign Key: id_industri_fk -> industri.id_industri
```

---

### TABEL 15: DETAIL_PENILAIAN_KOMPETENSI
```
Tabel: detail_penilaian_kompetensi
├─ id_detail (INT, Primary Key, Auto Increment)
├─ id_penilaian_kompetensi_fk (INT, Foreign Key ke penilaian_kompetensi)
├─ id_kompetensi_fk (INT, Foreign Key ke kompetensi_jurusan)
├─ nilai (INT) -- 0-100
└─ catatan (TEXT)

Index: Index(id_penilaian_kompetensi_fk), Index(id_kompetensi_fk)
Foreign Key: id_penilaian_kompetensi_fk -> penilaian_kompetensi.id_penilaian_kompetensi
Foreign Key: id_kompetensi_fk -> kompetensi_jurusan.id_kompetensi
```

---

### RELASI TABEL (Entity Relationship Diagram)

```
pengguna
  ├─ (1) ──── (M) siswa (via id_pengguna_fk)
  ├─ (1) ──── (M) penugasan (via id_pembimbing_fk)
  ├─ (1) ──── (M) penugasan (via id_pengguna_industri_fk)
  ├─ (1) ──── (M) penilaian_sikap (via id_pembimbing_fk)
  ├─ (1) ──── (M) penilaian_kompetensi (via id_industri_penilai_fk)
  ├─ (1) ──── (M) kunjungan_industri (via id_pembimbing_fk)
  ├─ (1) ──── (M) notifikasi (via id_pengguna_tujuan_fk)
  └─ (1) ──── (M) aktivitas_log (via id_pengguna_fk)

siswa
  ├─ (M) ──── (1) pengguna (via id_pengguna_fk)
  ├─ (1) ──── (M) penugasan (via id_siswa_fk)
  ├─ (1) ──── (M) kehadiran (via id_siswa_fk)
  ├─ (1) ──── (M) laporan_harian (via id_siswa_fk)
  ├─ (1) ──── (M) penilaian_sikap (via id_siswa_fk)
  ├─ (1) ──── (M) penilaian_kompetensi (via id_siswa_fk)
  └─ (1) ──── (M) nilai_akhir (via id_siswa_fk)

industri
  ├─ (1) ──── (M) penugasan (via id_industri_fk)
  ├─ (1) ──── (M) kunjungan_industri (via id_industri_fk)
  └─ (1) ──── (M) kehadiran (via penugasan)

penugasan
  ├─ (M) ──── (1) siswa (via id_siswa_fk)
  ├─ (M) ──── (1) industri (via id_industri_fk)
  ├─ (M) ──── (1) pengguna/pembimbing (via id_pembimbing_fk)
  ├─ (1) ──── (M) kehadiran (via id_penugasan_fk)
  ├─ (1) ──── (M) laporan_harian (via id_penugasan_fk)
  ├─ (1) ──── (M) penilaian_sikap (via id_penugasan_fk)
  ├─ (1) ──── (M) penilaian_kompetensi (via id_penugasan_fk)
  └─ (1) ──── (M) nilai_akhir (via id_penugasan_fk)

penilaian_kompetensi
  └─ (1) ──── (M) detail_penilaian_kompetensi (via id_penilaian_kompetensi_fk)

kompetensi_jurusan
  └─ (1) ──── (M) detail_penilaian_kompetensi (via id_kompetensi_fk)
```

---

## ALUR PROSES LENGKAP

### FASE 1: SETUP & PERSIAPAN (Minggu ke-1 sebelum PKL)

**1.1 Persiapan Awal**
- [ ] Rapat tim: Admin, Koordinator PKL, Pembimbing
- [ ] Tentukan periode PKL (tanggal mulai-selesai)
- [ ] Tentukan durasi standar PKL (misal 4 minggu)
- [ ] Update daftar industri partner
- [ ] Verifikasi kapasitas setiap industri

**1.2 Input Data Siswa**
- [ ] Admin input/import data siswa dari sistem akademik
- [ ] Kelengkapan: NISN, NIS, nama, kelas, jurusan, kontak
- [ ] Verifikasi data akurat
- [ ] Upload SK surat tugas & dokumen syarat
- [ ] Buat akun login untuk setiap siswa (username=NISN)
- [ ] Siswa reset password login pertama

**1.3 Setup Industri**
- [ ] Admin input daftar industri partner
- [ ] Data: nama, alamat, kontak person, kapasitas, bidang
- [ ] Buat akun untuk setiap industri
- [ ] Industri setup password & profile mereka
- [ ] Industri input nama pembimbing di lapangan

**1.4 Assign Pembimbing Sekolah**
- [ ] Koordinator tentukan pembimbing untuk setiap siswa
- [ ] Pembimbing bisa max 5 siswa
- [ ] Input di sistem: penugasan pembimbing-siswa
- [ ] Notifikasi ke pembimbing

**1.5 Alokasi Siswa ke Industri**
- [ ] Koordinator alokasikan siswa ke industri
- [ ] Pastikan sesuai keahlian & preferensi
- [ ] Catat di sistem: id_siswa, id_industri, tgl_mulai, tgl_selesai
- [ ] Cetak surat penempatan
- [ ] Distribusikan ke siswa & industri

**1.6 Validasi Awal**
- [ ] Cek semua data complete
- [ ] Cek semua siswa dapat akun
- [ ] Cek semua pembimbing & industri ready
- [ ] Test sistem akses dari berbagai role
- [ ] Status: "READY FOR LAUNCH"

---

### FASE 2: MONITORING & TRACKING (Minggu ke-1 s/d Minggu terakhir PKL)

**2.1 Hari Pertama PKL**
- [ ] Siswa login pertama kali
- [ ] Update profil PKL mereka
- [ ] Lihat info pembimbing & industri
- [ ] Pembimbing & industri approve kehadiran siswa
- [ ] Submit daily log pertama

**2.2 Harian: Absensi & Laporan**
- [ ] **Siswa**: Check-in jam mulai kerja (07:00-09:00)
  - Upload foto di lokasi industri
  - Sistem record waktu & lokasi GPS
  
- [ ] **Siswa**: Submit daily log sebelum jam 21:00
  - Aktivitas apa yang dilakukan
  - Hasil pekerjaan
  - Skill dipraktikkan
  - Kendala jika ada
  
- [ ] **Pembimbing**: Monitor dashboard
  - Lihat kehadiran siswa real-time
  - Lihat laporan harian
  - Beri feedback/komentar

- [ ] **Industri**: Monitor kehadiran
  - Verifikasi kehadiran siswa
  - Observasi langsung di lapangan
  
- [ ] **Sistem Notifikasi**:
  - Notif ke pembimbing jika siswa terlambat (>30 menit)
  - Notif ke sistem admin jika siswa alpa
  - Reminder ke siswa submit laporan jam 19:00

**2.3 Mingguan: Review & Feedback**
- [ ] **Pembimbing**: Review semua laporan siswa minggu ini
  - Beri feedback konstruktif
  - Highlight progress positif
  
- [ ] **Industri**: Observasi keseluruhan minggu
  - Catat progress kompetensi
  - Komunikasi dengan pembimbing jika ada masalah
  
- [ ] **Koordinator**: Monitor stats bulanan
  - Total kehadiran siswa
  - Alert jika ada siswa dengan absen tinggi
  - Koordinasi dengan industri

**2.4 Alert & Escalation**
- [ ] **Jika siswa 3x alpa**:
  - Notif ke pembimbing & koordinator
  - Email peringatan ke orang tua
  - Meeting dengan siswa
  
- [ ] **Jika ada masalah di lapangan**:
  - Industri report ke koordinator
  - Koordinator mediasi dengan siswa/pembimbing
  
- [ ] **Jika siswa tidak submit laporan**:
  - Reminder otomatis
  - Escalation ke pembimbing

---

### FASE 3: PENILAIAN (Minggu terakhir PKL)

**3.1 Sosialisasi Penilaian**
- [ ] Admin share rubrik & kriteria penilaian ke semua
- [ ] Training pembimbing & industri tentang penilaian
- [ ] Siswa tahu akan dinilai aspek apa

**3.2 Input Nilai Sikap (Pembimbing)**
- [ ] Pembimbing login sistem
- [ ] Buka form "Input Nilai Sikap"
- [ ] Untuk setiap siswa, input 4 aspek (0-100):
  - Kedisiplinan: (lihat dari kehadiran, tepat waktu)
  - Kerjasama: (lihat dari laporan, feedback industri)
  - Tanggung Jawab: (lihat dari komitmen, kualitas)
  - Inisiatif: (lihat dari ide baru, improvement)
- [ ] Input catatan detail untuk setiap aspek
- [ ] Review & finalisasi
- [ ] Status: Submitted

**3.3 Input Nilai Kompetensi (Industri)**
- [ ] Industri login sistem
- [ ] Buka form "Input Nilai Kompetensi"
- [ ] Untuk setiap siswa, input 5 aspek (0-100):
  - Kualitas Kerja: (output kerja vs standar)
  - Kecepatan Kerja: (efisiensi & produktivitas)
  - Kedisiplinan Kerja: (ketaatan SOP & aturan)
  - Komunikasi: (interaksi dengan tim)
  - Pengembangan Diri: (belajar & improvement)
- [ ] Input catatan & rekomendasi
- [ ] Review & finalisasi
- [ ] Status: Submitted

**3.4 Sistem Hitung Otomatis**
```
Sistem akan otomatis hitung:
- Nilai Kehadiran = (total_hadir / total_hari) × 100 × 20%
- Rata-rata Sikap = (kedisiplinan + kerjasama + tanggung_jawab + inisiatif) / 4 × 30%
- Rata-rata Kompetensi = (kualitas + kecepatan + kedisiplinan + komunikasi + pengembangan) / 5 × 50%
- NILAI AKHIR = Nilai Kehadiran + Nilai Sikap + Nilai Kompetensi

Status: Auto-calculated, Ready for Review
```

**3.5 Review & Validasi (Koordinator)**
- [ ] Koordinator review semua nilai yang sudah diinput
- [ ] Cek logika nilai (misal: sikap A tapi kompetensi E = flag)
- [ ] Bandingkan distribusi nilai antar siswa
- [ ] Flag nilai yang tidak masuk akal
- [ ] Kembalikan ke pembimbing/industri jika perlu revisi
- [ ] Lakukan meeting validasi jika perlu
- [ ] Approval akhir: Status "FINALIZED"

**3.6 Lock & Backup**
- [ ] Koordinator set status "LOCKED"
- [ ] Nilai tidak bisa diubah lagi
- [ ] Backup database sebelum cetak
- [ ] Approval dari kepala sekolah (opsional)

---

### FASE 4: OUTPUT & CETAK NILAI (Akhir)

**4.1 Generate Sertifikat**
- [ ] Admin/Koordinator klik "Generate Sertifikat"
- [ ] Sistem otomatis generate untuk semua siswa:
  - Nomor sertifikat unik (format: PKL-2024-001, dll)
  - Nama siswa
  - Industri tempat PKL
  - Durasi PKL
  - Nilai akhir
  - Grade (A/B/C/D)
  - Watermark & barcode
- [ ] Output PDF template rapi siap print
- [ ] Tanda tangan digital (jika ada)

**4.2 Generate Transkrip Nilai**
- [ ] Admin/Koordinator klik "Generate Transkrip"
- [ ] Sistem generate PDF untuk setiap siswa:
  - Header: SMK Advance, tahun akademik
  - Identitas siswa
  - Detail industri
  - Riwayat kehadiran (rekapan)
  - Nilai sikap (4 aspek + rata-rata)
  - Nilai kompetensi (5 aspek + rata-rata)
  - Nilai kehadiran
  - Nilai akhir PKL
  - Predikat/grade
  - Catatan/rekomendasi
  - Tanda tangan pembimbing, industri, kepala sekolah
- [ ] Output PDF siap cetak atau email
- [ ] Arsip digital tersimpan di database

**4.3 Laporan Koordinasi (Excel)**
- [ ] Admin generate laporan Excel master:
  - List semua siswa dengan kolom:
    - NISN, Nama, Kelas, Jurusan
    - Industri, Pembimbing
    - Total Kehadiran
    - Nilai Sikap, Nilai Kompetensi, Nilai Kehadiran
    - Nilai Akhir, Grade, Status Kelulusan
  - Sortable & filterable
  - Summary stats (rata-rata, min, max, distribusi grade)
- [ ] Gunakan untuk laporan ke kepala sekolah & dinas

**4.4 Cetak Hardcopy**
- [ ] Admin print sertifikat untuk semua siswa
  - A5 atau A4 size
  - Kertas berkualitas (elephant/ivory)
  - Tanda tangan manual bila perlu
  
- [ ] Admin print transkrip nilai
  - A4 size
  - Boleh 1 rangkap atau sesuai kebutuhan
  
- [ ] Sosialisasi ke siswa, orang tua, industri

**4.5 Distribusi & Arsip**
- [ ] Email sertifikat & transkrip ke siswa
- [ ] Email laporan industri ke DU-DI
- [ ] Arsip hardcopy di sekolah (map per siswa)
- [ ] Arsip digital di database/cloud
- [ ] Update data siswa: status PKL = "SELESAI"
- [ ] Record di sistem: tgl_cetak, no_sertifikat

**4.6 Post-PKL Activities**
- [ ] Gathering apresiasi siswa & industri
- [ ] Feedback form untuk evaluasi program
- [ ] Analisis trends & improvement untuk tahun depan
- [ ] Closure meeting dengan koordinator & pembimbing

---

## TEKNOLOGI STACK

### REKOMENDASI TEKNOLOGI

| Komponen | Pilihan | Alasan |
|----------|---------|--------|
| **Backend Framework** | Laravel 11 (PHP 8.2+) | Fitur perutean bersih, andal, handal dalam penanganan database, minimal konfigurasi, dan berkinerja tinggi. |
| **Frontend/Reactivity** | Laravel Blade Templates + Vanilla JS | Arsitektur MPA (Multi-Page Application) bawaan Laravel. Sederhana, mudah dipelajari, dan andal tanpa kompleksitas SPA. |
| **Styling (CSS)** | Bootstrap 5 | Kerangka CSS responsif yang populer, cepat dalam penulisan layout, dan didukung banyak tema admin siap pakai. |
| **Database** | MySQL / PostgreSQL | Relasional, andal, didukung penuh oleh Laravel Eloquent ORM. |
| **File Storage** | AWS S3 / Local Storage | Cloud-based atau server local, andal untuk menyimpan foto check-in dan dokumen lampiran. |
| **PDF Generator** | Spatie Laravel PDF / Barryvdh DomPDF | Pembuatan sertifikat dan transkrip langsung dari template Blade HTML/CSS. |
| **WhatsApp Gateway** | Fonnte / Wablas API | Pengiriman notifikasi absensi harian dan pengiriman Magic Link login secara otomatis. |
| **Hosting** | VPS (DigitalOcean / Linode / Niagahoster) | Kontrol penuh atas server web, deployment aman menggunakan Laravel Forge / manual. |
| **Version Control** | Git + GitHub | Kerja sama tim pengembangan, pencatatan sejarah revisi, dan cadangan kode. |

---

## MOCKUP INTERFACE

### DASHBOARD PEMBIMBING SEKOLAH

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ DASHBOARD PEMBIMBING SEKOLAH - Ibu Siti        ┃
┃ Logout | Settings                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

📊 RINGKASAN SISWA BIMBING
┌─────────────────────────────────────────────┐
│ Total Siswa: 15  │ Hadir: 14  │ Alpa: 1     │
│ Kehadiran Rata-rata: 94%                    │
│ Rata-rata Nilai Sementara: 82 (B)           │
└─────────────────────────────────────────────┘

⚠️ NOTIFIKASI PENTING
┌─────────────────────────────────────────────┐
│ • Andi S - Tidak submit laporan hari ini    │
│ • Budi P - Absen hari ini (total: 3x)       │
│ • Citra D - Belum submit laporan 2 hari     │
│ [Lihat Semua Notifikasi]                    │
└─────────────────────────────────────────────┘

📋 DAFTAR SISWA BIMBING
┌────────────────────────────────────────────────────────────┐
│ No | Nama        | Industri      | Hadir | Last Input      │
├────────────────────────────────────────────────────────────┤
│ 1  │ Andi S      │ PT ABC Elektr │ 14/20 │ 2024-01-15 18:30│
│ 2  │ Budi P      │ PT XYZ Indus  │ 12/20 │ 2024-01-14 17:00│
│ 3  │ Citra D     │ PT 123 Mfg    │ 19/20 │ 2024-01-16 19:15│
│ 4  │ ... (daftar lanjut)                                  │
└────────────────────────────────────────────────────────────┘
[Search] [Filter by Status] [Export Excel]

🎯 AKSI CEPAT
┌──────────────────────────────────────────┐
│ [+ Input Nilai Sikap]                    │
│ [👁 Lihat Laporan Detail]                │
│ [⬇ Download Sertifikat]                  │
│ [📧 Send Notifikasi]                     │
└──────────────────────────────────────────┘
```

---

### DASHBOARD SISWA

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ PKL @ PT ABC Electronics - Andi S        ┃
┃ Logout | Profile                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

⏱️ SISA WAKTU PKL
┌──────────────────────────────┐
│ Mulai: 15 Januari 2024       │
│ Selesai: 11 Februari 2024    │
│ ► SISA: 12 hari lagi         │
│ Progress: [███████░░░░] 60%  │
└──────────────────────────────┘

📅 KEHADIRAN MINGGU INI
┌────────────────────────┐
│ Sen ✓  Sel ✓  Rab ✓   │
│ Kam ✓  Jum ✓  Sab ✗   │
│ Min ○                  │
│ Hadir: 5/7 (71%)       │
└────────────────────────┘

📝 SUBMIT LAPORAN HARIAN
┌──────────────────────────────────┐
│ Tanggal: 16 Januari 2024         │
│                                  │
│ Jam Mulai: [09:00]               │
│ Jam Selesai: [17:00]             │
│ Jam Kerja Total: 8 jam           │
│                                  │
│ Aktivitas Hari Ini:              │
│ [_______________________]        │
│ [_______________________]        │
│                                  │
│ Skill yang Dipraktikkan:         │
│ [_______________________]        │
│                                  │
│ Kendala/Hambatan:                │
│ [_______________________]        │
│                                  │
│ Upload Bukti Foto:               │
│ [Browse File...] [📷 Take Photo] │
│                                  │
│          [💾 Simpan] [📤 Submit] │
└──────────────────────────────────┘

📊 NILAI SEMENTARA
┌─────────────────────────────────┐
│ Nilai Sikap: Belum dinilai      │
│ Nilai Kompetensi: Belum dinilai │
│ Nilai Kehadiran: 90/100         │
│ NILAI AKHIR: Belum tersedia     │
└─────────────────────────────────┘

💬 FEEDBACK & KOMENTAR
┌────────────────────────────────┐
│ Pembimbing (15 Jan):           │
│ "Bagus, terus tingkatkan       │
│  komunikasi dengan tim"        │
│                                │
│ Industri (14 Jan):             │
│ "Performa memuaskan minggu ini" │
└────────────────────────────────┘

🔔 NOTIFIKASI
• Reminder: Submit laporan hari ini sebelum jam 21:00
• Pembimbing sudah review laporan kemarin
• Sertifikat PKL akan tersedia minggu depan
```

---

### FORM INPUT NILAI SIKAP (PEMBIMBING)

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ INPUT NILAI SIKAP - Andi S         ┃
┃ Industri: PT ABC Electronics       ┃
┃ Periode: 15 Jan - 11 Feb 2024      ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

📋 RUBRIK PENILAIAN SIKAP
Skala: 0-100 (0=Sangat Kurang, 100=Sempurna)

1️⃣  KEDISIPLINAN
   Indikator: Ketepatan waktu, mematuhi aturan, komitmen
   
   Nilai: [Slider: 85_______]  85/100
   
   Catatan:
   [Andi sangat disiplin, selalu tepat waktu,_____]
   [mematuhi SOP dengan baik_____________________]
   
   ✓ Slider yang menunjuk nilai: Pukul 08:45 hadir (sempurna)
     Tidak pernah izin/sakit, patuh pada aturan sekolah

2️⃣  KERJASAMA
   Indikator: Bekerja dalam tim, komunikasi, saling bantu
   
   Nilai: [Slider: 80_______]  80/100
   
   Catatan:
   [Mampu bekerja dalam tim dengan baik, kadang perlu_____]
   [dimotivasi untuk lebih proaktif komunikasi_____]

3️⃣  TANGGUNG JAWAB
   Indikator: Menyelesaikan tugas, dapat dipercaya, konsistensi
   
   Nilai: [Slider: 88_______]  88/100
   
   Catatan:
   [Sangat bertanggung jawab, tugas selalu selesai_____]
   [dengan kualitas baik, dapat dipercaya_____]

4️⃣  INISIATIF
   Indikator: Ide baru, proaktif, pengembangan diri, problem solving
   
   Nilai: [Slider: 82_______]  82/100
   
   Catatan:
   [Cukup proaktif, punya inisiatif dalam beberapa_____]
   [hal, perlu lebih dikembangkan_____]

📊 HASIL PERHITUNGAN
   Rata-rata Nilai Sikap = (85 + 80 + 88 + 82) / 4 = 83.75
   Bobot 30% = 83.75 × 0.30 = 25.125

⚠️ VALIDASI
   ✓ Semua nilai sudah diisi
   ✓ Catatan cukup detail
   ✓ Nilai masuk akal
   
   [🔄 Reset Form] [✅ Submit Nilai] [📋 Preview]
```

---

### FORM INPUT NILAI KOMPETENSI (INDUSTRI)

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ INPUT NILAI KOMPETENSI - Andi S    ┃
┃ Dari: PT ABC Electronics           ┃
┃ Periode: 15 Jan - 11 Feb 2024      ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

📋 RUBRIK PENILAIAN KOMPETENSI
Skala: 0-100

1️⃣  KUALITAS KERJA (Hasil kerja vs standar industri)
   Nilai: [Slider: 90_______]  90/100
   Catatan: [Hasil kerja rapi dan sesuai standar____]

2️⃣  KECEPATAN KERJA (Efisiensi & produktivitas)
   Nilai: [Slider: 85_______]  85/100
   Catatan: [Cukup cepat menyelesaikan tugas____]

3️⃣  KEDISIPLINAN KERJA (Ketaatan SOP & aturan industri)
   Nilai: [Slider: 87_______]  87/100
   Catatan: [Patuh pada SOP, jarang terlambat____]

4️⃣  KOMUNIKASI (Interaksi dengan team, customer)
   Nilai: [Slider: 82_______]  82/100
   Catatan: [Komunikasi baik, perlu lebih percaya diri]

5️⃣  PENGEMBANGAN DIRI (Belajar, improvement, adaptasi)
   Nilai: [Slider: 88_______]  88/100
   Catatan: [Cepat belajar, mudah adaptasi dengan______]
            [lingkungan kerja yang baru______]

📊 HASIL PERHITUNGAN
   Rata-rata = (90 + 85 + 87 + 82 + 88) / 5 = 86.4
   Bobot 50% = 86.4 × 0.50 = 43.2

FEEDBACK UMUM INDUSTRI:
┌────────────────────────────────────┐
│ Andi menunjukkan potensi yang baik  │
│ dalam pekerjaan. Disarankan untuk   │
│ meningkatkan percaya diri dalam     │
│ berkomunikasi dengan atasan.        │
│                                    │
│ Kami tertarik untuk mempekerjakan   │
│ Andi sebagai karyawan.              │
└────────────────────────────────────┘

SURAT REKOMENDASI:
☐ Upload file rekomendasi PDF

[🔄 Reset] [✅ Submit Nilai] [📋 Preview] [🔐 Lock]
```

---

### NILAI AKHIR & SERTIFIKAT (OUTPUT)

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ TRANSKRIP NILAI PKL - ANDI S      ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

SMK ADVANCE SURABAYA
Jalan Diponegoro No. 45, Surabaya

═══════════════════════════════════════════════════════
TRANSKRIP NILAI PRAKTIK KERJA LAPANGAN (PKL)
═══════════════════════════════════════════════════════

Nama Siswa         : ANDI SUGIHARTO
NISN               : 1234567890
NIS                : 2024001
Kelas / Jurusan    : XII / RPL (Rekayasa Perangkat Lunak)

TEMPAT PKL         : PT ABC ELECTRONICS
Alamat             : Jl. Industri No. 10, Surabaya
Pembimbing Industri: Bapak Rudi Hartono
Periode PKL        : 15 Januari - 11 Februari 2024
Durasi             : 20 hari kerja
Pembimbing Sekolah : Ibu Siti Nurhaliza, S.Pd.

───────────────────────────────────────────────────────
REKAPITULASI KEHADIRAN
───────────────────────────────────────────────────────
Total Hari PKL           : 20 hari
Total Hari Hadir         : 19 hari
Total Hari Alpa          : 0 hari
Total Hari Izin/Sakit    : 1 hari
Persentase Kehadiran     : 95%
Nilai Kehadiran (20%)    : 95 × 20% = 19.00

───────────────────────────────────────────────────────
PENILAIAN SIKAP (Bobot: 30%)
───────────────────────────────────────────────────────
Aspek Penilaian           Nilai    Bobot
─────────────────────────────────────
Kedisiplinan               85      25%
Kerjasama                  80      25%
Tanggung Jawab             88      25%
Inisiatif                  82      25%
─────────────────────────────────────
NILAI SIKAP RATA-RATA     83.75    × 30% = 25.125

───────────────────────────────────────────────────────
PENILAIAN KOMPETENSI (Bobot: 50%)
───────────────────────────────────────────────────────
Aspek Penilaian           Nilai    Bobot
─────────────────────────────────────
Kualitas Kerja             90      20%
Kecepatan Kerja            85      20%
Kedisiplinan Kerja         87      20%
Komunikasi                 82      20%
Pengembangan Diri          88      20%
─────────────────────────────────────
NILAI KOMPETENSI RATA-RATA 86.40   × 50% = 43.20

───────────────────────────────────────────────────────
NILAI AKHIR PRAKTIK KERJA LAPANGAN
───────────────────────────────────────────────────────

Nilai Kehadiran          :  19.00 (Bobot 20%)
Nilai Sikap              :  25.125 (Bobot 30%)
Nilai Kompetensi         :  43.20 (Bobot 50%)
────────────────────────────────────────────
NILAI AKHIR PKL          :  87.33

PREDIKAT               :  A (AMAT BAIK)
STATUS KELULUSAN       :  LULUS

───────────────────────────────────────────────────────
CATATAN:
Andi menunjukkan performa yang sangat baik selama
mengikuti PKL. Disiplin, bertanggung jawab, dan cepat
belajar. Direkomendasikan untuk melanjutkan ke
pekerjaan atau pendidikan lebih lanjut.

───────────────────────────────────────────────────────

Surabaya, 11 Februari 2024

Pembimbing Sekolah        Pembimbing Industri     Koordinator PKL
_________________         _________________       _________________
Ibu Siti Nurhaliza        Bapak Rudi Hartono     Bapak Bambang Riyanto
NUPTK: 1234567890         NIP: -                 NUPTK: 9876543210

═══════════════════════════════════════════════════════
```

---

### SERTIFIKAT PKL (OUTPUT PRINT)

```
╔═══════════════════════════════════════════════════════════╗
║                                                           ║
║                    SMK ADVANCE SURABAYA                   ║
║                    Sertifikat PKL 2024                    ║
║                                                           ║
║                         [LOGO]                           ║
║                                                           ║
║  Nomor Sertifikat: PKL-2024-001                           ║
║                                                           ║
║  Dengan ini kami sertifikasi bahwa:                       ║
║                                                           ║
║                  ANDI SUGIHARTO                           ║
║                   NISN: 1234567890                        ║
║                  Kelas XII RPL                            ║
║                                                           ║
║  Telah menyelesaikan Program Praktik Kerja Lapangan di:   ║
║                                                           ║
║               PT ABC ELECTRONICS                          ║
║            Jl. Industri No. 10, Surabaya                  ║
║                                                           ║
║  Dalam Periode:                                           ║
║     15 Januari 2024 - 11 Februari 2024                    ║
║     Durasi: 20 Hari Kerja                                 ║
║                                                           ║
║  Dengan Nilai Akhir:                                      ║
║            87.33 (PREDIKAT A)                             ║
║                                                           ║
║  Sertifikat ini diberikan sebagai bukti bahwa siswa       ║
║  tersebut telah memenuhi standar kompetensi PKL sesuai    ║
║  dengan kurikulum pendidikan SMK.                         ║
║                                                           ║
║  Surabaya, 11 Februari 2024                               ║
║                                                           ║
║  Kepala Sekolah              Koordinator PKL              ║
║  ________________            ________________             ║
║  Drs. Sutrisno, M.Si         Bapak Bambang Riyanto       ║
║  NIP: 1965010120             NUPTK: 9876543210           ║
║                                                           ║
║                    Kode QR: [██████]                      ║
║               PKL-2024-001 (Verified)                     ║
║                                                           ║
╚═══════════════════════════════════════════════════════════╝
```

---

## KEAMANAN & VALIDASI

### AUTHENTIKASI & AUTORISASI

**Login System**
- Username: NISN (untuk siswa) atau username custom (untuk admin/pembimbing)
- Password: Hashed dengan bcrypt (minimum 8 karakter, kombinasi huruf & angka)
- Two-Factor Authentication (2FA) optional untuk admin
- Session timeout: 30 menit inactivity
- Login attempt limit: 5 kali, lock 15 menit setelah itu

**Role-Based Access Control (RBAC)**
- Setiap user punya role spesifik
- Setiap halaman & API endpoint check role user
- Log semua akses & perubahan data (audit trail)

**Password Policy**
- Minimum 8 karakter
- Kombinasi uppercase, lowercase, number
- tidak boleh sama dengan username
- Harus ganti password setiap 90 hari (untuk admin)

---

### VALIDASI DATA

**Input Validation (Frontend)**
- Email format check
- Nomor telepon format check (10-15 digit)
- Tanggal range validation
- Nilai 0-100 untuk penilaian
- File size limit untuk upload (max 5MB)
- File type check (JPG, PNG, PDF only)

**Input Validation (Backend)**
- Semua input divalidasi ulang di server
- SQL injection prevention dengan prepared statement
- XSS prevention dengan input sanitization
- CSRF protection dengan token

**Business Logic Validation**
- Tanggal PKL tidak bisa mundur
- Durasi PKL minimal 1 hari
- Nilai kompetensi hanya bisa input 1x (locked after)
- Laporan harian hanya bisa input 1x per hari

---

### PROTEKSI DATA

**Enkripsi**
- Password: bcrypt (salt + hash)
- Sensitive data: AES-256 encryption di database
- HTTPS/SSL untuk semua komunikasi
- Database backup: encrypted

**Backup & Recovery**
- Daily automated database backup
- Store backup di cloud (AWS S3 / Google Cloud)
- Weekly test restore dari backup
- Disaster recovery plan tersedia

**Data Access Control**
- Siswa hanya bisa lihat data mereka sendiri
- Pembimbing hanya bisa lihat siswa mereka
- Industri hanya bisa lihat siswa di industri mereka
- Admin & koordinator punya akses penuh dengan audit log

---

### FILE & UPLOAD MANAGEMENT

**Upload Validation**
- File size limit: 5MB per file
- Allowed types: JPG, PNG, PDF
- Scan virus dengan antivirus scanner (ClamAV)
- Rename file: unique ID + timestamp (prevent filename injection)
- Store di cloud storage, not in app folder

**Photo/Dokumen Management**
- Foto check-in: 1 file per absensi
- Dokumentasi kegiatan: unlimited per hari
- Sertifikat/rekomendasi: 1-2 file
- Auto-delete incomplete upload setelah 24 jam
- Backup digital semua dokumen

---

### API SECURITY

**Rate Limiting**
- Max 100 requests per minute per user
- Max 1000 requests per minute per IP
- Block IP kalau exceed limit

**API Authentication**
- JWT token (expire: 24 jam)
- Refresh token (expire: 30 hari)
- API key untuk external integration
- Signature verification untuk webhook

**CORS Policy**
- Whitelist domain yang diizinkan
- Preflight request handling
- Credentials cookie setting

---

### MONITORING & LOGGING

**Activity Log**
- Log semua login/logout
- Log semua create/update/delete data
- Log semua nilai input (siapa, kapan, nilai lama vs baru)
- Log semua report/export yang di-download
- Retention: 2 tahun

**Error Tracking**
- Capture semua server errors
- Log to Sentry / DataDog
- Alert otomatis jika error rate tinggi
- Debug mode disable di production

**Audit Trail**
- Trace semua perubahan ke nilai
- Siapa yang input, kapan, nilai apa
- Prevent tampering dengan lock mechanism
- Timestamped & signed entries

---

## TIMELINE IMPLEMENTASI

### FASE 1: PLANNING & DESIGN (2-3 minggu)

**Minggu 1-2: Requirements & Architecture**
- [ ] Finalisasi requirement dengan stakeholder
- [ ] Design database schema (ERD)
- [ ] Design system architecture (frontend, backend, database)
- [ ] Design UI/UX mockup (figma)
- [ ] Tech stack finalisasi
- Deliverable: Requirements Document, Architecture Diagram, Mockup Design

**Minggu 3: Setup & Environment**
- [ ] Setup git repository
- [ ] Setup development environment
- [ ] Database design final review
- [ ] API endpoint planning (Swagger/OpenAPI)
- Deliverable: API Documentation, Database Schema SQL

---

### FASE 2: DEVELOPMENT (4-6 minggu)

**Minggu 1-2: Backend Development**
- [ ] Setup database (PostgreSQL)
- [ ] Create database schema & tables
- [ ] Create User management API
- [ ] Create Student management API
- [ ] Create Industry management API
- [ ] Authentication & JWT implementation
- Deliverable: API endpoints testing via Postman

**Minggu 2-3: Frontend Development (Modul 1 & 2)**
- [ ] Setup React project & Tailwind
- [ ] Create login page & dashboard
- [ ] Create student registration page
- [ ] Create attendance system
- [ ] Create daily log submission form
- [ ] Create student dashboard
- Deliverable: Frontend pages dengan mock data

**Minggu 4: Integration & Testing (Modul 1 & 2)**
- [ ] Frontend-Backend integration
- [ ] Unit testing backend
- [ ] Integration testing API
- [ ] Manual testing semua fitur
- [ ] Bug fixing & optimization
- Deliverable: Working features for modules 1 & 2

**Minggu 5-6: Penilaian & Laporan (Modul 3 & 4)**
- [ ] Create penilaian sikap form (backend + frontend)
- [ ] Create penilaian kompetensi form (backend + frontend)
- [ ] Auto calculation nilai akhir
- [ ] Generate sertifikat PDF
- [ ] Generate transkrip nilai
- [ ] Create laporan excel export
- [ ] Create dashboard for koordinator
- Deliverable: Complete features for modules 3 & 4

---

### FASE 3: TESTING & QA (2 minggu)

**Minggu 1: Functional & System Testing**
- [ ] Complete functional testing semua modul
- [ ] System testing dengan data besar
- [ ] Load testing (1000 concurrent users)
- [ ] Security testing (penetration test)
- [ ] Database backup & recovery testing
- Deliverable: Test report & bug list

**Minggu 2: UAT (User Acceptance Testing)**
- [ ] Training untuk end-users (admin, pembimbing, siswa, industri)
- [ ] UAT dengan real users
- [ ] Feedback collection & fixing
- [ ] Performance optimization
- [ ] Documentation finalization
- Deliverable: UAT sign-off, Final fixes

---

### FASE 4: DEPLOYMENT & LAUNCH (1 minggu)

**Hari 1-2: Infrastructure Setup**
- [ ] Setup VPS/Cloud hosting (DigitalOcean/AWS)
- [ ] Setup database production
- [ ] SSL certificate setup
- [ ] Domain configuration
- [ ] Email service setup (SMTP)
- Deliverable: Production environment ready

**Hari 3: Data Migration & Testing**
- [ ] Migrate data from legacy system (jika ada)
- [ ] Production testing semua features
- [ ] Final security check
- [ ] Backup production database
- Deliverable: Production ready

**Hari 4: Soft Launch**
- [ ] Invite admin & key users untuk test
- [ ] Monitor logs & errors
- [ ] Final adjustments
- Deliverable: No critical issues

**Hari 5: Hard Launch & Training**
- [ ] All users dapat akses
- [ ] Training session untuk semua role
- [ ] Support helpdesk ready
- [ ] Monitoring 24/7
- Deliverable: System live & operational

---

### TIMELINE SUMMARY

| Fase | Duration | Start | End | Status |
|------|----------|-------|-----|--------|
| Planning & Design | 3 minggu | Week 1 | Week 3 | - |
| Development | 6 minggu | Week 4 | Week 9 | - |
| Testing & QA | 2 minggu | Week 10 | Week 11 | - |
| Deployment | 1 minggu | Week 12 | Week 12 | - |
| **TOTAL** | **12 minggu** | Week 1 | Week 12 | Ready |

---

## KEUNGGULAN SISTEM

✨ **1. Otomasi & AI Penuh**
- Perhitungan nilai otomatis, tidak perlu manual excel
- Generate sertifikat otomatis dengan data yang akurat (disertai link verifikasi QR-Code)
- AI-Assisted Red-Flag Alert untuk mendeteksi masalah siswa lebih cepat dari analisis teks jurnal harian
- Notifikasi otomatis untuk alert penting (Email/WhatsApp)
- Backup database otomatis setiap hari

✨ **2. Real-time Monitoring & Validasi Lokasi**
- Lihat progress siswa setiap saat
- Smart Geofencing pencocokan lokasi absen siswa dengan koordinat industri untuk validasi kehadiran
- Alert instant jika ada siswa terlambat/alpa
- Dashboard updated real-time
- Analisis data live

✨ **3. Kemudahan Akses & Sisi Industri**
- Login menggunakan Magic Link WhatsApp/Email tanpa harus repot mengingat password bagi industri
- Form input nilai kompetensi dinamis yang otomatis menyesuaikan dengan jurusan siswa
- Rekomendasi rekrutmen langsung (Talent Pool) untuk mempermudah industri merekrut siswa terbaik
- Pembimbing sekolah hanya melihat siswa bimbingannya, industri hanya melihat siswa di tempatnya, admin memonitor semuanya

✨ **4. Paperless & Digital**
- Semua dokumen digital (laporan, sertifikat, transkrip)
- Mengurangi penggunaan kertas
- Mudah di-backup & arsip
- Hemat biaya cetak

✨ **5. Terintegrasi**
- Sync dengan sistem akademik sekolah (jika ada)
- Import data siswa otomatis
- Export data ke format standar (Excel, PDF)
- Integrasi email & SMS untuk notifikasi

✨ **6. Laporan Fleksibel**
- Export data dalam berbagai format
- Generate laporan custom sesuai kebutuhan
- Cetak sertifikat individual atau batch
- Analytics & insights untuk improvement

✨ **7. Mobile-Friendly**
- Aplikasi responsive, bisa diakses dari smartphone
- Siswa bisa submit laporan dari mobile
- Foto check-in dari mobile camera
- Pembimbing bisa monitor dari mana saja

✨ **8. Aman & Terpercaya**
- Enkripsi password & data sensitif
- Role-based access control
- Audit trail semua aktivitas
- Backup & disaster recovery plan
- HTTPS secure connection

✨ **9. Hemat Waktu**
- Admin tidak perlu input data manual
- Pembimbing tidak perlu hitung nilai manual
- Koordinator tidak perlu compile laporan dari banyak file
- Cetak sertifikat instant, tidak perlu desain ulang

✨ **10. Transparan & Objektif**
- Penilaian berdasarkan rubrik yang jelas
- Semua pihak bisa lihat proses penilaian
- Tidak ada "kesalahan" karena kalkulasi otomatis
- Catatan feedback tercatat dengan baik

---

## CATATAN PENTING

### Untuk Sekolah/Admin
- Persiapkan tim IT untuk maintenance & support
- Budget untuk cloud hosting & domain
- Training panjang untuk semua pengguna
- Backup procedure yang teratur

### Untuk Pembimbing
- Pastikan input nilai sesuai rubrik yang ada
- Beri feedback konstruktif & detail
- Monitor siswa secara berkala
- Komunikasi dengan industri

### Untuk Siswa
- Submit laporan harian tepat waktu
- Ambil foto check-in dengan baik
- Interaksi dengan pembimbing & industri
- Persiapkan dokumen yang dibutuhkan

### Untuk Industri
- Input nilai kompetensi sesuai kriteria
- Beri feedback realistis tentang performa siswa
- Maintain komunikasi dengan sekolah
- Arsip dokumen penting

---

## KONTAK & SUPPORT

Untuk pertanyaan atau saran tentang sistem ini, silakan hubungi:

**Koordinator PKL SMK Advance**
- Email: pkl@smkadvance.sch.id
- No. Telepon: 0274-XXXXX
- Jam Kerja: Senin-Jumat, 08:00-16:00

**Tim IT/Technical Support**
- Email: itsupport@smkadvance.sch.id
- Hotline: 0274-YYYYY
- Jam Support: Senin-Jumat, 08:00-15:00

---

**Dokumen ini disusun untuk keperluan pengembangan Website Monitoring PKL SMK Advance.**

**Versi**: 1.0  
**Tanggal**: 16 Januari 2024  
**Status**: Ready for Development

---

