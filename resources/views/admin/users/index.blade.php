@extends('layouts.app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="row mb-3 no-print">
    <div class="col-12">
        <ul class="nav nav-pills bg-white p-2 rounded-3 border shadow-sm">
            <li class="nav-item me-1">
                <a href="{{ route('users.index', ['tab' => 'pembimbing']) }}" 
                   class="nav-link rounded-3 px-4 py-2 small fw-semibold {{ $activeTab === 'pembimbing' ? 'active bg-dark text-white' : 'text-secondary hover-bg-light' }}">
                    <i class="bi bi-person-video3 me-1"></i> Akun Guru Pembimbing
                </a>
            </li>
            <li class="nav-item me-1">
                <a href="{{ route('users.index', ['tab' => 'industri']) }}" 
                   class="nav-link rounded-3 px-4 py-2 small fw-semibold {{ $activeTab === 'industri' ? 'active bg-dark text-white' : 'text-secondary hover-bg-light' }}">
                    <i class="bi bi-building-gear me-1"></i> Akun Pembimbing Industri
                </a>
            </li>
            <li class="nav-item me-1">
                <a href="{{ route('users.index', ['tab' => 'staf']) }}" 
                   class="nav-link rounded-3 px-4 py-2 small fw-semibold {{ $activeTab === 'staf' ? 'active bg-dark text-white' : 'text-secondary hover-bg-light' }}">
                    <i class="bi bi-shield-check me-1"></i> Akun Staf Sekolah & Admin
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index', ['tab' => 'siswa']) }}" 
                   class="nav-link rounded-3 px-4 py-2 small fw-semibold {{ $activeTab === 'siswa' ? 'active bg-dark text-white' : 'text-secondary hover-bg-light' }}">
                    <i class="bi bi-people me-1"></i> Akun Siswa
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="card card-custom p-4 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-1">
                @if($activeTab === 'pembimbing')
                    <i class="bi bi-person-video3 text-primary me-2"></i> Akun Guru Pembimbing Sekolah
                @elseif($activeTab === 'industri')
                    <i class="bi bi-building-gear text-success me-2"></i> Akun Pembimbing Lapangan (Industri)
                @elseif($activeTab === 'staf')
                    <i class="bi bi-shield-check text-danger me-2"></i> Akun Staff & Administrator Sekolah
                @elseif($activeTab === 'siswa')
                    <i class="bi bi-people text-warning me-2"></i> Akun Pengguna Siswa PKL
                @endif
            </h5>
            <p class="text-muted small mb-0">Kelola informasi login, kredensial, dan status akun per kategori peran.</p>
        </div>
        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Akun
        </button>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-stack datatable">
            <thead class="table-light">
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $item)
                    <tr>
                        <td data-label="Nama Pengguna" class="fw-bold text-dark">{{ $item->name }}</td>
                        <td data-label="Username"><code>{{ $item->username }}</code></td>
                        <td data-label="Email">{{ $item->email }}</td>
                        <td data-label="Peran (Role)">
                            @foreach($item->roles as $role)
                                @if($role->name === 'admin')
                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{ $role->name }}</span>
                                @elseif($role->name === 'pembimbing')
                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Guru Pembimbing</span>
                                @elseif($role->name === 'koordinator')
                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Koordinator PKL</span>
                                @elseif($role->name === 'industri')
                                    <span class="badge bg-success-subtle text-success text-uppercase">Instruktur Industri</span>
                                    @if($item->industriDetail)
                                        <br><small class="text-success fw-bold"><i class="bi bi-building"></i> {{ $item->industriDetail->nama_industri }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{ $role->name }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td data-label="Status">
                            @if($item->status === 'aktif')
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td data-label="Catatan" class="text-muted small">{{ $item->catatan ?? '-' }}</td>
                        <td data-label="Aksi" class="text-center">
                            @if($item->id !== auth()->id())
                                <!-- Edit Button -->
                                <button class="btn btn-outline-dark btn-sm rounded-pill px-3 me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-light text-dark rounded-pill px-3 small border">Sedang Digunakan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-1"></i> Buat Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input type="text" class="form-control bg-light" name="name" required placeholder="Contoh: Budi Utomo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Username (untuk Login)</label>
                        <input type="text" class="form-control bg-light" name="username" required placeholder="Contoh: budi_utomo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Email</label>
                        <input type="email" class="form-control bg-light" name="email" required placeholder="Contoh: budi@smkadvance.sch.id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Password</label>
                        <input type="password" class="form-control bg-light" name="password" required placeholder="Minimal 8 karakter">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Peran (Role)</label>
                            <select class="form-select bg-light" name="role" required>
                                <option value="">Pilih Peran</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" 
                                        {{ ($activeTab === 'pembimbing' && $role->name === 'pembimbing') || 
                                           ($activeTab === 'industri' && $role->name === 'industri') || 
                                           ($activeTab === 'siswa' && $role->name === 'siswa') || 
                                           ($activeTab === 'staf' && $role->name === 'koordinator') ? 'selected' : '' }}>
                                        @if($role->name === 'admin')
                                            Administrator
                                        @elseif($role->name === 'pembimbing')
                                            Guru Pembimbing
                                        @elseif($role->name === 'koordinator')
                                            Koordinator PKL
                                        @elseif($role->name === 'industri')
                                            Instruktur Industri
                                        @else
                                            {{ ucfirst($role->name) }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Status</label>
                            <select class="form-select bg-light" name="status" required>
                                <option value="aktif" selected>Aktif</option>
                                <option value="non_aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" id="industriSelectDiv" style="display: none;">
                        <label class="form-label small fw-semibold text-secondary">Perusahaan Mitra (DU-DI) terkait</label>
                        <select class="form-select bg-light" name="id_industri_fk">
                            <option value="">Pilih Perusahaan Mitra (DU-DI)</option>
                            @foreach($industriList as $ind)
                                <option value="{{ $ind->id_industri }}">{{ $ind->nama_industri }} ({{ $ind->kota }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hubungkan akun ini ke perusahaan tempat instruktur bekerja.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan</label>
                        <textarea class="form-control bg-light" name="catatan" rows="2" placeholder="Catatan opsional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark btn-sm">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modals -->
@foreach($users as $item)
    @if($item->id !== auth()->id())
        <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content card-custom p-3 border-0">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Akun: {{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('users.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-3">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light" name="name" value="{{ $item->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Username</label>
                                <input type="text" class="form-control bg-light" name="username" value="{{ $item->username }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Email</label>
                                <input type="email" class="form-control bg-light" name="email" value="{{ $item->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                                <input type="password" class="form-control bg-light" name="password" placeholder="Minimal 8 karakter">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold text-secondary">Peran (Role)</label>
                                    <select class="form-select bg-light" name="role" id="roleEditSelect{{ $item->id }}" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $item->hasRole($role->name) ? 'selected' : '' }}>
                                                @if($role->name === 'admin')
                                                    Administrator
                                                @elseif($role->name === 'pembimbing')
                                                    Guru Pembimbing
                                                @elseif($role->name === 'koordinator')
                                                    Koordinator PKL
                                                @elseif($role->name === 'industri')
                                                    Instruktur Industri
                                                @else
                                                    {{ ucfirst($role->name) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold text-secondary">Status</label>
                                    <select class="form-select bg-light" name="status" required>
                                        <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="non_aktif" {{ $item->status == 'non_aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3" id="industriEditSelectDiv{{ $item->id }}" style="display: none;">
                                <label class="form-label small fw-semibold text-secondary">Perusahaan Mitra (DU-DI) terkait</label>
                                <select class="form-select bg-light" name="id_industri_fk">
                                    <option value="">Pilih Perusahaan Mitra (DU-DI)</option>
                                    @foreach($industriList as $ind)
                                        <option value="{{ $ind->id_industri }}" {{ $item->id_industri_fk == $ind->id_industri ? 'selected' : '' }}>
                                            {{ $ind->nama_industri }} ({{ $ind->kota }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hubungkan instruktur ini ke perusahaan mitranya.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan</label>
                                <textarea class="form-control bg-light" name="catatan" rows="2">{{ $item->catatan }}</textarea>
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
    @endif
@endforeach

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Add Account Handler ---
        var roleSelect = document.querySelector('#addUserModal select[name="role"]');
        var industriDiv = document.getElementById('industriSelectDiv');
        if (roleSelect && industriDiv) {
            function toggleAddIndustri() {
                if (roleSelect.value === 'industri') {
                    industriDiv.style.display = 'block';
                    industriDiv.querySelector('select').setAttribute('required', 'required');
                } else {
                    industriDiv.style.display = 'none';
                    industriDiv.querySelector('select').removeAttribute('required');
                }
            }
            roleSelect.addEventListener('change', toggleAddIndustri);
            toggleAddIndustri(); // Run once initially
        }

        // --- Edit Accounts Handler ---
        @foreach($users as $item)
            @if($item->id !== auth()->id())
                (function() {
                    var roleEdit = document.getElementById('roleEditSelect{{ $item->id }}');
                    var industriEditDiv = document.getElementById('industriEditSelectDiv{{ $item->id }}');
                    if (roleEdit && industriEditDiv) {
                        function toggleEditIndustri() {
                            if (roleEdit.value === 'industri') {
                                industriEditDiv.style.display = 'block';
                                industriEditDiv.querySelector('select').setAttribute('required', 'required');
                            } else {
                                industriEditDiv.style.display = 'none';
                                industriEditDiv.querySelector('select').removeAttribute('required');
                            }
                        }
                        roleEdit.addEventListener('change', toggleEditIndustri);
                        toggleEditIndustri(); // Run once initially
                    }
                })();
            @endif
        @endforeach
    });
</script>
@endsection
@endsection
