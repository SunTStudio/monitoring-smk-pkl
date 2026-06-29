@extends('layouts.app')

@section('title', 'Masuk Ke Sistem')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-5">
        <div class="card card-custom p-4 shadow">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3.5rem;"></i>
                    <h4 class="fw-bold mt-2 text-dark">Selamat Datang</h4>
                    <p class="text-muted small">Silakan masuk menggunakan akun E-PKL Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email / Username Input -->
                    <div class="mb-3">
                        <label for="login" class="form-label fw-semibold text-secondary">Username atau Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0 @error('login') is-invalid @enderror" 
                                id="login" name="login" value="{{ old('login') }}" placeholder="Contoh: admin atau NISN" required autofocus>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary">Kata Sandi (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                id="password" name="password" placeholder="Masukkan password Anda" required>
                        </div>
                    </div>

                    <!-- Remember Me checkbox -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="{{ route('magic.request') }}" class="text-primary text-decoration-none small fw-semibold">
                            <i class="bi bi-lightning-charge-fill"></i> Login Industri Tanpa Password
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark py-2.5 rounded-3 fw-semibold shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                        </button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted small">Peserta PKL belum terdaftar?</span>
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none small fw-bold ms-1">Daftar Akun Baru</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
