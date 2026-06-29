@extends('layouts.app')

@section('title', 'Industri Dashboard')

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
                <div class="flex-shrink-0 bg-warning p-3 rounded-3 text-dark me-4">
                    <i class="bi bi-speedometer2 fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Dashboard Mitra Industri DU-DI</h4>
                    <p class="mb-0 text-white-50">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Berikut data monitoring magang siswa PKL.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Siswa Magang & Log Presensi -->
    <div class="col-md-7">
        <!-- Siswa PKL Magang Card -->
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people-fill text-warning me-2"></i> Siswa PKL Magang Aktif</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Tanggal Mulai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasan as $item)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                                <td>{{ $item->siswa->jurusan ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_mulai_pkl)->format('d M Y') }}</td>
                                <td>
                                    @if($item->status === 'aktif')
                                        <span class="badge bg-success-subtle text-success text-capitalize">{{ $item->status }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary text-capitalize">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada data siswa magang aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Log Kehadiran Siswa PKL Card -->
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Log Kehadiran Siswa PKL</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm" style="font-size: 0.85rem;">
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
                                    $earthRadius = 6371000; // Earth radius in meters
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
                                <td>{{ \Carbon\Carbon::parse($k->tgl_absen)->format('d M Y') }}</td>
                                <td class="fw-semibold text-dark">{{ $k->siswa->nama_lengkap ?? '-' }}</td>
                                <td>
                                    <span class="text-success"><i class="bi bi-box-arrow-in-right"></i> {{ $k->waktu_checkin ?? '-' }}</span><br>
                                    <span class="text-danger"><i class="bi bi-box-arrow-out-right"></i> {{ $k->waktu_checkout ?? '-' }}</span>
                                </td>
                                <td>
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
                                <td class="text-center">
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
    </div>

    <!-- Form Input Nilai Kompetensi Mock -->
    <div class="col-md-5">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-award-fill text-warning me-2"></i> Beri Penilaian Kompetensi</h5>
            <form action="{{ route('nilai.kompetensi') }}" method="POST">
                @csrf
                <input type="hidden" name="id_penugasan_fk" value="1">
                <input type="hidden" name="id_siswa_fk" value="1">
                <input type="hidden" name="status" value="finalized">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Muhammad Rayhan (Siswa RPL)</label>
                    <div class="border rounded p-3 bg-light">
                        <!-- Score 1 -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-medium">Pemrograman Web & Mobile (1-100)</label>
                            <input type="number" class="form-control form-control-sm bg-white" name="scores[1][nilai]" value="85" min="0" max="100" required>
                            <input type="text" class="form-control form-control-sm bg-white mt-1" name="scores[1][catatan]" placeholder="Catatan aspek...">
                        </div>
                        <!-- Score 2 -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-medium">Basis Data & SQL (1-100)</label>
                            <input type="number" class="form-control form-control-sm bg-white" name="scores[2][nilai]" value="90" min="0" max="100" required>
                            <input type="text" class="form-control form-control-sm bg-white mt-1" name="scores[2][catatan]" placeholder="Catatan aspek...">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="catatan_umum" class="form-label fw-medium text-secondary">Catatan Perkembangan Umum</label>
                    <textarea class="form-control bg-light" name="catatan_umum" rows="2" placeholder="Siswa rajin dan terampil..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="rekomendasi_industri" class="form-label fw-medium text-secondary">Rekomendasi Industri</label>
                    <textarea class="form-control bg-light" name="rekomendasi_industri" rows="2" placeholder="Pertahankan kinerja baik..."></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-sm fw-semibold">Submit Penilaian Akhir</button>
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
                '<strong>Siswa Magang:</strong> ' + studentName + '<br>' +
                '<strong>Koordinat Check-in:</strong> Lat ' + sLat + ', Lon ' + sLon + '<br>' +
                '<strong>Jarak ke Kantor:</strong> ' + distance.toFixed(1) + ' meter.<br>' +
                '<strong>Status Validasi:</strong> ' + validity;
        });
    });
</script>
@endsection
