@extends('layouts.app')

@section('title', 'Kelola Kelas')

@section('content')
<div class="card card-custom p-4 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-folder-fill text-warning me-2"></i> Manajemen Data Kelas</h5>
        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addKelasModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kelas
        </button>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div class="alert alert-success border-start border-success border-4 py-2 px-3 small mb-4">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-start border-danger border-4 py-2 px-3 small mb-4">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
        </div>
    @endif

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('kelas.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-7">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari nama kelas, jurusan, atau keterangan..." value="{{ $search }}">
                    <button type="submit" class="btn btn-dark"><i class="bi bi-search"></i> Cari</button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="tahun_ajaran" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="">-- Semua Tahun Ajaran --</option>
                    @foreach($tahunAjaranList as $t)
                        <option value="{{ $t }}" {{ $selectedTahun == $t ? 'selected' : '' }}>Tahun Ajaran {{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                @if($search || $selectedTahun)
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline-danger w-100 fw-semibold">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-stack datatable">
            <thead class="table-light">
                <tr>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Tahun Ajaran</th>
                    <th>Keterangan</th>
                    <th class="text-center">Jumlah Siswa</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $item)
                    <tr>
                        <td data-label="Nama Kelas" class="fw-bold text-dark">{{ $item->nama_kelas }}</td>
                        <td data-label="Jurusan">
                            <span class="badge bg-secondary-subtle text-secondary">{{ $item->jurusan }}</span>
                        </td>
                        <td data-label="Tahun Ajaran" class="fw-semibold text-dark">{{ $item->tahun_ajaran }}</td>
                        <td data-label="Keterangan" class="text-muted small">{{ $item->keterangan ?? '-' }}</td>
                        <td data-label="Jumlah Siswa" class="text-center">
                            <span class="badge bg-dark rounded-pill">{{ $item->siswa->count() }} Siswa</span>
                        </td>
                        <td data-label="Aksi" class="text-center">
                            <!-- Lihat Siswa Button -->
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewSiswaModal{{ $item->id_kelas }}">
                                <i class="bi bi-people"></i> Siswa
                            </button>
                            <!-- Edit Button -->
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editKelasModal{{ $item->id_kelas }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('kelas.destroy', $item->id_kelas) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data kelas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Add Kelas Modal -->
<div class="modal fade" id="addKelasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-1"></i> Tambah Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Kelas</label>
                        <input type="text" class="form-control bg-light" name="nama_kelas" placeholder="Contoh: XII - RPL 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Jurusan</label>
                        <select class="form-select bg-light" name="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="TKJ">Teknik Komputer Jaringan (TKJ)</option>
                            <option value="Kimia">Teknik Kimia (Kimia)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Tahun Ajaran</label>
                        <select class="form-select bg-light" name="tahun_ajaran" required>
                            <option value="2022/2023">2022/2023</option>
                            <option value="2023/2024">2023/2024</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2025/2026" selected>2025/2026</option>
                            <option value="2026/2027">2026/2027</option>
                            <option value="2027/2028">2027/2028</option>
                            <option value="2028/2029">2028/2029</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Keterangan</label>
                        <textarea class="form-control bg-light" name="keterangan" rows="2" placeholder="Catatan kelas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark btn-sm">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Kelas Modals -->
@foreach($kelas as $item)
    <div class="modal fade" id="editKelasModal{{ $item->id_kelas }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Kelas: {{ $item->nama_kelas }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.update', $item->id_kelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Kelas</label>
                            <input type="text" class="form-control bg-light" name="nama_kelas" value="{{ $item->nama_kelas }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Jurusan</label>
                            <select class="form-select bg-light" name="jurusan" required>
                                <option value="RPL" {{ $item->jurusan == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="TKJ" {{ $item->jurusan == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan (TKJ)</option>
                                <option value="Kimia" {{ $item->jurusan == 'Kimia' ? 'selected' : '' }}>Teknik Kimia (Kimia)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Tahun Ajaran</label>
                            <select class="form-select bg-light" name="tahun_ajaran" required>
                                <option value="2022/2023" {{ $item->tahun_ajaran == '2022/2023' ? 'selected' : '' }}>2022/2023</option>
                                <option value="2023/2024" {{ $item->tahun_ajaran == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                                <option value="2024/2025" {{ $item->tahun_ajaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                <option value="2025/2026" {{ $item->tahun_ajaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                                <option value="2026/2027" {{ $item->tahun_ajaran == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                                <option value="2027/2028" {{ $item->tahun_ajaran == '2027/2028' ? 'selected' : '' }}>2027/2028</option>
                                <option value="2028/2029" {{ $item->tahun_ajaran == '2028/2029' ? 'selected' : '' }}>2028/2029</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Keterangan</label>
                            <textarea class="form-control bg-light" name="keterangan" rows="2">{{ $item->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-dark btn-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- View Siswa Modals -->
@foreach($kelas as $item)
    <div class="modal fade" id="viewSiswaModal{{ $item->id_kelas }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Daftar Siswa - Kelas {{ $item->nama_kelas }} ({{ $item->tahun_ajaran }})
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    @if($item->siswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>NISN / NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Status PKL</th>
                                        <th>Rapor PKL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->siswa as $siswa)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $siswa->nisn }}</span><br>
                                                <small class="text-muted">NIS: {{ $siswa->nis }}</small>
                                            </td>
                                            <td class="fw-medium text-dark">{{ $siswa->nama_lengkap }}</td>
                                            <td><small>{{ $siswa->email }}</small></td>
                                            <td><small>{{ $siswa->no_hp ?? '-' }}</small></td>
                                            <td>
                                                @if($siswa->status === 'aktif')
                                                    <span class="badge bg-success-subtle text-success text-capitalize">{{ $siswa->status }}</span>
                                                @elseif($siswa->status === 'selesai')
                                                    <span class="badge bg-info-subtle text-info text-capitalize">{{ $siswa->status }}</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $siswa->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($siswa->nilaiAkhir->count() > 0)
                                                    <a href="{{ route('nilai.cetak', $siswa->id_siswa) }}" target="_blank" class="btn btn-dark btn-xs rounded-pill px-2" style="font-size: 0.75rem;">
                                                        <i class="bi bi-printer"></i> Cetak
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Belum Terbit</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada data siswa terdaftar di kelas ini.
                        </div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
