@extends('layouts.app')

@section('title', 'Riwayat Absensi & Jurnal')

@section('styles')
<style>
    .avatar-img-preview {
        width: 42px;
        height: 42px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .avatar-img-preview:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom p-4 shadow-sm bg-dark text-white border-0">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-info p-3 rounded-3 text-white me-4">
                    <i class="bi bi-calendar-check fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Riwayat Aktivitas & Kehadiran</h4>
                    <p class="mb-0 text-white-50">Temukan rekaman kehadiran harian geofencing dan jurnal laporan kerja magang Anda di bawah.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-custom p-4 shadow-sm mb-4">
            <!-- Navigation Tabs -->
            <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-pill" id="historyTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill fw-bold" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi" type="button" role="tab" aria-controls="absensi" aria-selected="true">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> Riwayat Absensi GPS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill fw-bold" id="jurnal-tab" data-bs-toggle="tab" data-bs-target="#jurnal" type="button" role="tab" aria-controls="jurnal" aria-selected="false">
                        <i class="bi bi-journal-richtext text-primary me-1"></i> Riwayat Jurnal Harian
                    </button>
                </li>
            </ul>

            <!-- Filter Tanggal -->
            <form method="GET" action="{{ route('siswa.riwayat') }}" id="filterTanggalForm">
                <div class="d-flex flex-wrap gap-2 align-items-end mb-4 p-3 bg-light rounded-3 border">
                    <div class="me-1">
                        <label class="form-label small fw-semibold text-secondary mb-1"><i class="bi bi-calendar-range me-1 text-primary"></i>Filter Rentang Tanggal</label>
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <div>
                                <label class="form-label small text-muted mb-1" for="tgl_mulai">Dari Tanggal</label>
                                <input type="date" class="form-control form-control-sm" id="tgl_mulai" name="tgl_mulai" value="{{ $tglMulai ?? '' }}" style="min-width: 150px;">
                            </div>
                            <div class="mt-3 text-muted fw-bold">—</div>
                            <div>
                                <label class="form-label small text-muted mb-1" for="tgl_akhir">Sampai Tanggal</label>
                                <input type="date" class="form-control form-control-sm" id="tgl_akhir" name="tgl_akhir" value="{{ $tglAkhir ?? '' }}" style="min-width: 150px;">
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold">
                                    <i class="bi bi-funnel-fill me-1"></i> Terapkan
                                </button>
                                @if($tglMulai || $tglAkhir)
                                    <a href="{{ route('siswa.riwayat') }}" class="btn btn-outline-secondary btn-sm px-3 fw-semibold">
                                        <i class="bi bi-x-circle me-1"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($tglMulai || $tglAkhir)
                        <div class="ms-auto align-self-end">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                <i class="bi bi-filter-circle me-1"></i>
                                Menampilkan:
                                {{ $tglMulai ? \Carbon\Carbon::parse($tglMulai)->format('d M Y') : 'Semua' }}
                                —
                                {{ $tglAkhir ? \Carbon\Carbon::parse($tglAkhir)->format('d M Y') : 'Sekarang' }}
                            </span>
                        </div>
                    @endif
                </div>
            </form>

            <!-- Tab Content -->
            <div class="tab-content" id="historyTabContent">
                
                <!-- 1. RIWAYAT ABSENSI -->
                <div class="tab-pane fade show active" id="absensi" role="tabpanel" aria-labelledby="absensi-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-responsive-stack">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Check-in Masuk</th>
                                    <th>Check-out Keluar</th>
                                    <th>Total Jam Kerja</th>
                                    <th>Koordinat GPS</th>
                                    <th class="text-center">Foto Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kehadiran as $k)
                                    @php
                                        $coords = explode(',', $k->lokasi_checkin);
                                        $lat = $coords[0] ?? '-';
                                        $lon = $coords[1] ?? '-';
                                    @endphp
                                    <tr>
                                        <td data-label="Tanggal" class="fw-bold text-dark">{{ \Carbon\Carbon::parse($k->tgl_absen)->format('d M Y') }}</td>
                                        <td data-label="Status">
                                            @if($k->status_kehadiran === 'hadir')
                                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $k->status_kehadiran }}</span>
                                            @elseif(in_array($k->status_kehadiran, ['izin', 'sakit', 'cuti']))
                                                <span class="badge bg-warning-subtle text-warning text-capitalize">{{ $k->status_kehadiran }}</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger text-capitalize">{{ $k->status_kehadiran }}</span>
                                            @endif
                                        </td>
                                        <td data-label="Check-in Masuk" class="text-success fw-medium">
                                            <i class="bi bi-clock"></i> {{ $k->waktu_checkin ?? '-' }}
                                        </td>
                                        <td data-label="Check-out Keluar" class="text-danger fw-medium">
                                            <i class="bi bi-clock"></i> {{ $k->waktu_checkout ?? '-' }}
                                        </td>
                                        <td data-label="Total Jam Kerja" class="fw-bold text-dark">
                                            {{ $k->jam_kerja_real ? $k->jam_kerja_real . ' Jam' : '-' }}
                                        </td>
                                        <td data-label="Koordinat GPS">
                                            <small class="text-muted">{{ $lat }}, {{ $lon }}</small>
                                        </td>
                                        <td data-label="Foto Bukti" class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($k->bukti_foto_checkin)
                                                    <img src="{{ asset($k->bukti_foto_checkin) }}" class="avatar-img-preview border shadow-xs" 
                                                        data-bs-toggle="modal" data-bs-target="#imageViewerModal" 
                                                        data-image-src="{{ asset($k->bukti_foto_checkin) }}" 
                                                        data-title="Foto Check-in: {{ \Carbon\Carbon::parse($k->tgl_absen)->format('d M Y') }}"
                                                        alt="Foto Masuk">
                                                @endif
                                                @if($k->bukti_foto_checkout)
                                                    <img src="{{ asset($k->bukti_foto_checkout) }}" class="avatar-img-preview border shadow-xs" 
                                                        data-bs-toggle="modal" data-bs-target="#imageViewerModal" 
                                                        data-image-src="{{ asset($k->bukti_foto_checkout) }}" 
                                                        data-title="Foto Check-out: {{ \Carbon\Carbon::parse($k->tgl_absen)->format('d M Y') }}"
                                                        alt="Foto Keluar">
                                                @endif
                                                @if(!$k->bukti_foto_checkin && !$k->bukti_foto_checkout)
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat absensi yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. RIWAYAT JURNAL HARIAN -->
                <div class="tab-pane fade" id="jurnal" role="tabpanel" aria-labelledby="jurnal-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-responsive-stack">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Kerja</th>
                                    <th>Aktivitas / Pekerjaan</th>
                                    <th>Output</th>
                                    <th>Skill</th>
                                    <th>Lampiran</th>
                                    <th>Status</th>
                                    <th>Nilai</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan as $l)
                                    <tr>
                                        <td data-label="Tanggal" class="fw-bold text-dark">{{ \Carbon\Carbon::parse($l->tgl_laporan)->format('d M Y') }}</td>
                                        <td data-label="Jam Kerja" class="small">
                                            {{ \Carbon\Carbon::parse($l->jam_mulai_kerja)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->jam_selesai_kerja)->format('H:i') }}
                                        </td>
                                        <td data-label="Aktivitas / Pekerjaan" style="max-width: 200px;" class="text-truncate" title="{{ $l->aktivitas_pekerjaan }}">
                                            {{ $l->aktivitas_pekerjaan }}
                                        </td>
                                        <td data-label="Output" style="max-width: 150px;" class="text-truncate" title="{{ $l->hasil_pekerjaan }}">
                                            <small class="text-secondary">{{ $l->hasil_pekerjaan ?? '-' }}</small>
                                        </td>
                                        <td data-label="Skill">
                                            <span class="badge bg-light text-dark border small">{{ $l->skill_dipraktikkan ?? '-' }}</span>
                                        </td>
                                        <td data-label="Lampiran">
                                            @if($l->file_lampiran)
                                                <a href="{{ asset($l->file_lampiran) }}" target="_blank" class="btn btn-outline-dark btn-xs px-2 py-0.5 rounded-pill text-decoration-none">
                                                    <i class="bi bi-download"></i> Unduh
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Status">
                                            @if($l->status === 'approved')
                                                <span class="badge bg-success-subtle text-success text-capitalize">Disetujui</span>
                                            @elseif($l->status === 'rejected')
                                                <span class="badge bg-danger-subtle text-danger text-capitalize">Ditolak</span>
                                            @elseif($l->status === 'submitted')
                                                <span class="badge bg-info-subtle text-info text-capitalize">Diajukan</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary text-capitalize">{{ $l->status ?? 'Draft' }}</span>
                                            @endif
                                        </td>
                                        <td data-label="Nilai">
                                            @if($l->nilai_guru || $l->nilai_dudi)
                                                <small class="text-muted">Guru: <strong class="text-primary">{{ $l->nilai_guru ?? '-' }}</strong></small><br>
                                                <small class="text-muted">DU-DI: <strong class="text-success">{{ $l->nilai_dudi ?? '-' }}</strong></small>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Aksi" class="text-center">
                                            <button class="btn btn-outline-dark btn-xs rounded-pill px-2.5" data-bs-toggle="modal" data-bs-target="#detailJurnalModal{{ $l->id_laporan }}">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada laporan jurnal harian yang diajukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Detail Jurnal Modals -->
@foreach($laporan as $l)
    <div class="modal fade" id="detailJurnalModal{{ $l->id_laporan }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content card-custom p-3 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="bi bi-journal-richtext text-primary me-2"></i> Review Detail Jurnal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <table class="table table-borderless table-sm small mb-3">
                        <tr>
                            <td class="fw-semibold text-secondary" style="width: 140px;">Tanggal Jurnal</td>
                            <td style="width: 10px;">:</td>
                            <td class="text-dark fw-bold">{{ \Carbon\Carbon::parse($l->tgl_laporan)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-secondary">Jam Kerja</td>
                            <td>:</td>
                            <td class="text-dark">{{ \Carbon\Carbon::parse($l->jam_mulai_kerja)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->jam_selesai_kerja)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-secondary">Skill Dipraktikkan</td>
                            <td>:</td>
                            <td><span class="badge bg-light text-dark border small">{{ $l->skill_dipraktikkan ?? '-' }}</span></td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Aktivitas & Pekerjaan Yang Dilakukan</label>
                        <div class="p-2 bg-light rounded text-dark small" style="white-space: pre-wrap; font-size: 0.82rem;">{{ $l->aktivitas_pekerjaan }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Hasil Pekerjaan (Output)</label>
                        <div class="p-2 bg-light rounded text-dark small" style="font-size: 0.82rem;">{{ $l->hasil_pekerjaan ?? '-' }}</div>
                    </div>

                    @if($l->kendala_hambatan)
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary mb-1">Kendala / Hambatan</label>
                            <div class="p-2 bg-light-subtle border rounded text-danger small" style="font-size: 0.82rem;">{{ $l->kendala_hambatan }}</div>
                        </div>
                    @endif

                    @if($l->pembelajaran_didapat)
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary mb-1">Pembelajaran Yang Didapat</label>
                            <div class="p-2 bg-light rounded text-dark small" style="font-size: 0.82rem;">{{ $l->pembelajaran_didapat }}</div>
                        </div>
                    @endif

                    <div class="row text-center mb-3 g-2">
                        <div class="col-6">
                            <div class="p-2 bg-light border rounded">
                                <span class="text-secondary small d-block" style="font-size: 0.75rem;">Nilai Sikap (Guru)</span>
                                <h4 class="fw-bold text-primary mb-0">{{ $l->nilai_guru ?? '-' }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light border rounded">
                                <span class="text-secondary small d-block" style="font-size: 0.75rem;">Nilai Teknis (DU-DI)</span>
                                <h4 class="fw-bold text-success mb-0">{{ $l->nilai_dudi ?? '-' }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 border rounded bg-light-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-secondary">Status Peninjauan:</span>
                            @if($l->status === 'approved')
                                <span class="badge bg-success text-capitalize px-3 py-1.5 rounded-pill">Disetujui</span>
                            @elseif($l->status === 'rejected')
                                <span class="badge bg-danger text-capitalize px-3 py-1.5 rounded-pill">Ditolak</span>
                            @elseif($l->status === 'submitted')
                                <span class="badge bg-info text-capitalize px-3 py-1.5 rounded-pill">Diajukan</span>
                            @else
                                <span class="badge bg-secondary text-capitalize px-3 py-1.5 rounded-pill">{{ $l->status ?? 'Draft' }}</span>
                            @endif
                        </div>
                        @if($l->feedback_pembimbing)
                            <div class="mt-3 border-top pt-2">
                                <span class="small fw-semibold text-secondary d-block">Feedback Reviewer:</span>
                                <p class="mb-0 text-dark small mt-1 italic">"{{ $l->feedback_pembimbing }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-dark btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal Image Viewer -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-custom p-2 border-0">
            <div class="modal-header border-0 pb-1">
                <h6 class="modal-title fw-bold text-dark" id="imageViewerTitle">Foto Bukti Presensi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img src="" id="imageViewerSrc" class="img-fluid rounded border shadow-sm" style="max-height: 450px;" alt="Bukti Presensi">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var imageViewerModal = document.getElementById('imageViewerModal');
        imageViewerModal.addEventListener('show.bs.modal', function(event) {
            var triggerEl = event.relatedTarget;
            var src = triggerEl.getAttribute('data-image-src');
            var title = triggerEl.getAttribute('data-title');

            document.getElementById('imageViewerSrc').setAttribute('src', src);
            document.getElementById('imageViewerTitle').innerText = title;
        });
    });
</script>
@endsection
