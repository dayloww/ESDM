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
            --primary:          #2563EB;
            --primary-dark:     #1E40AF;
            --primary-light:    #EFF6FF;
            --success:          #16A34A;
            --danger:           #DC2626;
            --warning:          #F59E0B;
            --info:             #0EA5E9;
            --sidebar-width:    248px;
            --navbar-height:    58px;
            --bg:               #F5F7FB;
            --card:             #FFFFFF;
            --border:           #E5E7EB;
            --text-primary:     #111827;
            --text-secondary:   #6B7280;
            --shadow:           0 8px 24px rgba(15,23,42,.06);
            --shadow-hover:     0 14px 34px rgba(15,23,42,.10);
            --sidebar-bg:       #0F172A;
            --sidebar-text:     #CBD5E1;
            --sidebar-hover:    rgba(255,255,255,0.06);
            --sidebar-active:   var(--primary);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            color: var(--text-primary);
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
            box-shadow: 8px 0 28px rgba(15,23,42,.12);
        }

        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        .sidebar-brand {
            padding: 1.15rem 1rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar-brand .brand-logos {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-logo {
            height: 32px;
            width: auto;
            display: block;
            object-fit: contain;
        }

        .sidebar-brand .brand-logo-provinsi {
            height: 30px;
        }

        .sidebar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .sidebar-brand .brand-title {
            font-size: 0.74rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0;
        }

        .sidebar-brand .brand-subtitle {
            font-size: 0.62rem;
            color: var(--sidebar-text);
        }

        .sidebar-section-label {
            font-size: 0.62rem;
            font-weight: 600;
            color: rgba(255,255,255,0.34);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 1.1rem 1rem 0.45rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0.35rem 0.75rem;
            margin: 0;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.72rem 0.82rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 400;
            border-radius: 12px;
            border-left: 3px solid transparent;
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .sidebar-nav li a i {
            font-size: 0.96rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav li a:hover {
            background: var(--sidebar-hover);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar-nav li a.active {
            background: rgba(37,99,235,0.18);
            color: #fff;
            border-left-color: var(--primary);
            border-radius: 999px;
            font-weight: 600;
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
            overflow-x: hidden;
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
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(229,231,235,.75);
            box-shadow: 0 8px 22px rgba(15,23,42,.04);
            gap: 1rem;
        }

        #sidebarToggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.35rem 0.55rem;
            border-radius: 10px;
            transition: background 0.2s, color 0.2s;
        }

        #sidebarToggle:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            flex: 0 0 auto;
        }

        .topbar-search {
            flex: 1;
            max-width: 420px;
            position: relative;
            margin-left: auto;
        }

        .topbar-search i {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.86rem;
            pointer-events: none;
        }

        .topbar-search input {
            width: 100%;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: #F8FAFC;
            color: var(--text-primary);
            font-size: 0.82rem;
            padding: 0 1rem 0 2.35rem;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }

        .topbar-search input:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(37,99,235,.10);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: auto;
            flex-shrink: 0;
        }

        .topbar-user .dropdown > .btn {
            border-radius: 999px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .topbar-user .dropdown > .btn:hover {
            background: #F8FAFC !important;
            transform: translateY(-1px);
        }

        .topbar-user .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(37,99,235,.18);
        }

        .topbar-user .user-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .topbar-user .user-role {
            font-size: 0.7rem;
            color: var(--text-secondary);
            line-height: 1;
        }

        /* ── PAGE CONTENT ──────────────────────── */
        #page-content {
            flex: 1;
            padding: 1.75rem;
            overflow-x: hidden;
        }

        .page-header {
            margin-bottom: 1.25rem;
        }

        .page-header h1 {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        /* ── FOOTER ────────────────────────────── */
        #page-footer {
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 0.9rem 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* ── CARD ──────────────────────────────── */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(229,231,235,.75);
            border-radius: 18px 18px 0 0 !important;
            padding: 1.15rem 1.35rem;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .card-header h5,
        .card-header h6 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-body {
            padding: 1.35rem;
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.45rem 0.7rem;
            font-size: 0.78rem;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 8px 18px rgba(37,99,235,.18);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-warning {
            background: #F59E0B;
            border-color: #F59E0B;
            color: #fff;
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
        }

        .form-control,
        .form-select {
            border-color: var(--border);
            border-radius: 12px;
            color: var(--text-primary);
            min-height: 44px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(37,99,235,.12);
        }

        .form-label {
            color: var(--text-primary);
            font-size: .86rem;
        }

        .breadcrumb {
            --bs-breadcrumb-divider-color: #94A3B8;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--primary);
        }

        .alert {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .table-responsive {
            border-radius: 16px;
            background: #fff;
        }

        .table {
            --bs-table-striped-bg: transparent;
            --bs-table-hover-bg: rgba(37,99,235,.045);
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
            color: var(--text-primary);
            overflow: hidden;
        }

        .table-bordered > :not(caption) > * {
            border-width: 0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem .95rem;
            border-bottom: 1px solid rgba(229,231,235,.64);
            vertical-align: middle;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(180deg, #F8FAFC 0%, #EFF6FF 100%);
            color: #334155;
            font-size: .76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            border-bottom: 1px solid rgba(37,99,235,.12);
            box-shadow: inset 0 -1px 0 rgba(37,99,235,.08);
            white-space: nowrap;
        }

        .table thead th:first-child {
            border-top-left-radius: 14px;
        }

        .table thead th:last-child {
            border-top-right-radius: 14px;
        }

        .table tbody tr {
            transition: background-color .25s ease, transform .25s ease, box-shadow .25s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(37,99,235,.045);
        }

        .table tbody tr:last-child > * {
            border-bottom: none;
        }

        .table td {
            font-size: .86rem;
        }

        .table td:first-child,
        .table th:first-child {
            padding-left: 1.15rem;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 1.15rem;
        }

        .table td .btn {
            border-radius: 999px;
            box-shadow: none;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            margin-bottom: .2rem;
            transition: transform .25s ease, box-shadow .25s ease, filter .25s ease;
        }

        .table td .btn:hover {
            transform: translateY(-1px);
            filter: saturate(1.04);
        }

        .table td .btn-warning {
            background: rgba(245,158,11,.12);
            border-color: transparent;
            color: #B45309;
        }

        .table td .btn-danger {
            background: rgba(220,38,38,.10);
            border-color: transparent;
            color: var(--danger);
        }

        .table td .btn-outline-info {
            background: rgba(14,165,233,.10);
            border-color: transparent;
            color: var(--info);
        }

        .badge {
            border-radius: 999px;
            padding: .38rem .62rem;
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            font-size: .82rem;
        }

        .dataTables_wrapper .row:first-child {
            align-items: center;
            row-gap: .85rem;
            margin: 0 0 1rem;
            padding: .85rem;
            background: linear-gradient(135deg, #FFFFFF, #F8FAFC);
            border: 1px solid rgba(229,231,235,.72);
            border-radius: 18px;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: .55rem;
            margin: 0;
            color: var(--text-secondary);
            font-weight: 500;
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_filter label {
            justify-content: flex-end;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border);
            border-radius: 999px;
            min-height: 42px;
            margin: 0;
            background-color: #fff;
            color: var(--text-primary);
            box-shadow: 0 6px 16px rgba(15,23,42,.04);
            transition: border-color .3s ease, box-shadow .3s ease, background .3s ease;
        }

        .dataTables_wrapper .dataTables_length select {
            width: 78px;
            min-width: 78px;
            padding: .45rem 2.15rem .45rem .85rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: min(320px, 100%);
            padding: .45rem 1rem;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(37,99,235,.10);
            outline: none;
        }

        .dataTables_wrapper .row:last-child {
            align-items: center;
            row-gap: .85rem;
            margin-top: 1rem;
            padding: .2rem .15rem 0;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 0 !important;
        }

        table.dataTable {
            border-top: 0 !important;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            cursor: pointer;
        }

        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after {
            color: var(--primary);
            opacity: .35;
        }

        .page-item .page-link {
            border: none;
            border-radius: 999px;
            color: var(--text-secondary);
            margin: 0 .14rem;
            min-width: 36px;
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .25s ease, color .25s ease, box-shadow .25s ease;
        }

        .page-item .page-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 8px 18px rgba(37,99,235,.18);
        }

        .page-item.disabled .page-link {
            color: #CBD5E1;
            background: transparent;
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

        @media (max-width: 575.98px) {
            #page-content {
                padding: 1rem;
            }

            #topbar {
                padding: 0 1rem;
            }

            .topbar-search {
                display: none;
            }

            .card-header {
                align-items: flex-start !important;
                gap: .75rem;
                flex-direction: column;
            }

            .card-header .btn {
                width: 100%;
            }

            .dataTables_wrapper .dataTables_length label,
            .dataTables_wrapper .dataTables_filter label {
                align-items: flex-start;
                flex-direction: column;
                gap: .4rem;
                white-space: normal;
            }

            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_filter label,
            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
            }

            .dataTables_wrapper .dataTables_filter label {
                justify-content: flex-start;
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
        <div class="brand-logos" aria-hidden="true">
            <img class="brand-logo brand-logo-provinsi" src="{{ asset('storage/logo_provinsi.svg') }}" alt="">
            <img class="brand-logo" src="{{ asset('storage/logo_esdm.png') }}" alt="">
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

    @if(Auth::user()->isAdmin())
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
    @endif
</nav>

{{-- ── MAIN WRAPPER ──────────────────────────── --}}
<div id="main-wrapper">

    {{-- ── TOP NAVBAR ─────────────────────────── --}}
    <header id="topbar">
        <button id="sidebarToggle" type="button" aria-label="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

        <p class="topbar-title">@yield('page-title', 'Dashboard')</p>

        <div class="topbar-search d-none d-md-block">
            <i class="bi bi-search"></i>
            <input id="globalSearch" type="search" placeholder="Cari data, laporan, atau wilayah..." aria-label="Cari">
        </div>

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

    // Global client-side search for admin pages.
    const globalSearch = document.getElementById('globalSearch');

    function filterPlainTables(keyword) {
        document.querySelectorAll('table tbody tr').forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    }

    function filterDashboardSections(keyword) {
        document.querySelectorAll('.timeline-item, .work-area-item, .stat-card').forEach((item) => {
            item.style.display = item.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    }

    globalSearch?.addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();

        if (window.jQuery && jQuery.fn?.dataTable) {
            jQuery('table').each(function () {
                if (jQuery.fn.dataTable.isDataTable(this)) {
                    jQuery(this).DataTable().search(keyword).draw();
                }
            });
        } else {
            filterPlainTables(keyword);
        }

        filterDashboardSections(keyword);
    });

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            document.querySelectorAll('.dataTables_filter input').forEach((input) => {
                input.placeholder = 'Kata kunci pencarian';
            });
        }, 120);
    });

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
