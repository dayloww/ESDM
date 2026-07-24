<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ESDM SATU DATA WILAYAH IV — Sistem Informasi Data ESDM Cabang Dinas Wilayah IV Sulawesi Utara">
    <title>@yield('title', 'Login') — ESDM SATU DATA WILAYAH IV</title>

    {{-- Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:     #0D6EFD;
            --primary-dark: #0a58ca;
            --success:     #198754;
            --danger:      #DC3545;
            --warning:     #FFC107;
            --bg:          #F8F9FA;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0D6EFD 0%, #0a3d8f 50%, #061f4a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, #0D6EFD, #0a58ca);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            color: #fff;
        }

        .auth-header .logo-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .auth-header .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0.5rem;
            display: block;
        }

        .auth-header h1 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: 0.5px;
        }

        .auth-header p {
            font-size: 0.78rem;
            opacity: 0.85;
            margin-bottom: 0;
        }

        .auth-body {
            padding: 2rem;
        }

        .auth-body h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .auth-body .subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.35rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1.5px solid #dee2e6;
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
            background: var(--bg);
            border: 1.5px solid #dee2e6;
            color: #6c757d;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.7rem;
            width: 100%;
            transition: transform 0.15s, box-shadow 0.15s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(13,110,253,0.35);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            padding: 1rem 2rem 1.5rem;
            font-size: 0.75rem;
            color: #adb5bd;
        }

        .form-check-label {
            font-size: 0.83rem;
            color: #495057;
        }

        .toggle-password {
            cursor: pointer;
            background: var(--bg);
            border: 1.5px solid #dee2e6;
            border-left: none;
            border-radius: 0 8px 8px 0;
            padding: 0 0.75rem;
            color: #6c757d;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        @yield('content')
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
