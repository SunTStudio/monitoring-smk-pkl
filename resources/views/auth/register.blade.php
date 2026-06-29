@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-custom p-4 shadow mb-5">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="bi bi-person-badge-fill text-primary" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-2 text-dark">Registrasi Akun Siswa</h4>
                    <p class="text-muted small">Lengkapi formulir di bawah ini untuk mendaftarkan akun siswa PKL</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <!-- Left Column: Akun & Sekolah -->
                        <div class="col-md-6 border-end pe-md-4">
                            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                                <i class="bi bi-card-text me-1"></i> Data Akun & Sekolah
                            </h5>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium text-secondary">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="nisn" class="form-label fw-medium text-secondary">NISN</label>
                                    <input type="text" class="form-control bg-light @error('nisn') is-invalid @enderror" 
                                        id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="NISN Anda" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nis" class="form-label fw-medium text-secondary">NIS</label>
                                    <input type="text" class="form-control bg-light @error('nis') is-invalid @enderror" 
                                        id="nis" name="nis" value="{{ old('nis') }}" placeholder="NIS Anda" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label for="kelas" class="form-label fw-medium text-secondary">Kelas</label>
                                    <input type="text" class="form-control bg-light @error('kelas') is-invalid @enderror" 
                                        id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="XI/XII" required>
                                </div>
                                <div class="col-8 mb-3">
                                    <label for="jurusan" class="form-label fw-medium text-secondary">Jurusan</label>
                                    <select class="form-select bg-light @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                        <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer & Jaringan (TKJ)</option>
                                        <option value="MM" {{ old('jurusan') == 'MM' ? 'selected' : '' }}>Multimedia (MM)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium text-secondary">Email Siswa</label>
                                <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" placeholder="siswa@example.com" required>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="password" class="form-label fw-medium text-secondary">Password</label>
                                    <input type="password" class="form-control bg-light @error('password') is-invalid @enderror" 
                                        id="password" name="password" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-medium text-secondary">Konfirmasi</label>
                                    <input type="password" class="form-control bg-light" 
                                        id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Kontak & Orang Tua -->
                        <div class="col-md-6 ps-md-4">
                            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">
                                <i class="bi bi-person-fill-gear me-1"></i> Kontak & Wali
                            </h5>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label fw-medium text-secondary">Nomor HP / WhatsApp</label>
                                <input type="text" class="form-control bg-light @error('no_hp') is-invalid @enderror" 
                                    id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-medium text-secondary">Alamat Lengkap</label>
                                <textarea class="form-control bg-light @error('alamat') is-invalid @enderror" 
                                    id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap rumah">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="mb-3 mt-4">
                                <label for="nama_orang_tua" class="form-label fw-medium text-secondary">Nama Orang Tua / Wali</label>
                                <input type="text" class="form-control bg-light @error('nama_orang_tua') is-invalid @enderror" 
                                    id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" placeholder="Nama Ibu / Ayah">
                            </div>

                            <div class="mb-3">
                                <label for="no_hp_orang_tua" class="form-label fw-medium text-secondary">Nomor HP Orang Tua</label>
                                <input type="text" class="form-control bg-light @error('no_hp_orang_tua') is-invalid @enderror" 
                                    id="no_hp_orang_tua" name="no_hp_orang_tua" value="{{ old('no_hp_orang_tua') }}" placeholder="Nomor HP Wali">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark py-2.5 rounded-3 fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> Daftarkan Akun
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Sudah memiliki akun?</span>
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none small fw-bold ms-1">Masuk Sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
