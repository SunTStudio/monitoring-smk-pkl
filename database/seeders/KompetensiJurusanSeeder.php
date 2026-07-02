<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KompetensiJurusan;

class KompetensiJurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data with safety
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        KompetensiJurusan::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // ============================================================
        // SOFT SKILL UNIVERSAL (berlaku untuk SEMUA jurusan)
        // ============================================================
        $softSkillUniversal = [
            ['nama_aspek' => 'Kedisiplinan & Ketepatan Waktu', 'deskripsi_aspek' => 'Datang tepat waktu, mengikuti aturan jam kerja, tidak meninggalkan tempat kerja tanpa izin.', 'urutan' => 1],
            ['nama_aspek' => 'Tanggung Jawab', 'deskripsi_aspek' => 'Menyelesaikan tugas yang diberikan, tidak mudah menyerah, bertanggung jawab atas hasil pekerjaan.', 'urutan' => 2],
            ['nama_aspek' => 'Komunikasi & Sopan Santun', 'deskripsi_aspek' => 'Mampu berkomunikasi dengan baik, menggunakan bahasa yang sopan kepada atasan dan rekan kerja.', 'urutan' => 3],
            ['nama_aspek' => 'Kerjasama Tim', 'deskripsi_aspek' => 'Aktif berpartisipasi dalam tim, menghargai pendapat orang lain, dan mendukung rekan kerja.', 'urutan' => 4],
            ['nama_aspek' => 'Inisiatif & Kreativitas', 'deskripsi_aspek' => 'Proaktif mencari solusi, berani mengajukan ide baru, tidak menunggu diperintah untuk bekerja.', 'urutan' => 5],
            ['nama_aspek' => 'Kejujuran & Integritas', 'deskripsi_aspek' => 'Jujur dalam pekerjaan, tidak melakukan kecurangan, menjaga kerahasiaan perusahaan.', 'urutan' => 6],
            ['nama_aspek' => 'Kemampuan Beradaptasi', 'deskripsi_aspek' => 'Mampu menyesuaikan diri dengan lingkungan kerja baru, fleksibel menghadapi perubahan tugas.', 'urutan' => 7],
            ['nama_aspek' => 'Penampilan & Kerapian', 'deskripsi_aspek' => 'Berpenampilan rapi dan profesional sesuai standar dress code perusahaan.', 'urutan' => 8],
            ['nama_aspek' => 'Ketelitian & Akurasi', 'deskripsi_aspek' => 'Cermat dalam mengerjakan tugas, meminimalkan kesalahan, dan memperhatikan detail pekerjaan.', 'urutan' => 9],
            ['nama_aspek' => 'Etika Profesionalisme', 'deskripsi_aspek' => 'Bersikap profesional, menghormati hierarki organisasi, dan mematuhi budaya perusahaan.', 'urutan' => 10],
            ['nama_aspek' => 'Soft Skill Lainnya', 'deskripsi_aspek' => 'Sikap, etika kerja, atau keterampilan interpersonal lainnya yang ditunjukkan di tempat kerja.', 'urutan' => 11],
        ];

        foreach ($softSkillUniversal as $skill) {
            KompetensiJurusan::create(array_merge($skill, [
                'jurusan' => 'Umum',
                'kategori' => 'softskill',
                'bobot' => 10.00,
                'is_universal' => true,
            ]));
        }

        // ============================================================
        // HARD SKILL UNIVERSAL (berlaku untuk SEMUA jurusan)
        // ============================================================
        $hardSkillUniversal = [
            ['nama_aspek' => 'Skill Teknis Lainnya', 'deskripsi_aspek' => 'Keterampilan atau keahlian praktis/teknis lainnya yang dipraktikkan namun tidak tercantum di atas.', 'urutan' => 99],
        ];

        foreach ($hardSkillUniversal as $skill) {
            KompetensiJurusan::create(array_merge($skill, [
                'jurusan' => 'Umum',
                'kategori' => 'hardskill',
                'bobot' => 10.00,
                'is_universal' => true,
            ]));
        }

        // ============================================================
        // RPL — Rekayasa Perangkat Lunak
        // ============================================================
        $hardSkillRPL = [
            ['nama_aspek' => 'Dasar Rekayasa Perangkat Lunak', 'deskripsi_aspek' => 'Kemampuan memahami algoritma dasar, struktur data, variabel, operator, percabangan, perulangan, dan fungsi.', 'urutan' => 1],
            ['nama_aspek' => 'Pemrograman Berorientasi Objek (OOP)', 'deskripsi_aspek' => 'Penerapan konsep class, object, encapsulation, inheritance, polymorphism, dan abstraction.', 'urutan' => 2],
            ['nama_aspek' => 'Analisis & Perancangan Sistem (UML)', 'deskripsi_aspek' => 'Kemampuan merancang use case diagram, activity diagram, class diagram, ERD, dan mockup antarmuka.', 'urutan' => 3],
            ['nama_aspek' => 'Desain Basis Data (SQL)', 'deskripsi_aspek' => 'Perancangan skema database relasional, normalisasi tabel, penulisan query SQL (DDL, DML, join, indexing).', 'urutan' => 4],
            ['nama_aspek' => 'Pemrograman Web (Frontend Development)', 'deskripsi_aspek' => 'Pembuatan web responsif menggunakan HTML5, CSS3 (Flexbox/Grid), JavaScript DOM, dan CSS framework (Tailwind/Bootstrap).', 'urutan' => 5],
            ['nama_aspek' => 'Pemrograman Web (Backend Development)', 'deskripsi_aspek' => 'Pengembangan logika server-side, routing, MVC pattern, middleware, ORM, session/cookie menggunakan Laravel atau Node.js.', 'urutan' => 6],
            ['nama_aspek' => 'Integrasi & Pembuatan API (RESTful API)', 'deskripsi_aspek' => 'Implementasi arsitektur REST, routing endpoint, parsing JSON, request method, dan otentikasi API.', 'urutan' => 7],
            ['nama_aspek' => 'Pemrograman Perangkat Bergerak (Mobile Dev)', 'deskripsi_aspek' => 'Pengembangan aplikasi mobile menggunakan native (Kotlin/Java) atau hybrid/cross-platform (Flutter/React Native).', 'urutan' => 8],
            ['nama_aspek' => 'Version Control System (Git & GitHub)', 'deskripsi_aspek' => 'Penggunaan command git init, add, commit, branch, merge, resolve conflict, clone, push, pull, dan kolaborasi tim.', 'urutan' => 9],
            ['nama_aspek' => 'Deployment & Cloud Hosting', 'deskripsi_aspek' => 'Melakukan deployment aplikasi ke layanan hosting (Shared Hosting, Vercel, Netlify) atau mengelola VPS dasar.', 'urutan' => 10],
            ['nama_aspek' => 'Software Testing & Quality Assurance', 'deskripsi_aspek' => 'Pengujian aplikasi secara manual maupun automated (Unit Testing/Integration Testing) serta pelaporan bug.', 'urutan' => 11],
        ];

        $softSkillRPL = [
            ['nama_aspek' => 'Dokumentasi Teknis', 'deskripsi_aspek' => 'Kemampuan menulis dokumentasi kode, panduan penggunaan (user guide), dan spesifikasi teknis (SRS) dengan jelas.', 'urutan' => 12],
            ['nama_aspek' => 'Kolaborasi Agile/Scrum', 'deskripsi_aspek' => 'Kemampuan bekerja dalam siklus sprint, mengikuti daily standup, menggunakan papan kanban, dan berkolaborasi.', 'urutan' => 13],
        ];

        foreach ($hardSkillRPL as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'RPL', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }
        foreach ($softSkillRPL as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'RPL', 'kategori' => 'softskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // TKJ — Teknik Komputer & Jaringan
        // ============================================================
        $hardSkillTKJ = [
            ['nama_aspek' => 'Perakitan & Perawatan PC/Laptop', 'deskripsi_aspek' => 'Kemampuan merakit komponen hardware, instalasi OS (Windows/Linux), manajemen partisi, driver, dan pemeliharaan PC.', 'urutan' => 1],
            ['nama_aspek' => 'Pengabelan & Media Transmisi', 'deskripsi_aspek' => 'Kemampuan membuat kabel UTP (straight & cross) sesuai standar EIA/TIA 568, crimping, testing RJ-45, serta dasar Fiber Optic.', 'urutan' => 2],
            ['nama_aspek' => 'Desain & Pengalamatan IP (Subnetting)', 'deskripsi_aspek' => 'Perhitungan alokasi IP Address menggunakan metode CIDR dan VLSM untuk efisiensi pembagian subnet jaringan.', 'urutan' => 3],
            ['nama_aspek' => 'Instalasi Jaringan Lokal (LAN & WLAN)', 'deskripsi_aspek' => 'Pemasangan Switch, Access Point, konfigurasi SSID, enkripsi keamanan nirkabel (WPA2/WPA3), DHCP server, dan client.', 'urutan' => 4],
            ['nama_aspek' => 'Konfigurasi Routing (MikroTik RouterOS)', 'deskripsi_aspek' => 'Penerapan static routing, dynamic routing (OSPF), NAT (Masquerade), firewall filter, dan port forwarding.', 'urutan' => 5],
            ['nama_aspek' => 'Administrasi Switch & VLAN', 'deskripsi_aspek' => 'Segmentasi jaringan LAN dengan Virtual LAN (VLAN) serta konfigurasi trunking link pada manageable switch.', 'urutan' => 6],
            ['nama_aspek' => 'Manajemen Bandwidth & QoS', 'deskripsi_aspek' => 'Pembagian alokasi bandwidth internet yang adil untuk client menggunakan Simple Queue atau Queue Tree di Router.', 'urutan' => 7],
            ['nama_aspek' => 'Layanan Jaringan Server (Server Administration)', 'deskripsi_aspek' => 'Instalasi dan konfigurasi DNS Server (Bind9), Web Server (Nginx/Apache), FTP Server, SSH Server, dan Database Server.', 'urutan' => 8],
            ['nama_aspek' => 'Keamanan Jaringan & VPN', 'deskripsi_aspek' => 'Proteksi sistem jaringan dari intrusi, pemblokiran situs via firewall, dan penyediaan akses jarak jauh aman menggunakan VPN.', 'urutan' => 9],
            ['nama_aspek' => 'Instalasi & Splicing Fiber Optic', 'deskripsi_aspek' => 'Penanganan kabel FO, teknik splicing menggunakan fusion/splicer, dan pengukuran redaman sinyal menggunakan OPM/OTDR.', 'urutan' => 10],
            ['nama_aspek' => 'Virtualisasi & Cloud Computing', 'deskripsi_aspek' => 'Konfigurasi mesin virtual menggunakan hypervisor (VirtualBox, Proxmox VE, VMware ESXi) dan deployment container docker.', 'urutan' => 11],
            ['nama_aspek' => 'Monitoring & Troubleshooting Jaringan', 'deskripsi_aspek' => 'Penggunaan tools monitoring (Zabbix/Nagios) serta penganalisaan paket data menggunakan Wireshark untuk deteksi masalah.', 'urutan' => 12],
        ];

        $softSkillTKJ = [
            ['nama_aspek' => 'Dokumentasi Topologi & Sistem', 'deskripsi_aspek' => 'Pembuatan diagram jaringan, inventarisasi perangkat, serta pencatatan log konfigurasi jaringan secara terstruktur.', 'urutan' => 13],
        ];

        foreach ($hardSkillTKJ as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'TKJ', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }
        foreach ($softSkillTKJ as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'TKJ', 'kategori' => 'softskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // Akuntansi
        // ============================================================
        $hardSkillAkuntansi = [
            ['nama_aspek' => 'Pencatatan Jurnal & Buku Besar', 'deskripsi_aspek' => 'Kemampuan mencatat transaksi keuangan ke dalam jurnal umum dan memposting ke buku besar.', 'urutan' => 1],
            ['nama_aspek' => 'Penyusunan Laporan Keuangan', 'deskripsi_aspek' => 'Kemampuan menyusun neraca, laporan laba rugi, dan laporan arus kas sesuai standar akuntansi.', 'urutan' => 2],
            ['nama_aspek' => 'Penggunaan Aplikasi Akuntansi', 'deskripsi_aspek' => 'Kemampuan mengoperasikan software akuntansi (MYOB, Accurate, SAP) untuk pencatatan keuangan.', 'urutan' => 3],
            ['nama_aspek' => 'Rekonsiliasi Bank & Kas', 'deskripsi_aspek' => 'Kemampuan melakukan rekonsiliasi antara catatan perusahaan dengan laporan bank.', 'urutan' => 4],
            ['nama_aspek' => 'Perpajakan Dasar', 'deskripsi_aspek' => 'Pemahaman dan kemampuan menghitung pajak penghasilan, PPN, dan pelaporan SPT sederhana.', 'urutan' => 5],
            ['nama_aspek' => 'Pengelolaan Piutang & Hutang', 'deskripsi_aspek' => 'Kemampuan mengelola akun piutang usaha dan hutang dagang beserta aging report-nya.', 'urutan' => 6],
            ['nama_aspek' => 'Analisis Keuangan Dasar', 'deskripsi_aspek' => 'Kemampuan menganalisis laporan keuangan menggunakan rasio keuangan untuk mengambil kesimpulan bisnis.', 'urutan' => 7],
        ];

        $softSkillAkuntansi = [
            ['nama_aspek' => 'Kerahasiaan & Etika Data Keuangan', 'deskripsi_aspek' => 'Menjaga kerahasiaan data keuangan perusahaan dan berperilaku sesuai etika profesi akuntansi.', 'urutan' => 8],
        ];

        foreach ($hardSkillAkuntansi as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'Akuntansi', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }
        foreach ($softSkillAkuntansi as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'Akuntansi', 'kategori' => 'softskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // Pemasaran / Bisnis Digital
        // ============================================================
        $hardSkillPemasaran = [
            ['nama_aspek' => 'Pelayanan Pelanggan (Customer Service)', 'deskripsi_aspek' => 'Kemampuan melayani pelanggan dengan ramah, profesional, dan menyelesaikan komplain dengan baik.', 'urutan' => 1],
            ['nama_aspek' => 'Teknik Penjualan & Negosiasi', 'deskripsi_aspek' => 'Kemampuan mempresentasikan produk, meyakinkan calon pembeli, dan melakukan negosiasi harga.', 'urutan' => 2],
            ['nama_aspek' => 'Pemasaran Digital (Social Media)', 'deskripsi_aspek' => 'Kemampuan membuat konten pemasaran, mengelola media sosial bisnis, dan analisis engagement.', 'urutan' => 3],
            ['nama_aspek' => 'Penggunaan Marketplace & E-Commerce', 'deskripsi_aspek' => 'Kemampuan mengelola toko online (Tokopedia, Shopee, dll) termasuk listing produk dan pengelolaan order.', 'urutan' => 4],
            ['nama_aspek' => 'Riset Pasar & Analisis Kompetitor', 'deskripsi_aspek' => 'Kemampuan melakukan survei pasar, menganalisis tren, dan membandingkan posisi produk dengan kompetitor.', 'urutan' => 5],
            ['nama_aspek' => 'Pengelolaan Stok & Inventori', 'deskripsi_aspek' => 'Kemampuan mencatat stok barang, melakukan stock opname, dan mengelola sistem inventori.', 'urutan' => 6],
            ['nama_aspek' => 'Pembuatan Konten & Copywriting', 'deskripsi_aspek' => 'Kemampuan membuat konten promosi yang menarik (caption, poster, video pendek) untuk berbagai platform.', 'urutan' => 7],
        ];

        foreach ($hardSkillPemasaran as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'Pemasaran', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // Teknik Kendaraan Ringan (TKR / Otomotif)
        // ============================================================
        $hardSkillTKR = [
            ['nama_aspek' => 'Tune Up Mesin Bensin & Diesel', 'deskripsi_aspek' => 'Kemampuan melakukan tune up mesin secara berkala: busi, filter udara, filter oli, timing belt.', 'urutan' => 1],
            ['nama_aspek' => 'Servis Sistem Pengereman', 'deskripsi_aspek' => 'Kemampuan memeriksa, merawat, dan mengganti komponen rem (kampas rem, kaliper, master rem).', 'urutan' => 2],
            ['nama_aspek' => 'Perawatan Sistem Transmisi', 'deskripsi_aspek' => 'Kemampuan melakukan servis transmisi manual/otomatik termasuk penggantian oli transmisi.', 'urutan' => 3],
            ['nama_aspek' => 'Diagnosa Kelistrikan Kendaraan', 'deskripsi_aspek' => 'Kemampuan menggunakan multimeter dan scan tool untuk mendiagnosa masalah sistem kelistrikan kendaraan.', 'urutan' => 4],
            ['nama_aspek' => 'Perbaikan Sistem Kemudi & Suspensi', 'deskripsi_aspek' => 'Kemampuan memeriksa dan memperbaiki komponen sistem kemudi dan suspensi kendaraan.', 'urutan' => 5],
            ['nama_aspek' => 'Penggunaan Alat Bengkel (SST)', 'deskripsi_aspek' => 'Kemampuan menggunakan special service tool (SST) dan peralatan bengkel otomotif secara tepat dan aman.', 'urutan' => 6],
            ['nama_aspek' => 'Keselamatan Kerja Bengkel (K3)', 'deskripsi_aspek' => 'Menerapkan prosedur K3 dalam bengkel: penggunaan APD, penanganan limbah oli, dan pencegahan kebakaran.', 'urutan' => 7],
        ];

        foreach ($hardSkillTKR as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'TKR', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // Perhotelan / PHPH (Pariwisata)
        // ============================================================
        $hardSkillPerhotelan = [
            ['nama_aspek' => 'Front Office & Resepsionis', 'deskripsi_aspek' => 'Kemampuan melakukan check-in/out tamu, mengelola reservasi, dan memberikan informasi hotel dengan ramah.', 'urutan' => 1],
            ['nama_aspek' => 'Housekeeping & Room Service', 'deskripsi_aspek' => 'Kemampuan membersihkan dan menyiapkan kamar sesuai standar hotel (bed making, amenities, dll).', 'urutan' => 2],
            ['nama_aspek' => 'Food & Beverage Service', 'deskripsi_aspek' => 'Kemampuan melayani tamu di restoran/kafe: mengambil order, menyajikan makanan, dan table manner.', 'urutan' => 3],
            ['nama_aspek' => 'Tata Boga & Pengolahan Makanan', 'deskripsi_aspek' => 'Kemampuan mengolah bahan makanan menjadi hidangan sesuai standar resep dan plating yang menarik.', 'urutan' => 4],
            ['nama_aspek' => 'Pelayanan Prima (Service Excellence)', 'deskripsi_aspek' => 'Memberikan layanan yang melebihi ekspektasi tamu: senyum, sapa, salam, sopan, dan sigap.', 'urutan' => 5],
            ['nama_aspek' => 'Bahasa Inggris Pariwisata', 'deskripsi_aspek' => 'Kemampuan berkomunikasi dalam bahasa Inggris untuk melayani tamu asing di lingkungan pariwisata.', 'urutan' => 6],
        ];

        foreach ($hardSkillPerhotelan as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'Perhotelan', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        // ============================================================
        // Kimia Industri / Kimia Analis
        // ============================================================
        $hardSkillKimia = [
            ['nama_aspek' => 'Analisis & Pengujian Laboratorium', 'deskripsi_aspek' => 'Kemampuan melakukan analisis kimia (titrasi, gravimetri, spektrofotometri) sesuai metode standar.', 'urutan' => 1],
            ['nama_aspek' => 'Penanganan Bahan Kimia & K3 Lab', 'deskripsi_aspek' => 'Kemampuan menangani, menyimpan, dan mendisposisi bahan kimia sesuai prosedur keselamatan laboratorium.', 'urutan' => 2],
            ['nama_aspek' => 'Pengoperasian Alat Laboratorium', 'deskripsi_aspek' => 'Kemampuan menggunakan instrumen laboratorium (pH meter, GC, HPLC, spektrofotometer) dengan benar.', 'urutan' => 3],
            ['nama_aspek' => 'Pembuatan & Pengenceran Larutan', 'deskripsi_aspek' => 'Kemampuan membuat larutan standar, reagen, dan melakukan perhitungan pengenceran secara akurat.', 'urutan' => 4],
            ['nama_aspek' => 'Penulisan Laporan Analisis', 'deskripsi_aspek' => 'Kemampuan mendokumentasikan prosedur kerja, hasil analisis, dan interpretasi data secara ilmiah.', 'urutan' => 5],
            ['nama_aspek' => 'Pengendalian Mutu (Quality Control)', 'deskripsi_aspek' => 'Pemahaman dan kemampuan menerapkan prosedur QC produk dalam lingkungan industri.', 'urutan' => 6],
            ['nama_aspek' => 'Good Laboratory Practice (GLP)', 'deskripsi_aspek' => 'Menerapkan prinsip GLP: kebersihan, kalibrasi alat, validasi metode, dan pencatatan yang akurat.', 'urutan' => 7],
        ];

        foreach ($hardSkillKimia as $skill) {
            KompetensiJurusan::create(array_merge($skill, ['jurusan' => 'Kimia Industri', 'kategori' => 'hardskill', 'bobot' => 10.00, 'is_universal' => false]));
        }

        $this->command->info('✅ KompetensiJurusan seeder selesai! Data skill untuk 7 jurusan + universal telah dibuat.');
    }
}
