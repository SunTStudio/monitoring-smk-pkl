@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom p-4 shadow-sm bg-dark text-white border-0">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary p-3 rounded-3 text-white me-4">
                    <i class="bi bi-speedometer2 fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Dashboard Admin & Koordinator PKL</h4>
                    <p class="mb-0 text-white-50">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Berikut adalah data pantauan PKL saat ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stat 1 -->
    <div class="col-md-3">
        <div class="card card-custom p-3 border-start border-primary border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Siswa Terdaftar</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $siswaCount }}</h3>
                </div>
                <div class="fs-1 text-primary"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-md-3">
        <div class="card card-custom p-3 border-start border-success border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Siswa Aktif PKL</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $siswaAktifCount }}</h3>
                </div>
                <div class="fs-1 text-success"><i class="bi bi-person-check-fill"></i></div>
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-md-3">
        <div class="card card-custom p-3 border-start border-warning border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Mitra Industri DU-DI</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $industriCount }}</h3>
                </div>
                <div class="fs-1 text-warning"><i class="bi bi-building-fill"></i></div>
            </div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="col-md-3">
        <div class="card card-custom p-3 border-start border-danger border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Belum Ditempatkan</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $belumDitempatkanCount }}</h3>
                </div>
                <div class="fs-1 text-danger"><i class="bi bi-person-x-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Menu Management Cards -->
    <div class="col-md-8">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-gear-fill text-secondary me-2"></i> Pilihan Manajemen Data Master</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border border-light p-3 text-center rounded-3 bg-light-subtle h-100 hover-shadow">
                        <i class="bi bi-people text-primary fs-2 mb-2"></i>
                        <h6 class="fw-bold mb-1">Data Siswa</h6>
                        <p class="text-muted small mb-2">Kelola siswa, kelas, & jurusan</p>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 mt-auto">Kelola Siswa</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border border-light p-3 text-center rounded-3 bg-light-subtle h-100 hover-shadow">
                        <i class="bi bi-building text-success fs-2 mb-2"></i>
                        <h6 class="fw-bold mb-1">Mitra Industri</h6>
                        <p class="text-muted small mb-2">Kelola lokasi geofencing DU-DI</p>
                        <a href="{{ route('industri.index') }}" class="btn btn-outline-success btn-sm rounded-pill w-100 mt-auto">Kelola Industri</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border border-light p-3 text-center rounded-3 bg-light-subtle h-100 hover-shadow">
                        <i class="bi bi-journal-check text-warning fs-2 mb-2"></i>
                        <h6 class="fw-bold mb-1">Alokasi Penugasan</h6>
                        <p class="text-muted small mb-2">Plotting siswa, guru & DU-DI</p>
                        <a href="{{ route('penugasan.index') }}" class="btn btn-outline-warning btn-sm rounded-pill w-100 text-dark mt-auto">Kelola Alokasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="col-md-4">
        <div class="card card-custom p-4 shadow-sm mb-4 h-100">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i> Info Cepat Sistem</h5>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>Versi Aplikasi</span>
                    <span class="badge bg-light text-dark">v1.0.0-beta</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>Driver Database</span>
                    <span class="badge bg-success">MySQL</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>Spatie Roles</span>
                    <span class="badge bg-dark">5 Terdaftar</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
