@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="brand-logos">
            <div class="logo-icon logo-provinsi">
                <img src="{{ asset('storage/logo_provinsi.svg') }}" alt="Logo Provinsi Sulawesi Utara">
            </div>
            <div class="logo-icon">
                <img src="{{ asset('storage/logo_esdm.png') }}" alt="Logo ESDM">
            </div>
        </div>
        <div class="auth-hint">
            <i class="bi bi-shield-lock-fill"></i>
            Portal Akses Pengguna
        </div>
        <h1>ESDM SATU DATA WILAYAH IV</h1>
        <p>Cabang Dinas Wilayah IV (Sangihe, Sitaro, Talaud) Dinas Energi dan Sumber Daya Mineral Daerah Provinsi Sulawesi Utara</p>
    </div>

    <div class="auth-body">
        <h2>Masuk ke akun Anda</h2>
        <p class="subtitle">Gunakan email atau username yang terdaftar untuk melanjutkan.</p>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill mt-1"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill mt-1"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Username / Email</label>
                <div class="input-group has-validation">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@esdm.go.id"
                        autocomplete="email"
                        autofocus
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Email wajib diisi.</div>
                    @enderror
                </div>
                <div class="form-floating-note">Masukkan alamat email resmi atau username yang terdaftar.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group has-validation">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                    <div class="invalid-feedback">Password wajib diisi.</div>
                </div>
                <div class="form-floating-note">Pastikan data yang dimasukkan sesuai akun aktif Anda.</div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login" id="btnLogin">
                <span id="btnText">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </span>
                <span id="btnLoading" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Memproses...
                </span>
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <div>Versi 1.0 Beta</div>
        <div>&copy; 2026 Cabang Dinas Wilayah IV Dinas Energi dan Sumber Daya Mineral Provinsi Sulawesi Utara</div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .brand-logos {
        display: flex;
        align-items: center;
        gap: .6rem;
        margin-bottom: .7rem;
    }

    .brand-logos .logo-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 auto;
        background: transparent;
        border: none;
        border-radius: 0;
        padding: 0;
    }

    .brand-logos .logo-icon.logo-provinsi {
        background: transparent;
    }

    .brand-logos .logo-icon img {
        padding: 0;
    }

    @media (max-width: 575.98px) {
        .brand-logos {
            justify-content: flex-start;
        }
    }
</style>
<script>
    const loginForm = document.getElementById('loginForm');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const btnLogin = document.getElementById('btnLogin');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleIcon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });

    loginForm.addEventListener('submit', function (event) {
        if (!loginForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            btnLogin.disabled = true;
        }

        loginForm.classList.add('was-validated');
    });
</script>
@endpush
