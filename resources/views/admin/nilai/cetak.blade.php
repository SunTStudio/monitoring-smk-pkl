<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Nilai PKL - {{ $siswa->nama_lengkap }}</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            font-size: 0.85rem;
            padding: 30px;
        }
        .report-header {
            border-bottom: 3px double #0f172a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .report-title {
            font-weight: 700;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .table-meta td {
            padding: 4px 8px;
            border: none;
            font-size: 0.85rem;
        }
        .table-score th {
            background-color: #f8fafc !important;
            color: #0f172a;
            font-weight: 600;
            border: 1px solid #cbd5e1 !important;
        }
        .table-score td {
            border: 1px solid #cbd5e1 !important;
            padding: 10px 12px;
        }
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-title {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 60px;
        }
        .signature-name {
            font-weight: 600;
            text-decoration: underline;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>

    <!-- Print control bar for screen viewing -->
    <div class="container-fluid mb-4 p-3 bg-light rounded border d-flex justify-content-between align-items-center no-print shadow-sm">
        <div>
            <span class="fw-semibold text-dark"><i class="bi bi-file-earmark-pdf"></i> Pratinjau Cetak Rapor PKL</span>
            <br><small class="text-muted">Gunakan tombol di samping untuk mencetak atau menyimpan dokumen sebagai PDF.</small>
        </div>
        <div>
            <button onclick="window.history.back()" class="btn btn-outline-dark btn-sm rounded-pill px-3 me-2">Kembali</button>
            <button onclick="window.print()" class="btn btn-dark btn-sm rounded-pill px-3"><i class="bi bi-printer"></i> Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- Official Report Card Content -->
    <div class="container-fluid">
        <!-- Logo / Title -->
        <div class="report-header text-center">
            <h4 class="mb-1 fw-bold text-dark">PEMERINTAH PROVINSI JAWA TENGAH</h4>
            <h3 class="mb-1 fw-bold text-dark">SMK NEGERI ADVANCE SOLO</h3>
            <p class="mb-0 text-muted small">Jl. Slamet Riyadi No. 123, Surakarta | Telp: (0271) 645123 | Email: info@smkadvance.sch.id</p>
        </div>

        <div class="text-center mb-4">
            <h5 class="report-title fw-bold text-decoration-underline text-dark mb-1">LAPORAN HASIL PENILAIAN</h5>
            <h6 class="fw-semibold text-secondary">PRAKTIK KERJA LAPANGAN (PKL)</h6>
            @if($nilaiAkhir->no_sertifikat)
                <p class="text-muted small">No. Sertifikat: {{ $nilaiAkhir->no_sertifikat }}</p>
            @endif
        </div>

        <!-- Student details block -->
        <div class="row mb-4">
            <div class="col-6">
                <table class="table-meta">
                    <tr>
                        <td class="fw-semibold text-secondary" style="width: 150px;">Nama Siswa</td>
                        <td>:</td>
                        <td class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-secondary">NISN / NIS</td>
                        <td>:</td>
                        <td>{{ $siswa->nisn }} / {{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-secondary">Kelas / Jurusan</td>
                        <td>:</td>
                        <td>{{ $siswa->kelas }} / {{ $siswa->jurusan }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table-meta">
                    <tr>
                        <td class="fw-semibold text-secondary" style="width: 150px;">Tempat PKL (DU-DI)</td>
                        <td>:</td>
                        <td class="fw-bold text-dark">{{ $penugasan->industri->nama_industri ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-secondary">Alamat Mitra</td>
                        <td>:</td>
                        <td>{{ $penugasan->industri->kota ?? '-' }}, {{ $penugasan->industri->propinsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-secondary">Periode Kegiatan</td>
                        <td>:</td>
                        <td>
                            {{ \Carbon\Carbon::parse($penugasan->tgl_mulai_pkl)->translatedFormat('d M Y') }} s/d
                            {{ \Carbon\Carbon::parse($penugasan->tgl_selesai_pkl)->translatedFormat('d M Y') }} 
                            ({{ $nilaiAkhir->total_hari_pkl }} hari)
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Scores table -->
        <h6 class="fw-bold text-dark mb-2">A. Rekapitulasi Nilai PKL</h6>
        <table class="table table-bordered table-score mb-4 text-center">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Aspek Penilaian PKL</th>
                    <th style="width: 120px;">Bobot</th>
                    <th style="width: 150px;">Nilai Angka (1-100)</th>
                    <th style="width: 150px;">Nilai Berbobot</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-start">
                        <strong>Kehadiran & Kedisiplinan Siswa</strong><br>
                        <small class="text-muted">Total kehadiran: {{ $nilaiAkhir->total_hari_hadir }} dari {{ $nilaiAkhir->total_hari_pkl }} hari kerja.</small>
                    </td>
                    <td>20%</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_kehadiran, 2) }}</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_kehadiran * 0.20, 2) }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-start">
                        <strong>Review Jurnal Sikap & Kepribadian</strong><br>
                        <small class="text-muted">Dihitung dari rata-rata nilai harian pembimbing sekolah.</small>
                    </td>
                    <td>30%</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_sikap_bobot, 2) }}</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_sikap_bobot * 0.30, 2) }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-start">
                        <strong>Review Jurnal Kompetensi & Kinerja Teknis</strong><br>
                        <small class="text-muted">Dihitung dari rata-rata nilai harian pembimbing lapangan industri.</small>
                    </td>
                    <td>50%</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_kompetensi_bobot, 2) }}</td>
                    <td class="fw-semibold">{{ number_format($nilaiAkhir->nilai_kompetensi_bobot * 0.50, 2) }}</td>
                </tr>
                <tr class="table-dark text-white fw-bold">
                    <td colspan="3" class="text-end">NILAI AKHIR PKL (RATA-RATA)</td>
                    <td>{{ number_format($nilaiAkhir->nilai_akhir_pkl, 2) }}</td>
                    <td>{{ number_format($nilaiAkhir->nilai_akhir_pkl, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Result / Predicate block -->
        <h6 class="fw-bold text-dark mb-2">B. Predikat Kelulusan</h6>
        <div class="p-3 border rounded mb-4 bg-light-subtle">
            <div class="row">
                <div class="col-4 text-center border-end">
                    <span class="text-secondary small d-block">PREDIKAT</span>
                    <h2 class="fw-bold text-dark mb-0">GRADE {{ $nilaiAkhir->grade }}</h2>
                </div>
                <div class="col-4 text-center border-end">
                    <span class="text-secondary small d-block">STATUS KELULUSAN</span>
                    <h3 class="fw-bold text-uppercase {{ $nilaiAkhir->status_kelulusan === 'lulus' ? 'text-success' : 'text-danger' }} mb-0">
                        {{ str_replace('_', ' ', $nilaiAkhir->status_kelulusan) }}
                    </h3>
                </div>
                <div class="col-4">
                    <span class="text-secondary small d-block">CATATAN PEMBIMBING</span>
                    <p class="mb-0 text-muted small">{{ $nilaiAkhir->catatan ?? 'Siswa telah menyelesaikan kegiatan PKL dengan kedisiplinan dan pencapaian kompetensi yang baik.' }}</p>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="row text-center">
                <div class="col-4">
                    <p class="mb-0">Mengetahui,</p>
                    <p class="mb-5">Pembimbing Lapangan Industri</p>
                    <p class="signature-name mb-0">{{ $penugasan->pembimbingIndustri->name ?? 'Budi Utomo' }}</p>
                    <span class="text-muted small">PT. {{ $penugasan->industri->nama_industri ?? 'ABC Electronics' }}</span>
                </div>
                <div class="col-4">
                    <p class="mb-0">Surakarta, {{ \Carbon\Carbon::parse($nilaiAkhir->tgl_finalisasi)->translatedFormat('d F Y') }}</p>
                    <p class="mb-5">Pembimbing Sekolah</p>
                    <p class="signature-name mb-0">{{ $penugasan->pembimbingSekolah->name ?? 'Ibu Siti Nurhaliza, S.Pd.' }}</p>
                    <span class="text-muted small">NIP. 19850312 201012 2 003</span>
                </div>
                <div class="col-4">
                    <p class="mb-0">Mengesahkan,</p>
                    <p class="mb-5">Kepala SMK Negeri Advance Solo</p>
                    <p class="signature-name mb-0">Dr. H. Bambang Riyanto, M.T.</p>
                    <span class="text-muted small">NIP. 19700815 199503 1 002</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Automatically trigger browser print dialog -->
    <script>
        window.onload = function() {
            // Uncomment to trigger print immediately when page loads
            // window.print();
        }
    </script>
</body>
</html>
