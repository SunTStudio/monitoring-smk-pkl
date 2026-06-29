@extends('layouts.app')

@section('title', 'Siswa Dashboard')

@section('styles')
<!-- Leaflet Maps CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 180px;
        z-index: 1;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
@php
    $latKantor = $penugasanAktif && $penugasanAktif->industri && $penugasanAktif->industri->latitude ? $penugasanAktif->industri->latitude : -6.200000;
    $lngKantor = $penugasanAktif && $penugasanAktif->industri && $penugasanAktif->industri->longitude ? $penugasanAktif->industri->longitude : 106.816666;
    $namaKantor = $penugasanAktif && $penugasanAktif->industri ? $penugasanAktif->industri->nama_industri : 'Kantor Mitra (Simulasi)';
@endphp

<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom p-4 shadow-sm bg-dark text-white border-0">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary p-3 rounded-3 text-white me-4">
                    <i class="bi bi-speedometer2 fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Dashboard Siswa PKL</h4>
                    <p class="mb-0 text-white-50">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Silakan isi absensi geofencing dan jurnal harian Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Absensi Geofencing Card -->
    <div class="col-md-5">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Presensi Harian Geofencing</h5>
            
            @if($kehadiranHariIni && $kehadiranHariIni->jam_masuk && $kehadiranHariIni->jam_keluar)
                <!-- Case C: Complete for today -->
                <div class="text-center py-4 mb-0">
                    <i class="bi bi-calendar-check-fill text-success fs-1 mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark">Absensi Hari Ini Lengkap!</h6>
                    <p class="small text-muted mb-0">Anda telah Check-in Masuk pada <strong>{{ $kehadiranHariIni->jam_masuk }}</strong> dan Check-out Keluar pada <strong>{{ $kehadiranHariIni->jam_keluar }}</strong>.</p>
                </div>
            @else
                <div class="alert alert-info border-start border-info border-4 p-2.5 mb-3 small">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    <strong>Lokasi Kantor:</strong> {{ $namaKantor }} (Lat: {{ $latKantor }}, Lon: {{ $lngKantor }}).
                </div>

                <!-- Leaflet Map Container -->
                <div id="map" class="mb-3 border border-secondary shadow-sm"></div>

                @if(!$kehadiranHariIni)
                    <!-- Case A: Not checked in yet -->
                    <!-- Check In Form -->
                    <form action="{{ route('absen.checkin') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        <input type="hidden" name="status_kehadiran" value="hadir">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label small fw-semibold text-secondary">Latitude Anda (GPS)</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="latitude" id="lat" readonly required placeholder="Mendeteksi GPS...">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small fw-semibold text-secondary">Longitude Anda (GPS)</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="longitude" id="lon" readonly required placeholder="Mendeteksi GPS...">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Selfie / Foto Bukti Masuk</label>
                            <input type="file" class="form-control form-control-sm bg-light" name="bukti_foto" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="bi bi-box-arrow-in-right"></i> Check-in Absen Masuk
                        </button>
                    </form>
                @else
                    <!-- Case B: Checked in, but not checked out yet -->
                    <div class="alert alert-success border-start border-success border-4 py-2 px-3 small mb-4">
                        <i class="bi bi-patch-check-fill me-1"></i>
                        Anda telah Check-in Masuk pada jam <strong>{{ $kehadiranHariIni->jam_masuk }}</strong>. Jangan lupa Check-out sebelum pulang.
                    </div>

                    <!-- Check Out Form -->
                    <form action="{{ route('absen.checkout') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Selfie / Foto Bukti Keluar</label>
                            <input type="file" class="form-control form-control-sm bg-light" name="bukti_foto" required>
                        </div>
                        <button type="submit" class="btn btn-outline-dark btn-sm w-100 fw-bold">
                            <i class="bi bi-box-arrow-out-right"></i> Check-out Absen Keluar
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    <!-- Jurnal Laporan Harian Form -->
    <div class="col-md-7">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-journal-text text-primary me-2"></i> Input Jurnal Laporan Harian</h5>
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold">Tanggal</label>
                        <input type="date" class="form-control form-control-sm bg-light" name="tgl_laporan" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold">Jam Mulai</label>
                        <input type="time" class="form-control form-control-sm bg-light" name="jam_mulai_kerja" value="08:00" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold">Jam Selesai</label>
                        <input type="time" class="form-control form-control-sm bg-light" name="jam_selesai_kerja" value="17:00" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Aktivitas & Pekerjaan Yang Dilakukan</label>
                    <textarea class="form-control bg-light" name="aktivitas_pekerjaan" rows="3" placeholder="Deskripsikan pekerjaan hari ini..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Hasil Pekerjaan (Output) / Deskripsi Bukti Fisik</label>
                    <input type="text" class="form-control form-control-sm bg-light" name="hasil_pekerjaan" placeholder="Misal: Produk sabun cair / Laporan analisis pH larutan / Perakitan PC selesai / Source code" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Skill Yang Dipraktikkan</label>
                        <input type="text" class="form-control form-control-sm bg-light" name="skill_dipraktikkan" placeholder="Misal: Analisis Lab, K3, Laravel, Git" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Upload File Lampiran / Foto Bukti Hasil Pekerjaan (PDF/Img)</label>
                        <input type="file" class="form-control form-control-sm bg-light" name="file_lampiran">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-sm fw-bold">Submit Jurnal Hari Ini</button>
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
        var mapContainer = document.getElementById('map');
        if (!mapContainer) return; // Skip if map is hidden because attendance is complete

        var officeLat = parseFloat("{{ $latKantor }}");
        var officeLng = parseFloat("{{ $lngKantor }}");
        var officeName = "{{ $namaKantor }}";
        
        // Init map
        var map = L.map('map').setView([officeLat, officeLng], 16);
        
        // OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        
        // Add office marker & geofence circle (100m)
        L.marker([officeLat, officeLng]).addTo(map)
            .bindPopup('<b>' + officeName + '</b><br>Titik Pusat Kantor').openPopup();
            
        L.circle([officeLat, officeLng], {
            color: '#10b981',
            fillColor: '#34d399',
            fillOpacity: 0.2,
            radius: 100 // 100 meters
        }).addTo(map);
        
        // Red Marker for student's coordinate - NOT draggable (cannot be customized manually)
        var studentMarker = L.marker([officeLat, officeLng], {
            draggable: false
        }).addTo(map).bindPopup('<b>Mendeteksi GPS Anda...</b>').openPopup();
        
        // Automatic Geolocation API fetch
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                
                // Write coordinates to read-only inputs
                var latInput = document.getElementById('lat');
                var lonInput = document.getElementById('lon');
                if (latInput && lonInput) {
                    latInput.value = lat.toFixed(6);
                    lonInput.value = lon.toFixed(6);
                }
                
                // Move marker to real GPS location
                studentMarker.setLatLng([lat, lon]);
                map.panTo([lat, lon]);
                updateDistance();
            }, function(error) {
                console.error("GPS detection failed: ", error);
                alert("Gagal mendeteksi lokasi GPS. Pastikan izin akses lokasi Anda diaktifkan di browser!");
                studentMarker.setPopupContent('<b>GPS Gagal Dideteksi</b><br>Silakan aktifkan izin lokasi browser Anda.').openPopup();
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            alert("Browser Anda tidak mendukung deteksi lokasi GPS.");
        }
        
        function updateDistance() {
            var latInput = document.getElementById('lat');
            var lonInput = document.getElementById('lon');
            if (!latInput || !lonInput) return;
            
            var lat = parseFloat(latInput.value);
            var lon = parseFloat(lonInput.value);
            if (isNaN(lat) || isNaN(lon)) return;
            
            var dist = map.distance([officeLat, officeLng], [lat, lon]);
            var status = dist <= 100 ? '<span class="text-success fw-bold"><i class="bi bi-patch-check-fill"></i> Radius Valid</span>' : '<span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Di Luar Radius Kantor</span>';
            studentMarker.setPopupContent('<b>Lokasi GPS Anda</b><br>Jarak ke kantor: ' + dist.toFixed(1) + ' meter.<br>' + status).openPopup();
        }

        // --- Client-side Image Compression (Canvas-based) ---
        function compressImage(file, callback) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                var img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    
                    var max_width = 800;
                    var max_height = 800;
                    var width = img.width;
                    var height = img.height;
                    
                    if (width > height) {
                        if (width > max_width) {
                            height *= max_width / width;
                            width = max_width;
                        }
                    } else {
                        if (height > max_height) {
                            width *= max_height / height;
                            height = max_height;
                        }
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob(function(blob) {
                        var compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        callback(compressedFile);
                    }, 'image/jpeg', 0.65);
                };
            };
        }

        // Check-in Form submit handler
        var checkInForm = document.querySelector('form[action="{{ route("absen.checkin") }}"]');
        if (checkInForm) {
            checkInForm.addEventListener('submit', function(e) {
                var fileInput = checkInForm.querySelector('input[name="bukti_foto"]');
                if (fileInput && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    if (file.size < 250 * 1024) {
                        return;
                    }
                    
                    e.preventDefault();
                    var submitBtn = checkInForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengompres Foto...';
                    
                    compressImage(file, function(compressedFile) {
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        fileInput.files = dataTransfer.files;
                        checkInForm.submit();
                    });
                }
            });
        }

        // Check-out Form submit handler
        var checkOutForm = document.querySelector('form[action="{{ route("absen.checkout") }}"]');
        if (checkOutForm) {
            checkOutForm.addEventListener('submit', function(e) {
                var fileInput = checkOutForm.querySelector('input[name="bukti_foto"]');
                if (fileInput && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    if (file.size < 250 * 1024) {
                        return;
                    }
                    
                    e.preventDefault();
                    var submitBtn = checkOutForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengompres Foto...';
                    
                    compressImage(file, function(compressedFile) {
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        fileInput.files = dataTransfer.files;
                        checkOutForm.submit();
                    });
                }
            });
        }
    });
</script>
@endsection
