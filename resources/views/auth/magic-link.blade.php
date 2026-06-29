@extends('layouts.app')

@section('title', 'Login Instan Industri')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-6">
        <div class="card card-custom p-4 shadow">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="bi bi-lightning-charge-fill text-warning" style="font-size: 3.5rem;"></i>
                    <h4 class="fw-bold mt-2 text-dark">Login Instan Pembimbing Industri</h4>
                    <p class="text-muted small">Masukkan email industri yang terdaftar. Kami akan membuatkan link masuk aman tanpa password.</p>
                </div>

                <!-- Status alert for generated magic link -->
                @if(session('magicLink'))
                    <div class="alert alert-warning border-start border-warning border-4 p-3 mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-info-circle-fill text-warning fs-5 me-2"></i>
                            <strong class="text-dark">Tautan Pengujian (Local Dev Mode):</strong>
                        </div>
                        <p class="small text-muted mb-2">Karena ini di lingkungan local development, silakan klik tombol di bawah untuk menyimulasikan login industri:</p>
                        <div class="d-grid">
                            <a href="{{ session('magicLink') }}" class="btn btn-warning btn-sm fw-bold">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk Sebagai Industri Sekarang
                            </a>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('magic.request') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold text-secondary">Email Mitra Industri</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" placeholder="contoh: industri@smkadvance.sch.id" required autofocus>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark py-2.5 rounded-3 fw-semibold">
                            <i class="bi bi-send me-1"></i> Dapatkan Magic Link Masuk
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-secondary text-decoration-none small fw-semibold">
                            <i class="bi bi-arrow-left"></i> Kembali Ke Halaman Login Utama
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
