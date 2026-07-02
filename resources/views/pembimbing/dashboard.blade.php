@extends('layouts.app')

@section('title', 'Guru Pembimbing Dashboard')

@section('styles')
<!-- Leaflet Maps CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #modal-map {
        height: 320px;
        z-index: 1;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom p-4 shadow-sm bg-dark text-white border-0">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success p-3 rounded-3 text-white me-4">
                    <i class="bi bi-speedometer2 fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Dashboard Guru Pembimbing</h4>
                    <p class="mb-0 text-white-50">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Berikut data siswa bimbingan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER SISWA BIMBINGAN -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom p-3 shadow-sm border-0">
            <form method="GET" action="{{ route('pembimbing.dashboard') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-funnel-fill text-success me-1"></i> Pilih Siswa PKL
                        </label>
                        <select name="siswa_id" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="">-- Tampilkan Semua Siswa Bimbingan --</option>
                            @foreach($penugasan as $item)
                                <option value="{{ $item->id_siswa_fk }}" {{ $selectedSiswaId == $item->id_siswa_fk ? 'selected' : '' }}>
                                    {{ $item->siswa->nama_lengkap }} ({{ $item->siswa->kelas }} - {{ $item->siswa->jurusan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="form-label small fw-semibold text-secondary mb-1">Dari Tanggal</label>
                        <input type="date" class="form-control form-control-sm bg-light" name="tgl_mulai" value="{{ $tglMulai ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="form-label small fw-semibold text-secondary mb-1">Sampai Tanggal</label>
                        <input type="date" class="form-control form-control-sm bg-light" name="tgl_akhir" value="{{ $tglAkhir ?? '' }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        @if($selectedSiswaId || $tglMulai || $tglAkhir)
                            <a href="{{ route('pembimbing.dashboard') }}" class="btn btn-outline-secondary btn-sm fw-bold d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <!-- Siswa Magang & Log Presensi -->
    <div class="col-md-7">
        @if(!$selectedSiswaId)
            <!-- Siswa Bimbingan Card (Hanya muncul jika belum memfilter siswa) -->
            <div class="card card-custom p-4 shadow-sm mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people-fill text-success me-2"></i> Siswa PKL Bimbingan Aktif</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-sm table-responsive-stack datatable" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Jurusan</th>
                                <th>Mitra Industri</th>
                                <th>Status PKL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penugasan as $item)
                                <tr>
                                    <td data-label="Nama Siswa" class="fw-semibold text-dark">
                                        <a href="{{ route('pembimbing.dashboard', ['siswa_id' => $item->id_siswa_fk]) }}" class="text-decoration-none text-dark hover-primary">
                                            {{ $item->siswa->nama_lengkap ?? '-' }} <i class="bi bi-arrow-right-short"></i>
                                        </a>
                                    </td>
                                    <td data-label="Jurusan">{{ $item->siswa->jurusan ?? '-' }}</td>
                                    <td data-label="Mitra Industri">{{ $item->industri->nama_industri ?? '-' }}</td>
                                    <td data-label="Status PKL">
                                        @if($item->status === 'aktif')
                                            <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary text-capitalize">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada siswa PKL yang aktif dibimbing.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Log Kehadiran Siswa PKL Card -->
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-geo-alt-fill text-danger me-2"></i> 
                Log Kehadiran {{ $selectedSiswa ? 'Siswa: ' . $selectedSiswa->nama_lengkap : 'Semua Siswa Bimbingan' }}
            </h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm table-responsive-stack datatable" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Absen Masuk/Keluar</th>
                            <th>Jarak Geofence</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiran as $k)
                            @php
                                $pen = $penugasan->where('id_siswa_fk', $k->id_siswa_fk)->first();
                                $latOff = $pen && $pen->industri && $pen->industri->latitude ? (float)$pen->industri->latitude : -6.200000;
                                $lngOff = $pen && $pen->industri && $pen->industri->longitude ? (float)$pen->industri->longitude : 106.816666;
                                $nameOff = $pen && $pen->industri ? $pen->industri->nama_industri : 'Kantor Mitra';

                                // Parse student coordinates from lokasi_checkin
                                $coords = explode(',', $k->lokasi_checkin);
                                $latStudent = isset($coords[0]) ? (float)$coords[0] : 0;
                                $lonStudent = isset($coords[1]) ? (float)$coords[1] : 0;

                                // Haversine distance calculation in PHP
                                $distance = 0;
                                if ($latStudent && $lonStudent) {
                                    $earthRadius = 6371000;
                                    $latDelta = deg2rad($latOff - $latStudent);
                                    $lonDelta = deg2rad($lngOff - $lonStudent);
                                    $a = sin($latDelta / 2) * sin($latDelta / 2) +
                                         cos(deg2rad($latStudent)) * cos(deg2rad($latOff)) *
                                         sin($lonDelta / 2) * sin($lonDelta / 2);
                                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                    $distance = $earthRadius * $c;
                                }
                            @endphp
                            <tr>
                                <td data-label="Tanggal">{{ \Carbon\Carbon::parse($k->tgl_absen)->format('d M Y') }}</td>
                                <td data-label="Siswa" class="fw-semibold text-dark">{{ $k->siswa->nama_lengkap ?? '-' }}</td>
                                <td data-label="Absen Masuk/Keluar">
                                    <span class="text-success"><i class="bi bi-box-arrow-in-right"></i> {{ $k->waktu_checkin ?? '-' }}</span><br>
                                    <span class="text-danger"><i class="bi bi-box-arrow-out-right"></i> {{ $k->waktu_checkout ?? '-' }}</span>
                                </td>
                                <td data-label="Jarak Geofence">
                                    @if($latStudent && $lonStudent)
                                        <span class="fw-bold">{{ number_format($distance, 1) }} m</span><br>
                                        @if($distance <= 100)
                                            <span class="badge bg-success-subtle text-success" style="font-size: 0.7rem;">Valid</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger" style="font-size: 0.7rem;">Luar Batas</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    @if($latStudent && $lonStudent)
                                        <button class="btn btn-outline-dark btn-sm rounded-pill px-2 py-0.5" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#mapModal"
                                            data-student-name="{{ $k->siswa->nama_lengkap }}"
                                            data-student-lat="{{ $latStudent }}"
                                            data-student-lon="{{ $lonStudent }}"
                                            data-office-lat="{{ $latOff }}"
                                            data-office-lon="{{ $lngOff }}"
                                            data-office-name="{{ $nameOff }}"
                                            data-distance="{{ $distance }}">
                                            <i class="bi bi-map"></i> Peta
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">Belum ada log absensi siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Jurnal Laporan Harian Siswa Card -->
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-journal-richtext text-primary me-2"></i> 
                Jurnal Harian {{ $selectedSiswa ? 'Siswa: ' . $selectedSiswa->nama_lengkap : 'Semua Siswa Bimbingan' }}
            </h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm table-responsive-stack datatable" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Aktivitas & Hasil</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanJurnal as $jurnal)
                            <tr>
                                <td data-label="Tanggal">{{ \Carbon\Carbon::parse($jurnal->tgl_laporan)->format('d M Y') }}</td>
                                <td data-label="Siswa" class="fw-semibold text-dark">{{ $jurnal->siswa->nama_lengkap ?? '-' }}</td>
                                <td data-label="Aktivitas & Hasil">
                                    <span class="text-dark d-block fw-medium">{{ Str::limit($jurnal->aktivitas_pekerjaan, 50) }}</span>
                                    <small class="text-muted d-block">Hasil: {{ Str::limit($jurnal->hasil_pekerjaan, 40) }}</small>
                                    <div class="mt-1">
                                        <span class="badge bg-success-subtle text-success" style="font-size: 0.72rem;">Nilai DUDI: {{ $jurnal->nilai_dudi ?? 'Belum' }}</span>
                                        <span class="badge bg-info-subtle text-info" style="font-size: 0.72rem;">Nilai Guru: {{ $jurnal->nilai_guru ?? 'Belum' }}</span>
                                    </div>
                                </td>
                                <td data-label="Lampiran">
                                    @if($jurnal->file_lampiran)
                                        <a href="{{ asset($jurnal->file_lampiran) }}" target="_blank" class="btn btn-outline-dark btn-xs px-2 py-0.5 rounded-pill text-decoration-none">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    @if($jurnal->status === 'approved')
                                        <span class="badge bg-success-subtle text-success">Disetujui</span>
                                    @elseif($jurnal->status === 'rejected')
                                        <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @endif
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    <button class="btn btn-outline-primary btn-sm rounded-pill px-2.5 py-0.5"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reviewModal"
                                        data-id="{{ $jurnal->id_laporan }}"
                                        data-student-name="{{ $jurnal->siswa->nama_lengkap }}"
                                        data-date="{{ \Carbon\Carbon::parse($jurnal->tgl_laporan)->format('d M Y') }}"
                                        data-activity="{{ $jurnal->aktivitas_pekerjaan }}"
                                        data-output="{{ $jurnal->hasil_pekerjaan ?? '-' }}"
                                        data-skills="{{ $jurnal->skill_dipraktikkan ?? '-' }}"
                                        data-skill-tags="{{ $jurnal->skillTags->pluck('nama_aspek')->implode(', ') }}"
                                        data-feedback="{{ $jurnal->feedback_pembimbing }}"
                                        data-status="{{ $jurnal->status ?? 'approved' }}"
                                        data-nilai="{{ $jurnal->nilai_guru }}">
                                        <i class="bi bi-pencil-square"></i> Review
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">Belum ada laporan jurnal harian dari siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FORM INPUT PENILAIAN SIKAP (GURU PEMBIMBING) -->
    <div class="col-md-5">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-award-fill text-success me-2"></i> 
                Penilaian Sikap Siswa
            </h5>

            @if($selectedSiswa && $selectedPenugasan)
                <form action="{{ route('nilai.sikap') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_penugasan_fk" value="{{ $selectedPenugasan->id_penugasan }}">
                    <input type="hidden" name="id_siswa_fk" value="{{ $selectedSiswa->id_siswa }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-2">
                            Siswa: {{ $selectedSiswa->nama_lengkap }} ({{ $selectedSiswa->jurusan }})
                        </label>
                        
                        <div class="border rounded p-3 bg-light">
                            <!-- Nilai Kedisiplinan -->
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-semibold mb-0">Kedisiplinan (1-100)</label>
                                <input type="number" class="form-control form-control-sm bg-white" name="nilai_kedisiplinan" value="{{ $penilaianSikapExisting->nilai_kedisiplinan ?? 80 }}" min="0" max="100" required>
                                <input type="text" class="form-control form-control-sm bg-white mt-1" name="catatan_kedisiplinan" value="{{ $penilaianSikapExisting->catatan_kedisiplinan ?? '' }}" placeholder="Catatan Kedisiplinan...">
                            </div>

                            <!-- Nilai Kerjasama -->
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-semibold mb-0">Kerjasama (1-100)</label>
                                <input type="number" class="form-control form-control-sm bg-white" name="nilai_kerjasama" value="{{ $penilaianSikapExisting->nilai_kerjasama ?? 80 }}" min="0" max="100" required>
                                <input type="text" class="form-control form-control-sm bg-white mt-1" name="catatan_kerjasama" value="{{ $penilaianSikapExisting->catatan_kerjasama ?? '' }}" placeholder="Catatan Kerjasama...">
                            </div>

                            <!-- Nilai Tanggung Jawab -->
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-semibold mb-0">Tanggung Jawab (1-100)</label>
                                <input type="number" class="form-control form-control-sm bg-white" name="nilai_tanggung_jawab" value="{{ $penilaianSikapExisting->nilai_tanggung_jawab ?? 80 }}" min="0" max="100" required>
                                <input type="text" class="form-control form-control-sm bg-white mt-1" name="catatan_tanggung_jawab" value="{{ $penilaianSikapExisting->catatan_tanggung_jawab ?? '' }}" placeholder="Catatan Tanggung Jawab...">
                            </div>

                            <!-- Nilai Inisiatif -->
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-semibold mb-0">Inisiatif (1-100)</label>
                                <input type="number" class="form-control form-control-sm bg-white" name="nilai_inisiatif" value="{{ $penilaianSikapExisting->nilai_inisiatif ?? 80 }}" min="0" max="100" required>
                                <input type="text" class="form-control form-control-sm bg-white mt-1" name="catatan_inisiatif" value="{{ $penilaianSikapExisting->catatan_inisiatif ?? '' }}" placeholder="Catatan Inisiatif...">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-secondary small">Catatan Perkembangan Umum (Sikap)</label>
                        <textarea class="form-control bg-light" name="catatan_umum" rows="2" placeholder="Siswa menunjukkan budi pekerti yang baik..." required>{{ $penilaianSikapExisting->catatan_umum ?? '' }}</textarea>
                    </div>

                    <!-- Status Selection Buttons -->
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <button type="submit" name="status" value="draft" class="btn btn-outline-dark btn-sm w-100 fw-semibold">
                                <i class="bi bi-save"></i> Simpan Draft
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="status" value="finalized" class="btn btn-success btn-sm w-100 fw-bold text-white" onclick="return confirm('Apakah Anda yakin ingin mengunci nilai sikap? Nilai sikap yang difinalisasi akan langsung masuk ke rata-rata rapot.')">
                                <i class="bi bi-check-circle-fill"></i> Finalisasi Nilai
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-person-fill-lock fs-1 text-success mb-3 d-block"></i>
                    <p class="small mb-0">Silakan pilih salah satu **Siswa Bimbingan** di bagian filter di atas untuk menginput penilaian sikap.</p>
                </div>
            @endif
        </div>

        <!-- KUNCI & FINALISASI RAPOR PKL CARD -->
        @if($selectedSiswa && $selectedPenugasan)
            <div class="card card-custom p-4 shadow-sm mb-4 border border-warning">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-award-fill text-warning me-2"></i> 
                    Finalisasi Rapor PKL
                </h5>
                
                <div class="border rounded p-3 bg-light mb-3 small text-dark">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rata Jurnal DU-DI (50%):</span>
                        <strong class="text-primary">{{ number_format($rataJurnalDudi, 1) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rata Jurnal Guru (30%):</span>
                        <strong class="text-success">{{ number_format($rataJurnalGuru, 1) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Nilai Kehadiran (20%):</span>
                        <strong class="text-danger">{{ number_format($nilaiKehadiran, 1) }}</strong>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <strong>Prediksi Nilai Akhir:</strong>
                        <strong class="text-dark fs-6">{{ number_format($prediksiNilaiAkhir, 2) }}</strong>
                    </div>
                </div>

                @if($nilaiAkhirExisting)
                    <div class="alert alert-success border-0 small py-2 mb-0">
                        <i class="bi bi-patch-check-fill me-1"></i> Rapor PKL telah diterbitkan dengan Nilai Akhir <strong>{{ number_format($nilaiAkhirExisting->nilai_akhir_pkl, 2) }}</strong> (Grade: <strong>{{ $nilaiAkhirExisting->grade }}</strong>).
                    </div>
                @else
                    <form action="{{ route('nilai.finalisasi') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_penugasan_fk" value="{{ $selectedPenugasan->id_penugasan }}">
                        <input type="hidden" name="id_siswa_fk" value="{{ $selectedSiswa->id_siswa }}">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary mb-1">Nomor Sertifikat</label>
                            <input type="text" class="form-control form-control-sm bg-light" name="no_sertifikat" placeholder="Contoh: SR-PKL/XII/2026/001" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary mb-1">Catatan/Rekomendasi Rapot</label>
                            <textarea class="form-control form-control-sm bg-light" name="catatan" rows="2" placeholder="Siswa sangat kompeten dan berdedikasi..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-sm fw-bold text-dark" onclick="return confirm('Apakah Anda yakin ingin menerbitkan rapor PKL untuk siswa ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="bi bi-send-fill"></i> Terbitkan & Kunci Rapor PKL
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @endif

        <!-- FORM CATAT KUNJUNGAN INDUSTRI -->
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Catat Kunjungan Industri</h5>
            <form action="{{ route('kunjungan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="id_industri_fk" class="form-label fw-medium text-secondary small">Industri Mitra</label>
                    <select class="form-select bg-light" name="id_industri_fk" required>
                        <option value="">Pilih Industri Mitra</option>
                        @foreach($industriMitra as $ind)
                            <option value="{{ $ind->id_industri }}">{{ $ind->nama_industri }} ({{ $ind->kota }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_kunjungan" class="form-label fw-medium text-secondary small">Tanggal Kunjungan</label>
                    <input type="date" class="form-control bg-light" name="tgl_kunjungan" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label for="catatan_monitoring" class="form-label fw-medium text-secondary small">Catatan Monitoring / Laporan Kunjungan</label>
                    <textarea class="form-control bg-light" name="catatan_monitoring" rows="3" placeholder="Deskripsikan perkembangan siswa dan koordinasi dengan pembimbing lapangan..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto_kunjungan" class="form-label fw-medium text-secondary small">Foto Bukti Kunjungan (Dokumentasi)</label>
                    <input type="file" class="form-control bg-light" name="foto_kunjungan" accept="image/*">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-sm fw-semibold">Simpan Catatan Kunjungan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Map for Attendance Tracking -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Lokasi Detail Presensi Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <!-- Map Container -->
                <div id="modal-map" class="border border-secondary shadow-sm"></div>
                <!-- Info Text -->
                <div id="modal-map-info" class="alert alert-light border mt-3 small text-dark mb-0"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Review Jurnal Harian -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-journal-check text-primary me-1"></i> Review & Nilai Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reviewForm" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="border rounded p-3 bg-light mb-3 small text-dark">
                        <strong>Nama Siswa:</strong> <span id="rev-student-name"></span><br>
                        <strong>Tanggal Jurnal:</strong> <span id="rev-date"></span><br>
                        <hr class="my-2">
                        <strong>Aktivitas Pekerjaan:</strong> 
                        <p class="mb-2 text-secondary" id="rev-activity" style="white-space: pre-wrap;"></p>
                        <strong>Output / Bukti:</strong> 
                        <p class="mb-2 text-secondary" id="rev-output"></p>
                        <strong>Skill Dipraktikkan:</strong> 
                        <div>
                            <span id="rev-skills" class="badge bg-secondary text-white"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nilai Jurnal Ini (1 - 100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control bg-light" name="nilai" id="rev-nilai" min="1" max="100" placeholder="Masukkan nilai dari Guru (1-100)..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Keputusan Verifikasi</label>
                        <select class="form-select bg-light" name="status" id="rev-status" required>
                            <option value="approved">Setujui Jurnal (Approved)</option>
                            <option value="rejected">Tolak & Minta Revisi (Rejected)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Feedback / Catatan Evaluasi</label>
                        <textarea class="form-control bg-light" name="feedback_pembimbing" id="rev-feedback" rows="3" placeholder="Masukkan komentar guru pembimbing jika ada..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark btn-sm">Simpan Review Jurnal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalMap = null;
        var studentMarker = null;
        var officeMarker = null;
        var circleFence = null;

        var mapModalEl = document.getElementById('mapModal');
        mapModalEl.addEventListener('shown.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            var studentName = button.getAttribute('data-student-name');
            var sLat = parseFloat(button.getAttribute('data-student-lat'));
            var sLon = parseFloat(button.getAttribute('data-student-lon'));
            var oLat = parseFloat(button.getAttribute('data-office-lat'));
            var oLon = parseFloat(button.getAttribute('data-office-lon'));
            var oName = button.getAttribute('data-office-name');
            var distance = parseFloat(button.getAttribute('data-distance'));

            // Init map if null
            if (modalMap === null) {
                modalMap = L.map('modal-map').setView([oLat, oLon], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(modalMap);
            } else {
                modalMap.setView([oLat, oLon], 15);
                if (studentMarker) modalMap.removeLayer(studentMarker);
                if (officeMarker) modalMap.removeLayer(officeMarker);
                if (circleFence) modalMap.removeLayer(circleFence);
            }

            // Draw office marker
            officeMarker = L.marker([oLat, oLon]).addTo(modalMap)
                .bindPopup('<b>' + oName + '</b><br>Kantor Penugasan').openPopup();

            // Draw geofence circle (100m)
            circleFence = L.circle([oLat, oLon], {
                color: '#10b981',
                fillColor: '#34d399',
                fillOpacity: 0.15,
                radius: 100
            }).addTo(modalMap);

            // Draw student presence marker
            studentMarker = L.marker([sLat, sLon]).addTo(modalMap)
                .bindPopup('<b>' + studentName + '</b><br>Check-in disini.<br>Jarak: ' + distance.toFixed(1) + ' m').openPopup();

            // Fit bounds to show both markers
            var group = new L.featureGroup([officeMarker, studentMarker]);
            modalMap.fitBounds(group.getBounds().pad(0.15));

            // Populate Info text
            var validity = distance <= 100 
                ? '<span class="text-success fw-bold"><i class="bi bi-patch-check-fill"></i> VALID (Di Dalam Radius Geofence)</span>' 
                : '<span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> DI LUAR RADIUS GEOFENCE (Tidak Valid)</span>';

            document.getElementById('modal-map-info').innerHTML = 
                '<strong>Siswa:</strong> ' + studentName + '<br>' +
                '<strong>Koordinat Check-in:</strong> Lat ' + sLat + ', Lon ' + sLon + '<br>' +
                '<strong>Jarak ke Kantor:</strong> ' + distance.toFixed(1) + ' meter.<br>' +
                '<strong>Status Validasi:</strong> ' + validity;
        });

        // Review Jurnal Modal population
        var reviewModalEl = document.getElementById('reviewModal');
        reviewModalEl.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-student-name');
            var date = button.getAttribute('data-date');
            var activity = button.getAttribute('data-activity');
            var output = button.getAttribute('data-output');
            var skills = button.getAttribute('data-skills');
            var feedback = button.getAttribute('data-feedback') || '';
            var status = button.getAttribute('data-status') || 'approved';
            var nilai = button.getAttribute('data-nilai') || '';

            document.getElementById('rev-student-name').innerText = studentName;
            document.getElementById('rev-date').innerText = date;
            document.getElementById('rev-activity').innerText = activity;
            document.getElementById('rev-output').innerText = output;
            document.getElementById('rev-skills').innerText = skills;
            document.getElementById('rev-feedback').value = feedback;
            document.getElementById('rev-status').value = status;
            document.getElementById('rev-nilai').value = nilai;

            // Set dynamic action URL
            var form = document.getElementById('reviewForm');
            form.setAttribute('action', '/laporan/review/' + id);
        });

        // Client-side file type verification
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                if (this.files.length === 0) return;
                var file = this.files[0];
                var accept = this.getAttribute('accept');
                if (!accept) return;
                
                var fileType = file.type;
                var isValid = false;
                
                if (accept === 'image/*') {
                    if (fileType.startsWith('image/')) {
                        isValid = true;
                    }
                } else {
                    var allowedTypes = accept.split(',');
                    for (var i = 0; i < allowedTypes.length; i++) {
                        var type = allowedTypes[i].trim();
                        if (type === 'image/*') {
                            if (fileType.startsWith('image/')) {
                                isValid = true;
                                break;
                            }
                        } else if (type === 'application/pdf') {
                            if (fileType === 'application/pdf') {
                                isValid = true;
                                break;
                            }
                        }
                    }
                }
                
                if (!isValid) {
                    alert('Format file tidak sesuai! Hanya diperbolehkan format: ' + accept);
                    this.value = ''; // Reset input
                }
            });
        });

        // Universal form submit loading handler
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    setTimeout(function() {
                        submitBtn.disabled = true;
                    }, 0);
                    
                    var text = submitBtn.innerText.trim();
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> ' + text + '...';
                }
            });
        });
    });
</script>
@endsection
