@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="logo-icon">
            <img src="{{ asset('storage/logo_esdm.png') }}" alt="Logo ESDM">
        </div>
        <h1>ESDM SATU DATA WILAYAH IV</h1>
        <p>Cabang Dinas Wilayah IV - Dinas ESDM Provinsi Sulawesi Utara</p>
    </div>

    <div class="auth-body">
        <h2>Selamat Datang</h2>
        <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
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

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@esdm.go.id"
                        autocomplete="email"
                        autofocus
                        required
                    >
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
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
                    <button type="button" class="toggle-password" id="togglePassword" title="Tampilkan/sembunyikan password">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login" id="btnLogin">
                <span id="btnText">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </span>
                <span id="btnLoading" class="d-none">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Memproses...
                </span>
            </button>
        </form>
    </div>

    <div class="auth-footer">
        &copy; {{ date('Y') }} Dinas ESDM Provinsi Sulawesi Utara. Semua hak dilindungi.
    </div>
</div>
@endsection

@push('scripts')
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    const loginForm = document.getElementById('loginForm');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const btnLogin = document.getElementById('btnLogin');

    loginForm.addEventListener('submit', function () {
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        btnLogin.disabled = true;
    });
</script>
@endpush
