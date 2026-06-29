@extends('layouts.app')

@section('title', 'Pembimbing Dashboard')

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

<div class="row">
    <!-- Siswa Bimbingan -->
    <div class="col-md-8">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people-fill text-primary me-2"></i> Siswa Bimbingan Anda</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Kelas/Jurusan</th>
                            <th>Industri Mitra</th>
                            <th>Status PKL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Muhammad Rayhan</td>
                            <td>XII - RPL</td>
                            <td>PT ABC Technology</td>
                            <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Aisyah Putri</td>
                            <td>XII - RPL</td>
                            <td>PT XYZ Indonesia</td>
                            <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Log Kunjungan Industri Form -->
    <div class="col-md-4">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Catat Kunjungan Industri</h5>
            <form action="{{ route('kunjungan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="id_industri_fk" class="form-label fw-medium text-secondary">Industri</label>
                    <select class="form-select bg-light" name="id_industri_fk" required>
                        <option value="">Pilih Industri Mitra</option>
                        <option value="1">PT ABC Technology</option>
                        <option value="2">PT XYZ Indonesia</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_kunjungan" class="form-label fw-medium text-secondary">Tanggal</label>
                    <input type="date" class="form-control bg-light" name="tgl_kunjungan" required>
                </div>
                <div class="mb-3">
                    <label for="catatan_monitoring" class="form-label fw-medium text-secondary">Catatan Monitoring</label>
                    <textarea class="form-control bg-light" name="catatan_monitoring" rows="3" placeholder="Hasil kunjungan..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto_kunjungan" class="form-label fw-medium text-secondary">Foto Kunjungan</label>
                    <input type="file" class="form-control bg-light" name="foto_kunjungan">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-sm fw-semibold">Simpan Kunjungan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
