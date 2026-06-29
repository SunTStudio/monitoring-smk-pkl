@extends('layouts.app')

@section('title', 'Alokasi Penugasan')

@section('content')
<div class="card card-custom p-4 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-journal-check text-primary me-2"></i> Alokasi & Penugasan PKL Siswa</h5>
        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addPenugasanModal">
            <i class="bi bi-plus-circle me-1"></i> Buat Alokasi
        </button>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('penugasan.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari nama siswa, industri, atau guru pembimbing..." value="{{ $search }}">
            <button type="submit" class="btn btn-dark"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Siswa</th>
                    <th>Tempat Industri PKL</th>
                    <th>Guru Pembimbing Sekolah</th>
                    <th>Pembimbing Lapangan (Industri)</th>
                    <th>Periode / Durasi</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penugasan as $item)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark">{{ $item->siswa->nama_lengkap ?? '-' }}</span><br>
                            <small class="text-muted">Kelas: {{ $item->siswa->kelas ?? '-' }} ({{ $item->siswa->jurusan ?? '-' }})</small>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $item->industri->nama_industri ?? '-' }}</span><br>
                            <small class="text-muted">{{ $item->industri->kota ?? '-' }}</small>
                        </td>
                        <td>
                            <span class="fw-medium text-secondary">{{ $item->pembimbingSekolah->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="fw-medium text-secondary">{{ $item->pembimbingIndustri->name ?? '-' }}</span><br>
                            <small class="text-muted">Lapangan: {{ $item->pembimbing_industri ?? '-' }}</small>
                        </td>
                        <td>
                            <small class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($item->tgl_mulai_pkl)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai_pkl)->format('d M Y') }}</small><br>
                            <span class="badge bg-primary-subtle text-primary">{{ $item->durasi_hari ?? '-' }} Hari</span>
                        </td>
                        <td>
                            @if($item->status === 'aktif')
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                            @elseif($item->status === 'selesai')
                                <span class="badge bg-info-subtle text-info text-capitalize">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Edit Button -->
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editPenugasanModal{{ $item->id_penugasan }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <!-- Delete Form -->
                            <form action="{{ route('penugasan.destroy', $item->id_penugasan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin membatalkan/menghapus alokasi penugasan ini?')">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada alokasi penugasan PKL siswa ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $penugasan->appends(['search' => $search])->links() }}
    </div>
</div>

<!-- Add Penugasan Modal -->
<div class="modal fade" id="addPenugasanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-1"></i> Buat Alokasi Penugasan PKL Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penugasan.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Pilih Siswa PKL (Bisa Centang Banyak)</label>
                            <div class="border rounded bg-light p-2" style="max-height: 110px; overflow-y: auto;">
                                @foreach($siswa as $s)
                                    <div class="form-check small mb-1">
                                        <input class="form-check-input" type="checkbox" name="id_siswa_fk[]" value="{{ $s->id_siswa }}" id="siswaCheck{{ $s->id_siswa }}">
                                        <label class="form-check-label text-dark" for="siswaCheck{{ $s->id_siswa }}">
                                            {{ $s->nama_lengkap }} <span class="text-muted" style="font-size: 0.75rem;">({{ $s->kelas }} - {{ $s->jurusan }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted" style="font-size: 0.75rem;">Centang satu atau beberapa siswa yang akan ditempatkan.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Industri Tempat PKL</label>
                            <select class="form-select bg-light" name="id_industri_fk" required>
                                <option value="">Pilih Industri</option>
                                @foreach($industri as $i)
                                    <option value="{{ $i->id_industri }}">{{ $i->nama_industri }} ({{ $i->kota }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Guru Pembimbing Sekolah</label>
                            <select class="form-select bg-light" name="id_pembimbing_fk" required>
                                <option value="">Pilih Guru</option>
                                @foreach($pembimbing as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Akun Pembimbing Industri</label>
                            <select class="form-select bg-light" name="id_pengguna_industri_fk">
                                <option value="">Pilih Akun Industri</option>
                                @foreach($pembimbingIndustri as $pi)
                                    <option value="{{ $pi->id }}">{{ $pi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Tanggal Mulai PKL</label>
                            <input type="date" class="form-control bg-light" name="tgl_mulai_pkl" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Tanggal Selesai PKL</label>
                            <input type="date" class="form-control bg-light" name="tgl_selesai_pkl" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Pembimbing Lapangan (DU-DI)</label>
                            <input type="text" class="form-control bg-light" name="pembimbing_industri" placeholder="Contoh: Pak Budi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Divisi / Departemen</label>
                            <input type="text" class="form-control bg-light" name="divisi_departemen" placeholder="Contoh: Software Engineering">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Lokasi Kerja</label>
                            <input type="text" class="form-control bg-light" name="lokasi_kerja" placeholder="Contoh: Main Office / WFH">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Status</label>
                            <select class="form-select bg-light" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Batal</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Catatan Tambahan</label>
                            <textarea class="form-control bg-light" name="catatan" rows="2" placeholder="Catatan opsional..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark btn-sm">Buat Penugasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Penugasan Modals (Placed at bottom, outside the table structure) -->
@foreach($penugasan as $item)
    <div class="modal fade" id="editPenugasanModal{{ $item->id_penugasan }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Penugasan: {{ $item->siswa->nama_lengkap ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penugasan.update', $item->id_penugasan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Siswa PKL</label>
                                <select class="form-select bg-light" name="id_siswa_fk" required>
                                    @foreach($allSiswa as $s)
                                        <option value="{{ $s->id_siswa }}" {{ $item->id_siswa_fk == $s->id_siswa ? 'selected' : '' }}>{{ $s->nama_lengkap }} ({{ $s->kelas }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Industri Tempat PKL</label>
                                <select class="form-select bg-light" name="id_industri_fk" required>
                                    @foreach($industri as $i)
                                        <option value="{{ $i->id_industri }}" {{ $item->id_industri_fk == $i->id_industri ? 'selected' : '' }}>{{ $i->nama_industri }} ({{ $i->kota }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Guru Pembimbing Sekolah</label>
                                <select class="form-select bg-light" name="id_pembimbing_fk" required>
                                    @foreach($pembimbing as $p)
                                        <option value="{{ $p->id }}" {{ $item->id_pembimbing_fk == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Akun Pembimbing Industri</label>
                                <select class="form-select bg-light" name="id_pengguna_industri_fk">
                                    <option value="">Pilih Akun Industri</option>
                                    @foreach($pembimbingIndustri as $pi)
                                        <option value="{{ $pi->id }}" {{ $item->id_pengguna_industri_fk == $pi->id ? 'selected' : '' }}>{{ $pi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Tanggal Mulai PKL</label>
                                <input type="date" class="form-control bg-light" name="tgl_mulai_pkl" value="{{ $item->tgl_mulai_pkl }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Tanggal Selesai PKL</label>
                                <input type="date" class="form-control bg-light" name="tgl_selesai_pkl" value="{{ $item->tgl_selesai_pkl }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Nama Pembimbing Lapangan (DU-DI)</label>
                                <input type="text" class="form-control bg-light" name="pembimbing_industri" value="{{ $item->pembimbing_industri }}" placeholder="Contoh: Pak Budi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Divisi / Departemen</label>
                                <input type="text" class="form-control bg-light" name="divisi_departemen" value="{{ $item->divisi_departemen }}" placeholder="Contoh: IT Support">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Lokasi Kerja</label>
                                <input type="text" class="form-control bg-light" name="lokasi_kerja" value="{{ $item->lokasi_kerja }}" placeholder="Contoh: Gedung A / Cabang">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Status Penugasan</label>
                                <select class="form-select bg-light" name="status" required>
                                    <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ $item->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                    <option value="on_leave" {{ $item->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Catatan Tambahan</label>
                                <textarea class="form-control bg-light" name="catatan" rows="2">{{ $item->catatan }}</textarea>
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
