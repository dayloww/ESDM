<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ESDM SATU DATA WILAYAH IV - Sistem Informasi Data ESDM Cabang Dinas Wilayah IV Sulawesi Utara">
    <title>@yield('title', 'Login') - ESDM SATU DATA WILAYAH IV</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1E40AF;
            --bg: #F8FAFC;
            --card: #FFFFFF;
            --border: #E5E7EB;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --shadow: 0 8px 24px rgba(0,0,0,.08);
            --shadow-hover: 0 12px 32px rgba(0,0,0,.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 34%),
                radial-gradient(circle at bottom right, rgba(14,165,233,.14), transparent 30%),
                linear-gradient(135deg, #EEF4FF 0%, #F8FAFC 50%, #EEF7FB 100%);
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
            display: grid;
            place-items: center;
            color: var(--text-primary);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 1120px;
            min-height: calc(100vh - 2rem);
            display: flex;
            align-items: center;
        }

        .auth-shell {
            width: 100%;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            border-radius: 22px;
            overflow: hidden;
            background: var(--card);
            box-shadow: var(--shadow);
            animation: fadeInUp .28s ease both;
        }

        .auth-visual {
            position: relative;
            padding: 2.5rem;
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.16), transparent 22%),
                radial-gradient(circle at 82% 18%, rgba(255,255,255,.10), transparent 18%),
                linear-gradient(145deg, rgba(37,99,235,.98), rgba(30,64,175,.95) 60%, rgba(14,165,233,.76));
            color: #fff;
            min-height: 100%;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                url("{{ asset('storage/logo_esdm.png') }}") center 72% / 300px no-repeat,
                radial-gradient(circle at 50% 108%, rgba(255,255,255,.10), transparent 26%);
            opacity: .12;
            pointer-events: none;
        }

        .auth-visual-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: .9rem;
        }

        .auth-brand-badge {
            width: 66px;
            height: 66px;
            border-radius: 18px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            backdrop-filter: blur(8px);
        }

        .auth-brand-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: .4rem;
            display: block;
        }

        .auth-brand-copy {
            display: grid;
            gap: .1rem;
        }

        .auth-brand-copy h2 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .auth-brand-copy p {
            margin: 0;
            font-size: .84rem;
            color: rgba(255,255,255,.84);
            line-height: 1.5;
        }

        .auth-visual-copy {
            max-width: 30rem;
        }

        .auth-visual-copy h3 {
            margin: 0 0 .75rem;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .auth-visual-copy p {
            margin: 0;
            color: rgba(255,255,255,.85);
            line-height: 1.7;
            font-size: .95rem;
        }

        .auth-points {
            display: grid;
            gap: .75rem;
            max-width: 28rem;
        }

        .auth-point {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: rgba(255,255,255,.92);
            font-size: .9rem;
        }

        .auth-point i {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,.14);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: linear-gradient(180deg, #FFFFFF 0%, #FAFCFF 100%);
        }

        .auth-panel > .auth-card {
            width: 100%;
        }

        .auth-card {
            position: relative;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(15,23,42,.08);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .auth-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 34px rgba(15,23,42,.10);
        }

        .auth-header {
            padding: 1.25rem 1.25rem 0;
        }

        .auth-header .logo-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(37,99,235,.06), rgba(14,165,233,.04));
            border: 1px solid rgba(229,231,235,.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .9rem;
            overflow: hidden;
        }

        .auth-header .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: .5rem;
            display: block;
        }

        .auth-header h1 {
            margin: 0 0 .2rem;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .auth-header p {
            margin: 0;
            font-size: .82rem;
            line-height: 1.6;
            color: var(--text-secondary);
        }

        .auth-body {
            padding: 1.25rem 1.25rem 0;
        }

        .auth-body h2 {
            margin-bottom: .2rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .auth-body .subtitle {
            margin-bottom: 1.2rem;
            font-size: .85rem;
            color: var(--text-secondary);
        }

        .form-label {
            margin-bottom: .35rem;
            font-size: .9rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .form-control {
            min-height: 50px;
            padding: .82rem .95rem;
            border-radius: 10px;
            border: 1px solid rgba(229,231,235,.7);
            font-size: .9rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color .22s ease, box-shadow .22s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37,99,235,.14);
        }

        .input-group-text {
            min-width: 48px;
            justify-content: center;
            background: #fff;
            border: 1px solid rgba(229,231,235,.7);
            color: #6B7280;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
        }

        .toggle-password {
            cursor: pointer;
            background: #fff;
            border: 1px solid rgba(229,231,235,.7);
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 0 .85rem;
            color: #6B7280;
            transition: color .22s ease, background-color .22s ease;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: #F8FAFC;
        }

        .btn-login {
            width: 100%;
            min-height: 50px;
            padding: .9rem 1rem;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), #1d4ed8 55%, var(--primary-dark));
            box-shadow: var(--shadow);
            transition: transform .22s ease, box-shadow .22s ease, filter .22s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            filter: saturate(1.03);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .auth-footer {
            padding: 1rem 1.25rem 1.25rem;
            border-top: 1px solid rgba(229,231,235,.75);
            text-align: center;
            font-size: .75rem;
            color: var(--text-secondary);
        }

        .auth-footer > div {
            line-height: 1.45;
        }

        .auth-hint {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            margin-bottom: .85rem;
            padding: .42rem .72rem;
            border-radius: 999px;
            border: 1px solid rgba(37,99,235,.08);
            background: rgba(239,246,255,.92);
            color: var(--primary-dark);
            font-size: .78rem;
            font-weight: 600;
        }

        .form-floating-note {
            margin-top: .35rem;
            font-size: .78rem;
            color: var(--text-secondary);
        }

        @media (max-width: 991.98px) {
            .auth-shell {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }

            .auth-visual {
                min-height: 300px;
                padding: 2rem;
            }

            .auth-panel {
                padding: 1.35rem;
            }
        }

        @media (max-width: 575.98px) {
            body { padding: .75rem; }

            .auth-visual { display: none; }

            .auth-panel {
                padding: 1rem;
            }

            .auth-header,
            .auth-body {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .auth-header h1 {
                font-size: .98rem;
            }

            .auth-body h2 {
                font-size: 1.15rem;
            }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-shell">
            <div class="auth-visual d-none d-lg-block">
                <div class="auth-visual-content">
                    <div class="auth-brand">
                        <div class="auth-brand-badge">
                            <img src="{{ asset('storage/logo_esdm.png') }}" alt="Logo ESDM">
                        </div>
                        <div class="auth-brand-copy">
                            <h2>ESDM SATU DATA WILAYAH IV</h2>
                            <p>Cabang Dinas Wilayah IV</p>
                            <p>Dinas Energi dan Sumber Daya Mineral</p>
                            <p>Provinsi Sulawesi Utara</p>
                        </div>
                    </div>

                    <div class="auth-visual-copy">
                        <h3>Sistem pendataan yang rapi, cepat, dan mudah dipakai.</h3>
                        <p>
                            Mendukung pendataan, pemetaan, pengawasan, dan pelaporan sektor energi dan sumber daya mineral secara modern untuk wilayah kerja pemerintah.
                        </p>
                    </div>

                    <div class="auth-points">
                        <div class="auth-point">
                            <i class="bi bi-shield-check"></i>
                            <span>Akses terpusat untuk admin dan operator.</span>
                        </div>
                        <div class="auth-point">
                            <i class="bi bi-geo-alt"></i>
                            <span>Data wilayah, pemetaan, dan pengawasan yang terintegrasi.</span>
                        </div>
                        <div class="auth-point">
                            <i class="bi bi-bar-chart"></i>
                            <span>Ringkasan informasi yang siap dipantau setiap saat.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-panel">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
