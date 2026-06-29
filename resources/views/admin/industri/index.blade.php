@extends('layouts.app')

@section('title', 'Kelola Industri')

@section('styles')
<!-- Leaflet Maps CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .map-container {
        height: 180px;
        z-index: 1;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="card card-custom p-4 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-building text-primary me-2"></i> Manajemen Mitra Industri (DU-DI)</h5>
        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addIndustriModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Industri
        </button>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('industri.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari nama industri, jenis, kota, atau kontak..." value="{{ $search }}">
            <button type="submit" class="btn btn-dark"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle table-responsive-stack datatable">
            <thead class="table-light">
                <tr>
                    <th>Nama Industri</th>
                    <th>Bidang / Alamat</th>
                    <th>Kontak Person</th>
                    <th>Kuota PKL</th>
                    <th>Koordinat GPS (Geofencing)</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($industri as $item)
                    <tr>
                        <td data-label="Nama Industri" class="fw-bold text-dark">{{ $item->nama_industri }}</td>
                        <td data-label="Bidang / Alamat">
                            <span class="badge bg-secondary-subtle text-secondary mb-1">{{ $item->jenis_industri ?? '-' }}</span><br>
                            <small class="text-muted">{{ $item->alamat_lengkap }}, {{ $item->kota }}</small>
                        </td>
                        <td data-label="Kontak Person">
                            <span class="fw-medium">{{ $item->nama_kontak_person ?? '-' }}</span><br>
                            <small class="text-muted">{{ $item->no_hp_kontak ?? '-' }}</small>
                        </td>
                        <td data-label="Kuota PKL" class="fw-bold text-primary">{{ $item->kapasitas_siswa }} Siswa</td>
                        <td data-label="Koordinat GPS">
                            @if($item->latitude && $item->longitude)
                                <small class="text-success"><i class="bi bi-geo-alt-fill"></i> Terdaftar</small><br>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $item->latitude }}, {{ $item->longitude }}</small>
                            @else
                                <small class="text-danger"><i class="bi bi-geo-alt"></i> Belum Di-set</small>
                            @endif
                        </td>
                        <td data-label="Status">
                            @if($item->status === 'aktif')
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td data-label="Aksi" class="text-center">
                            <!-- Lihat Siswa Button -->
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewSiswaModal{{ $item->id_industri }}">
                                <i class="bi bi-people"></i> Siswa
                            </button>
                            <!-- Edit Button -->
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editIndustriModal{{ $item->id_industri }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <!-- Delete Form -->
                            <form action="{{ route('industri.destroy', $item->id_industri) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data industri ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data industri ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Add Industri Modal -->
<div class="modal fade" id="addIndustriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-custom p-3 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-1"></i> Tambah Data Industri Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('industri.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Industri</label>
                            <input type="text" class="form-control bg-light" name="nama_industri" placeholder="Nama Perusahaan / DU-DI" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Bidang/Jenis Industri</label>
                            <input type="text" class="form-control bg-light" name="jenis_industri" placeholder="IT, Elektronik, Manufaktur, dll.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kontak Person (Humas/HRD)</label>
                            <input type="text" class="form-control bg-light" name="nama_kontak_person" placeholder="Nama humas mitra">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">No HP Kontak</label>
                            <input type="text" class="form-control bg-light" name="no_hp_kontak" placeholder="No HP/WhatsApp Humas">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kapasitas Kuota Siswa</label>
                            <input type="number" class="form-control bg-light" name="kapasitas_siswa" value="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Latitude GPS</label>
                            <input type="text" class="form-control bg-light" name="latitude" id="add-lat" placeholder="Contoh: -6.200000" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Longitude GPS</label>
                            <input type="text" class="form-control bg-light" name="longitude" id="add-lon" placeholder="Contoh: 106.816666" required>
                        </div>

                        <!-- Interactive Map Search & Container for Add -->
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Cari Lokasi / Alamat di Peta</label>
                            <div class="input-group mb-2">
                                <input type="text" id="add-map-search" class="form-control form-control-sm bg-light" placeholder="Ketik nama tempat, jalan, atau daerah (cth: Tunjungan Plaza)...">
                                <button class="btn btn-outline-dark btn-sm" type="button" id="add-map-search-btn"><i class="bi bi-search"></i> Cari</button>
                            </div>
                            <div id="add-map" class="map-container border border-secondary shadow-sm mb-1"></div>
                            <small class="form-text text-muted" style="font-size: 0.75rem;">Anda bisa mencari alamat di atas ATAU klik/geser marker pada peta untuk menandai posisi kantor.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kota</label>
                            <input type="text" class="form-control bg-light" name="kota" placeholder="Surabaya/Jakarta">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Status Mitra</label>
                            <select class="form-select bg-light" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="non_aktif">Non-Aktif</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                            <textarea class="form-control bg-light" name="alamat_lengkap" rows="2" placeholder="Alamat kantor lengkap..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark btn-sm">Daftarkan Industri</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Industri Modals (Placed at bottom, outside the table structure) -->
@foreach($industri as $item)
    <div class="modal fade" id="editIndustriModal{{ $item->id_industri }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Industri: {{ $item->nama_industri }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('industri.update', $item->id_industri) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Nama Industri</label>
                                <input type="text" class="form-control bg-light" name="nama_industri" value="{{ $item->nama_industri }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Bidang/Jenis Industri</label>
                                <input type="text" class="form-control bg-light" name="jenis_industri" value="{{ $item->jenis_industri }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Kontak Person (Humas/HRD)</label>
                                <input type="text" class="form-control bg-light" name="nama_kontak_person" value="{{ $item->nama_kontak_person }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">No HP Kontak</label>
                                <input type="text" class="form-control bg-light" name="no_hp_kontak" value="{{ $item->no_hp_kontak }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Kapasitas Kuota Siswa</label>
                                <input type="number" class="form-control bg-light" name="kapasitas_siswa" value="{{ $item->kapasitas_siswa }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Latitude GPS</label>
                                <input type="text" class="form-control bg-light" name="latitude" value="{{ $item->latitude }}" placeholder="Contoh: -6.200000" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Longitude GPS</label>
                                <input type="text" class="form-control bg-light" name="longitude" value="{{ $item->longitude }}" placeholder="Contoh: 106.816666" required>
                            </div>

                            <!-- Interactive Map Search & Container for Edit -->
                            <div class="col-12 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Cari Lokasi / Alamat di Peta</label>
                                <div class="input-group mb-2">
                                    <input type="text" id="edit-map-search{{ $item->id_industri }}" class="form-control form-control-sm bg-light" placeholder="Ketik nama tempat, jalan, atau daerah...">
                                    <button class="btn btn-outline-dark btn-sm edit-search-btn" type="button" data-id="{{ $item->id_industri }}"><i class="bi bi-search"></i> Cari</button>
                                </div>
                                <div id="edit-map{{ $item->id_industri }}" class="map-container border border-secondary shadow-sm mb-1 edit-map-container" data-id="{{ $item->id_industri }}" data-lat="{{ $item->latitude ?? -6.200000 }}" data-lon="{{ $item->longitude ?? 106.816666 }}"></div>
                                <small class="form-text text-muted" style="font-size: 0.75rem;">Klik langsung di peta atau cari alamat di atas untuk memperbarui koordinat GPS otomatis.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Kota</label>
                                <input type="text" class="form-control bg-light" name="kota" value="{{ $item->kota }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Status Mitra</label>
                                <select class="form-select bg-light" name="status" required>
                                    <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non_aktif" {{ $item->status == 'non_aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    <option value="archived" {{ $item->status == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                                <textarea class="form-control bg-light" name="alamat_lengkap" rows="2">{{ $item->alamat_lengkap }}</textarea>
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

<!-- View Siswa Modals -->
@foreach($industri as $item)
    <div class="modal fade" id="viewSiswaModal{{ $item->id_industri }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Daftar Siswa PKL - {{ $item->nama_industri }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    @if($item->penugasan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas / Jurusan</th>
                                        <th>Periode PKL</th>
                                        <th>Status PKL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->penugasan as $p)
                                        @if($p->siswa)
                                            <tr>
                                                <td class="fw-medium text-dark">{{ $p->siswa->nama_lengkap }}</td>
                                                <td>{{ $p->siswa->kelas }} - {{ $p->siswa->jurusan }}</td>
                                                <td>
                                                    <small class="fw-semibold">
                                                        {{ \Carbon\Carbon::parse($p->tgl_mulai_pkl)->translatedFormat('d M Y') }} s/d 
                                                        {{ \Carbon\Carbon::parse($p->tgl_selesai_pkl)->translatedFormat('d M Y') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if($p->status === 'aktif')
                                                        <span class="badge bg-success-subtle text-success text-capitalize">{{ $p->status }}</span>
                                                    @elseif($p->status === 'selesai')
                                                        <span class="badge bg-info-subtle text-info text-capitalize">{{ $p->status }}</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $p->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada siswa PKL yang ditempatkan di mitra industri ini.
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

@section('scripts')
<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var defaultLat = -6.200000;
        var defaultLng = 106.816666;

        // Helper function for Reverse Geocoding
        function reverseGeocode(lat, lng, textarea) {
            textarea.value = 'Mencari alamat...';
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        textarea.value = data.display_name;
                    } else {
                        textarea.value = '';
                    }
                })
                .catch(err => {
                    console.error(err);
                    textarea.value = '';
                });
        }

        // ------------------------------------------
        // 1. PETA MODAL TAMBAH INDUSTRI
        // ------------------------------------------
        var addMap = null;
        var addMarker = null;
        var addModalEl = document.getElementById('addIndustriModal');

        addModalEl.addEventListener('shown.bs.modal', function () {
            if (addMap === null) {
                // Ambil koordinat awal dari input jika ada
                var latInput = parseFloat(document.getElementById('add-lat').value) || defaultLat;
                var lonInput = parseFloat(document.getElementById('add-lon').value) || defaultLng;

                addMap = L.map('add-map').setView([latInput, lonInput], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(addMap);

                addMarker = L.marker([latInput, lonInput], {
                    draggable: true
                }).addTo(addMap);

                // Map click
                addMap.on('click', function(e) {
                    addMarker.setLatLng(e.latlng);
                    updateAddInputs(e.latlng.lat, e.latlng.lng);
                    reverseGeocode(e.latlng.lat, e.latlng.lng, addModalEl.querySelector('textarea[name="alamat_lengkap"]'));
                });

                // Marker drag
                addMarker.on('dragend', function(e) {
                    var position = addMarker.getLatLng();
                    updateAddInputs(position.lat, position.lng);
                    reverseGeocode(position.lat, position.lng, addModalEl.querySelector('textarea[name="alamat_lengkap"]'));
                });
            } else {
                addMap.invalidateSize();
            }
        });

        function updateAddInputs(lat, lng) {
            document.getElementById('add-lat').value = lat.toFixed(6);
            document.getElementById('add-lon').value = lng.toFixed(6);
        }

        // Search Nominatim for Add Modal
        document.getElementById('add-map-search-btn').addEventListener('click', function() {
            var query = document.getElementById('add-map-search').value;
            if (!query) return;

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var lat = parseFloat(data[0].lat);
                        var lon = parseFloat(data[0].lon);

                        addMap.setView([lat, lon], 15);
                        addMarker.setLatLng([lat, lon]);
                        updateAddInputs(lat, lon);
                        addModalEl.querySelector('textarea[name="alamat_lengkap"]').value = data[0].display_name;
                    } else {
                        alert('Alamat tidak ditemukan!');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menghubungi layanan peta.');
                });
        });


        // ------------------------------------------
        // 2. PETA MODAL EDIT INDUSTRI
        // ------------------------------------------
        var editMaps = {};
        var editMarkers = {};

        var editModalEls = document.querySelectorAll('.modal[id^="editIndustriModal"]');
        editModalEls.forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function(event) {
                var mapContainer = modal.querySelector('.edit-map-container');
                var id = mapContainer.getAttribute('data-id');
                var lat = parseFloat(modal.querySelector('input[name="latitude"]').value) || defaultLat;
                var lon = parseFloat(modal.querySelector('input[name="longitude"]').value) || defaultLng;

                if (!editMaps[id]) {
                    editMaps[id] = L.map('edit-map' + id).setView([lat, lon], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(editMaps[id]);

                    editMarkers[id] = L.marker([lat, lon], {
                        draggable: true
                    }).addTo(editMaps[id]);

                    // Map Click
                    editMaps[id].on('click', function(e) {
                        editMarkers[id].setLatLng(e.latlng);
                        updateEditInputs(modal, e.latlng.lat, e.latlng.lng);
                        reverseGeocode(e.latlng.lat, e.latlng.lng, modal.querySelector('textarea[name="alamat_lengkap"]'));
                    });

                    // Marker Drag
                    editMarkers[id].on('dragend', function(e) {
                        var position = editMarkers[id].getLatLng();
                        updateEditInputs(modal, position.lat, position.lng);
                        reverseGeocode(position.lat, position.lng, modal.querySelector('textarea[name="alamat_lengkap"]'));
                    });
                } else {
                    editMaps[id].invalidateSize();
                }
            });
        });

        function updateEditInputs(modal, lat, lng) {
            modal.querySelector('input[name="latitude"]').value = lat.toFixed(6);
            modal.querySelector('input[name="longitude"]').value = lng.toFixed(6);
        }

        // Search Nominatim for Edit Modals
        document.querySelectorAll('.edit-search-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = btn.getAttribute('data-id');
                var query = document.getElementById('edit-map-search' + id).value;
                if (!query) return;

                fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);

                            editMaps[id].setView([lat, lon], 15);
                            editMarkers[id].setLatLng([lat, lon]);

                            var modal = document.getElementById('editIndustriModal' + id);
                            updateEditInputs(modal, lat, lon);
                            modal.querySelector('textarea[name="alamat_lengkap"]').value = data[0].display_name;
                        } else {
                            alert('Alamat tidak ditemukan!');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal menghubungi layanan peta.');
                    });
            });
        });
    });
</script>
@endsection
