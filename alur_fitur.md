# Panduan Alur Fitur & Navigasi E-PKL Monitoring

![Bagan Alur Flowchart Sistem E-PKL](C:/Users/Programmer/.gemini/antigravity-ide/brain/b358b03f-4952-4fde-8685-6181c1e9b5ec/flowchart_pkl_indonesia_1782895005604.png)

Dokumen ini menjelaskan alur tombol-ke-tombol dan menu-ke-menu untuk setiap kegiatan utama di dalam aplikasi E-Monitoring PKL.

---

## 1. Alur Absensi Harian (Khusus Siswa)

### A. Absen Masuk (Check-In)
Siswa Login
↓
Dashboard Siswa
↓
Card **Absensi Hari Ini**
↓
Pilih Status Kehadiran (`Hadir` / `Izin` / `Sakit`)
↓
Upload File pada input **Bukti Foto Selfie** (Maks 2MB)
↓
*(Jika memilih Hadir)* Dapatkan koordinat lokasi GPS otomatis (Geofencing validasi radius 100m)
↓
Klik tombol **Kirim Absensi Masuk (Check-In)**
↓
Sistem mencatat absensi masuk & jam check-in saat ini.

---

### B. Absen Keluar (Check-Out)
Siswa Login (Sore hari / saat pulang kerja)
↓
Dashboard Siswa
↓
Card **Absensi Hari Ini** (Panel Check-Out sekarang aktif)
↓
Upload File pada input **Bukti Foto Checkout** (Maks 2MB)
↓
Klik tombol **Kirim Absensi Keluar (Check-Out)**
↓
Sistem mencatat jam check-out & menghitung otomatis total durasi jam kerja riil hari ini.

---

## 2. Alur Pengisian Jurnal Harian (Siswa) & Review Jurnal (Pembimbing/DUDI)

### A. Pengisian Jurnal (Siswa)
Siswa Login
↓
Dashboard Siswa / Menu **Riwayat & Jurnal**
↓
Form **Isi Jurnal Pekerjaan Harian**
↓
Isi Data:
- Tanggal Laporan
- Jam Mulai & Jam Selesai Kerja
- Aktivitas Pekerjaan (Textarea)
- Hasil / Output Pekerjaan (Textarea)
- Pilih Skill/Aspek Kompetensi yang Dipraktikkan (Checkbox Tag)
- Upload File Lampiran Dokumentasi (PDF/Gambar, Maks 5MB)
↓
Klik tombol **Kirim Jurnal Harian**
↓
Notifikasi otomatis dikirim ke Guru Pembimbing & Pembimbing Industri terkait.

---

### B. Review & Penilaian Jurnal (Oleh Guru Pembimbing / Pembimbing Industri)
Pembimbing / DUDI Login
↓
Dashboard Utama
↓
Pilih Siswa pada dropdown **Pilih Siswa Bimbingan**
↓
Tabel **Jurnal Laporan Harian Siswa**
↓
Cari Jurnal berstatus `Submitted`
↓
Klik tombol **Review Jurnal** (icon edit/check)
↓
Modal Review Jurnal Tampil:
- Pilih Status (`Disetujui` / `Ditolak`)
- Isi Nilai Jurnal (1 s.d. 100)
- Tulis Feedback Pembimbing
↓
Klik tombol **Simpan Review**
↓
Status jurnal berubah dan notifikasi otomatis dikirim ke akun siswa.

---

## 3. Alur Penilaian Sikap (Oleh Guru Pembimbing)

Guru Pembimbing Login
↓
Dashboard Guru
↓
Pilih Siswa pada dropdown **Pilih Siswa Bimbingan**
↓
Scroll ke panel **Penilaian Aspek Sikap (Softskill)**
↓
Isi Form Penilaian:
- Nilai Kedisiplinan (0 - 100) + Catatan
- Nilai Kerjasama (0 - 100) + Catatan
- Nilai Tanggung Jawab (0 - 100) + Catatan
- Nilai Inisiatif (0 - 100) + Catatan
- Catatan Umum untuk Siswa
↓
Pilih Status Penilaian (`Draft` jika belum selesai, atau `Finalized` untuk mengunci nilai)
↓
Klik tombol **Simpan Penilaian Sikap**
↓
Sistem menghitung rata-rata nilai sikap, mengunci data, dan mengirim notifikasi ke siswa.

---

## 4. Alur Penilaian Kompetensi Teknis (Oleh Pembimbing Industri / DUDI)

Pembimbing Industri Login
↓
Dashboard Industri
↓
Pilih Siswa pada dropdown **Pilih Siswa Bimbingan**
↓
Scroll ke panel **Penilaian Kompetensi Teknis (Hardskill)**
↓
Daftar Aspek Kompetensi (otomatis memuat aspek khusus jurusan siswa bersangkutan)
↓
Isi Form Penilaian untuk masing-masing aspek kompetensi:
- Nilai (0 - 100)
- Catatan Kinerja Aspek
↓
Tulis Catatan Rekomendasi Industri / Saran Masukan
↓
Pilih Status Penilaian (`Draft` atau `Finalized` untuk mengunci nilai)
↓
Klik tombol **Simpan Penilaian Aspek Kompetensi**
↓
Sistem menghitung rata-rata nilai hardskill, mengunci data, dan mengirim notifikasi ke siswa.

---

## 5. Alur Finalisasi Nilai & Cetak Rapor PKL (Oleh Admin / Koordinator Sekolah)

Admin / Koordinator Login
↓
Menu **Alokasi PKL** (Penugasan) / Menu **Penilaian**
↓
Pilih Siswa yang telah selesai periode PKL-nya
↓
Klik tombol **Finalisasi Nilai** (icon sertifikat/nilai)
↓
Form Finalisasi Nilai PKL Akhir Tampil:
- Sistem menampilkan pratinjau rekap:
  - Persentase Kehadiran (bobot 20%)
  - Rata-rata Nilai Sikap Guru (bobot 30%)
  - Rata-rata Nilai Kompetensi DUDI (bobot 50%)
  - Prediksi Nilai Akhir Hasil Pembobotan & Grade Kelulusan (A/B/C/D/E)
- Isi Tahun Periode PKL
- Isi Nomor Sertifikat Resmi Sekolah
- Tambahkan Catatan Kelulusan (Opsional)
↓
Klik tombol **Finalisasikan & Terbitkan Nilai**
↓
Sertifikat/Nilai Akhir dikunci dalam database, notifikasi kelulusan dikirim ke siswa.
↓
Kembali ke tabel manajemen nilai
↓
Klik tombol **Cetak Rapor** di samping nama siswa yang bersangkutan
↓
Halaman cetak rapor khusus terbuka dengan mode cetak printer/simpan PDF otomatis di browser.
