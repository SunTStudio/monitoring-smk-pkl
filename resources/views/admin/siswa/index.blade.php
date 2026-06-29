@extends('layouts.app')

@section('title', 'Kelola Siswa')

@section('content')
<div class="card card-custom p-4 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-primary me-2"></i> Manajemen Data Siswa</h5>
        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addSiswaModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Siswa
        </button>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('siswa.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari nama, NISN, kelas, atau jurusan..." value="{{ $search }}">
            <button type="submit" class="btn btn-dark"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-stack">
            <thead class="table-light">
                <tr>
                    <th>NISN / NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas / Jurusan</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $item)
                    <tr>
                        <td data-label="NISN / NIS">
                            <span class="fw-semibold text-dark">{{ $item->nisn }}</span><br>
                            <small class="text-muted">NIS: {{ $item->nis }}</small>
                        </td>
                        <td data-label="Nama Lengkap" class="fw-medium text-dark">{{ $item->nama_lengkap }}</td>
                        <td data-label="Kelas / Jurusan">{{ $item->kelas }} - <span class="badge bg-secondary-subtle text-secondary">{{ $item->jurusan }}</span></td>
                        <td data-label="Kontak">
                            <small>{{ $item->email }}</small><br>
                            <small class="text-muted">{{ $item->no_hp ?? '-' }}</small>
                        </td>
                        <td data-label="Status">
                            @if($item->status === 'aktif')
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                            @elseif($item->status === 'selesai')
                                <span class="badge bg-info-subtle text-info text-capitalize">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td data-label="Aksi" class="text-center">
                            <!-- Edit Button triggers modal -->
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editSiswaModal{{ $item->id_siswa }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('siswa.destroy', $item->id_siswa) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data siswa ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $siswa->appends(['search' => $search])->links() }}
    </div>
</div>

<!-- Add Siswa Modal -->
<div class="modal fade" id="addSiswaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-1"></i> Tambah Data Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" name="name" placeholder="Nama Lengkap Siswa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Email</label>
                            <input type="email" class="form-control bg-light" name="email" placeholder="siswa@example.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">NISN</label>
                            <input type="text" class="form-control bg-light" name="nisn" placeholder="Nomor NISN" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">NIS</label>
                            <input type="text" class="form-control bg-light" name="nis" placeholder="Nomor NIS" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kelas</label>
                            <input type="text" class="form-control bg-light" name="kelas" placeholder="XI / XII" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Jurusan</label>
                            <select class="form-select bg-light" name="jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="RPL">RPL</option>
                                <option value="TKJ">TKJ</option>
                                <option value="MM">Multimedia</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nomor HP</label>
                            <input type="text" class="form-control bg-light" name="no_hp" placeholder="No HP/WhatsApp">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kata Sandi Default</label>
                            <input type="password" class="form-control bg-light" name="password" placeholder="Password akun login" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Alamat Rumah</label>
                            <textarea class="form-control bg-light" name="alamat" rows="2" placeholder="Alamat lengkap rumah..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark btn-sm">Daftarkan Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Siswa Modals (Placed at bottom, outside the table structure) -->
@foreach($siswa as $item)
    <div class="modal fade" id="editSiswaModal{{ $item->id_siswa }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Siswa: {{ $item->nama_lengkap }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('siswa.update', $item->id_siswa) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light" name="name" value="{{ $item->nama_lengkap }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Email</label>
                                <input type="email" class="form-control bg-light" name="email" value="{{ $item->email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">NISN</label>
                                <input type="text" class="form-control bg-light" name="nisn" value="{{ $item->nisn }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">NIS</label>
                                <input type="text" class="form-control bg-light" name="nis" value="{{ $item->nis }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Kelas</label>
                                <input type="text" class="form-control bg-light" name="kelas" value="{{ $item->kelas }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Jurusan</label>
                                <select class="form-select bg-light" name="jurusan" required>
                                    <option value="RPL" {{ $item->jurusan == 'RPL' ? 'selected' : '' }}>RPL</option>
                                    <option value="TKJ" {{ $item->jurusan == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                                    <option value="MM" {{ $item->jurusan == 'MM' ? 'selected' : '' }}>Multimedia</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Status Siswa</label>
                                <select class="form-select bg-light" name="status" required>
                                    <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dropout" {{ $item->status == 'dropout' ? 'selected' : '' }}>Dropout</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Nomor HP</label>
                                <input type="text" class="form-control bg-light" name="no_hp" value="{{ $item->no_hp }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                                <input type="password" class="form-control bg-light" name="password">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Alamat Rumah</label>
                                <textarea class="form-control bg-light" name="alamat" rows="2">{{ $item->alamat }}</textarea>
                            </div>
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

@endsection
