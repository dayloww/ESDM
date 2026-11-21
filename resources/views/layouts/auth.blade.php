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
            --primary-strong: #1E40AF;
            --primary-soft: #EFF6FF;
            --canvas: #F5F7FB;
            --surface: #FFFFFF;
            --surface-subtle: #F8FAFC;
            --border: #E2E8F0;
            --border-strong: #CBD5E1;
            --text: #0F172A;
            --text-secondary: #475569;
            --text-muted: #64748B;
            --radius-control: 10px;
            --radius-panel: 14px;
            --shadow: 0 1px 3px rgba(15,23,42,0.06);
            --focus-ring: rgba(37,99,235,0.28);
            --transition: 150ms ease;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--canvas);
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
            display: grid;
            place-items: center;
            color: var(--text);
            font-size: 0.875rem;
        }

        .skip-link {
            position: absolute;
            top: -100px;
            left: 1rem;
            z-index: 2000;
            padding: .65rem 1rem;
            border-radius: var(--radius-control);
            background: var(--primary);
            color: #fff;
            text-decoration: none;
        }

        .skip-link:focus { top: 1rem; }

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
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            overflow: hidden;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .auth-visual {
            position: relative;
            padding: 2.5rem;
            background: var(--primary-strong);
            color: #fff;
            min-height: 100%;
        }

        .auth-visual::before,
        .auth-visual::after,
        .auth-map-illustration,
        .auth-map-illustration::before,
        .auth-map-illustration::after {
            display: none;
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

        .auth-brand,
        .auth-visual-copy,
        .auth-points {
            position: relative;
            z-index: 2;
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
            background: var(--surface);
        }

        .auth-panel #auth-content {
            width: 100%;
        }

        .auth-card {
            position: relative;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .auth-header {
            padding: 1.25rem 1.25rem 0;
        }

        .auth-header .logo-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: var(--primary-soft);
            border: 1px solid var(--border);
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
            font-weight: 600;
            color: var(--text);
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
            color: var(--text);
        }

        .auth-body .subtitle {
            margin-bottom: 1.2rem;
            font-size: .85rem;
            color: var(--text-secondary);
        }

        .form-label {
            margin-bottom: .4rem;
            font-size: .75rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .form-control {
            min-height: 50px;
            padding: .82rem .95rem;
            border-radius: var(--radius-control);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            font-size: .875rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem var(--focus-ring);
            outline: 0;
        }

        .input-group-text {
            min-width: 48px;
            justify-content: center;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-muted);
            border-radius: var(--radius-control) 0 0 var(--radius-control);
        }

        .input-group .form-control {
            border-radius: 0 var(--radius-control) var(--radius-control) 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
        }

        .toggle-password {
            cursor: pointer;
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: none;
            border-radius: 0 var(--radius-control) var(--radius-control) 0;
            padding: 0 .85rem;
            color: var(--text-muted);
            transition: color var(--transition), background-color var(--transition);
        }

        .toggle-password:hover {
            color: var(--primary);
            background: var(--surface-subtle);
        }

        .btn-login {
            width: 100%;
            min-height: 50px;
            padding: .9rem 1rem;
            border: 1px solid var(--primary);
            border-radius: var(--radius-control);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            background: var(--primary);
            box-shadow: none;
            transition: background var(--transition), border-color var(--transition);
        }

        .btn-login:hover {
            background: var(--primary-strong);
            border-color: var(--primary-strong);
            color: #fff;
        }

        .auth-footer {
            padding: 1rem 1.25rem 1.25rem;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: .75rem;
            color: var(--text-muted);
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
            border-radius: var(--radius-control);
            border: 1px solid var(--border);
            background: var(--primary-soft);
            color: var(--primary-strong);
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
                border-radius: var(--radius-panel);
            }

            .auth-visual {
                min-height: 300px;
                padding: 2rem;
            }

            .auth-map-illustration {
                inset: 5.1rem 1.4rem 3.6rem 7.1rem;
                opacity: .18;
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

        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        a:focus-visible,
        button:focus-visible,
        .btn:focus-visible,
        .form-control:focus-visible {
            box-shadow: 0 0 0 .2rem var(--focus-ring);
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <a href="#auth-content" class="skip-link">Lewati ke formulir login</a>
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

                    <div class="auth-map-illustration" aria-hidden="true"></div>

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
                <main id="auth-content" tabindex="-1">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
