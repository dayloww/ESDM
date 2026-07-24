<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ESDM SATU DATA WILAYAH IV — Panel Admin">
    <title>@yield('title', 'Dashboard') — ESDM SATU DATA WILAYAH IV</title>

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
            --primary:          #0D6EFD;
            --primary-dark:     #0a58ca;
            --primary-light:    #e8f0fe;
            --success:          #198754;
            --danger:           #DC3545;
            --warning:          #FFC107;
            --sidebar-width:    260px;
            --navbar-height:    60px;
            --bg:               #F0F2F5;
            --sidebar-bg:       #0d1b2a;
            --sidebar-text:     #cbd5e1;
            --sidebar-hover:    rgba(255,255,255,0.08);
            --sidebar-active:   var(--primary);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 0;
        }

        /* ── SIDEBAR ───────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        .sidebar-brand {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand .brand-icon {
            width: 38px;
            height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon i {
            color: #fff;
            font-size: 1.1rem;
        }

        .sidebar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .sidebar-brand .brand-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
        }

        .sidebar-brand .brand-subtitle {
            font-size: 0.65rem;
            color: var(--sidebar-text);
        }

        .sidebar-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1.25rem 1.25rem 0.4rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0.5rem 0;
            margin: 0;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.25rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .sidebar-nav li a i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav li a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav li a.active {
            background: rgba(13,110,253,0.15);
            color: #fff;
            border-left-color: var(--primary);
            font-weight: 500;
        }

        .sidebar-nav li a .badge-coming {
            font-size: 0.6rem;
            background: rgba(255,255,255,0.15);
            color: var(--sidebar-text);
            padding: 0.15rem 0.45rem;
            border-radius: 20px;
            margin-left: auto;
        }

        /* ── MAIN CONTENT ──────────────────────── */
        #main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* ── NAVBAR ────────────────────────────── */
        #topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            gap: 1rem;
        }

        #sidebarToggle {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        #sidebarToggle:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .topbar-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #343a40;
            margin: 0;
            flex: 1;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .topbar-user .user-avatar {
            width: 34px;
            height: 34px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .topbar-user .user-name {
            font-size: 0.83rem;
            font-weight: 500;
            color: #343a40;
        }

        .topbar-user .user-role {
            font-size: 0.7rem;
            color: #adb5bd;
            line-height: 1;
        }

        /* ── PAGE CONTENT ──────────────────────── */
        #page-content {
            flex: 1;
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        /* ── FOOTER ────────────────────────────── */
        #page-footer {
            background: #fff;
            border-top: 1px solid #e9ecef;
            padding: 0.75rem 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: #adb5bd;
        }

        /* ── CARD ──────────────────────────────── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.92rem;
        }

        /* ── RESPONSIVE ────────────────────────── */
        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-wrapper {
                margin-left: 0;
            }

            #sidebarOverlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1039;
            }

            #sidebarOverlay.show {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- Sidebar Overlay (mobile) --}}
<div id="sidebarOverlay"></div>

{{-- ── SIDEBAR ──────────────────────────────── --}}
<nav id="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <div class="brand-text">
            <span class="brand-title">SATU DATA ESDM</span>
            <span class="brand-subtitle">Wilayah IV — Sulawesi Utara</span>
        </div>
    </div>

    {{-- Menu Utama --}}
    <div class="sidebar-section-label">Menu Utama</div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    {{-- Data --}}
    <div class="sidebar-section-label">Data Wilayah</div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('kabupaten.index') }}" class="{{ request()->routeIs('kabupaten.*') ? 'active' : '' }}">
                <i class="bi bi-geo"></i>
                <span>Kabupaten</span>
            </a>
        </li>
        <li>
            <a href="{{ route('kecamatan.index') }}" class="{{ request()->routeIs('kecamatan.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i>
                <span>Kecamatan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('desa.index') }}" class="{{ request()->routeIs('desa.*') ? 'active' : '' }}">
                <i class="bi bi-geo-fill"></i>
                <span>Desa</span>
            </a>
        </li>
        <li>
            <a href="{{ route('wilayah.index') }}" class="{{ request()->routeIs('wilayah.*') ? 'active' : '' }}">
                <i class="bi bi-map"></i>
                <span>Data Wilayah</span>
            </a>
        </li>
    </ul>

    {{-- Sektor ESDM --}}
    <div class="sidebar-section-label">Sektor ESDM</div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('usaha.index') }}" class="{{ request()->routeIs('usaha.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i>
                <span>Data Usaha ESDM</span>
            </a>
        </li>
        <li>
            <a href="{{ route('mineral.index') }}" class="{{ request()->routeIs('mineral.*') ? 'active' : '' }}">
                <i class="bi bi-gem"></i>
                <span>Mineral & Pertambangan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('energi.index') }}" class="{{ request()->routeIs('energi.*') ? 'active' : '' }}">
                <i class="bi bi-plug"></i>
                <span>Energi & Ketenagalistrikan</span>
            </a>
        </li>
    </ul>

    {{-- Operasional --}}
    <div class="sidebar-section-label">Operasional</div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('pengawasan.index') }}" class="{{ request()->routeIs('pengawasan.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Pengawasan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('pad.index') }}" class="{{ request()->routeIs('pad.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>
                <span>Potensi PAD</span>
            </a>
        </li>
        <li>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>
        </li>
    </ul>

    {{-- Sistem --}}
    <div class="sidebar-section-label">Sistem</div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Manajemen Pengguna</span>
            </a>
        </li>
    </ul>
</nav>

{{-- ── MAIN WRAPPER ──────────────────────────── --}}
<div id="main-wrapper">

    {{-- ── TOP NAVBAR ─────────────────────────── --}}
    <header id="topbar">
        <button id="sidebarToggle" type="button" aria-label="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

        <p class="topbar-title">@yield('page-title', 'Dashboard')</p>

        {{-- User Dropdown --}}
        <div class="topbar-user">
            <div class="dropdown">
                <button
                    class="btn d-flex align-items-center gap-2 p-1 border-0 bg-transparent"
                    type="button"
                    id="userDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-start d-none d-md-block">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->role?->nama_role ?? 'Pengguna' }}</div>
                    </div>
                    <i class="bi bi-chevron-down text-muted" style="font-size:0.7rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                    <li>
                        <h6 class="dropdown-header">{{ Auth::user()->email }}</h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    {{-- ── CONTENT ─────────────────────────────── --}}
    <main id="page-content">

        {{-- Breadcrumb --}}
        @hasSection('breadcrumb')
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">
                        <i class="bi bi-house"></i> Beranda
                    </a>
                </li>
                @yield('breadcrumb')
            </ol>
        </nav>
        @endif

        {{-- Alert Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('warning') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </main>

    {{-- ── FOOTER ──────────────────────────────── --}}
    <footer id="page-footer">
        &copy; {{ date('Y') }} Dinas ESDM Provinsi Sulawesi Utara — Cabang Wilayah IV. Semua hak dilindungi.
    </footer>

</div>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    // Sidebar toggle (mobile)
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebarOverlay');
    const toggleBtn      = document.getElementById('sidebarToggle');

    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Global delete confirmation
    function deleteConfirm(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>

@stack('scripts')
</body>
</html>
