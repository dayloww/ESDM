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

    <script>
        (function () {
            try {
                if (localStorage.getItem('esdm-sidebar-collapsed') === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            } catch (error) {}
        })();
    </script>

    <style>
        :root {
            --primary:          #2563EB;
            --primary-strong:   #1E40AF;
            --primary-soft:     #EFF6FF;
            --success:          #16A34A;
            --warning:          #F59E0B;
            --danger:           #DC2626;
            --info:             #0891B2;

            --canvas:           #F5F7FB;
            --surface:          #FFFFFF;
            --surface-subtle:   #F8FAFC;
            --border:           #E2E8F0;
            --border-strong:    #CBD5E1;
            --text:             #0F172A;
            --text-secondary:   #475569;
            --text-muted:       #64748B;

            --sidebar-width:    240px;
            --navbar-height:    56px;
            --sidebar-bg:       #0F172A;
            --sidebar-text:     #CBD5E1;
            --sidebar-hover:    rgba(255,255,255,0.06);
            --sidebar-active:   rgba(37,99,235,0.18);

            --radius-control:   10px;
            --radius-panel:     14px;
            --shadow:           0 1px 3px rgba(15,23,42,0.06);
            --focus-ring:       rgba(37,99,235,0.28);
            --transition:       150ms ease;
            --sidebar-duration: 200ms;
            --sidebar-ease:     cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { box-sizing: border-box; }

        .skip-link {
            position: absolute;
            left: -9999px;
            top: 0;
            z-index: 2000;
            background: var(--primary);
            color: #fff;
            padding: .65rem 1rem;
            border-radius: 0 0 10px 0;
            text-decoration: none;
        }

        .skip-link:focus { left: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--canvas);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            color: var(--text);
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
            overscroll-behavior: contain;
            z-index: 1040;
            border-right: 1px solid rgba(255,255,255,0.08);
            visibility: visible;
            transition: transform var(--sidebar-duration) var(--sidebar-ease), visibility 0s;
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
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.52);
            text-transform: uppercase;
            letter-spacing: 0.1em;
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
            min-height: 44px;
            padding: 0.65rem 0.8rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--radius-control);
            border-left: 3px solid transparent;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
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
        }

        .sidebar-nav li a.active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar-group-toggle {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            width: 100%;
            min-height: 44px;
            padding: 0.65rem 0.8rem;
            color: var(--sidebar-text);
            background: none;
            border: none;
            border-left: 3px solid transparent;
            border-radius: var(--radius-control);
            text-align: left;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
        }

        .sidebar-group-toggle:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-group-toggle.is-active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar-group-toggle i:first-child {
            font-size: 0.96rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-group-chevron {
            margin-left: auto;
            font-size: 0.7rem;
            transition: transform var(--transition);
        }

        .sidebar-group-toggle[aria-expanded="true"] .sidebar-group-chevron {
            transform: rotate(180deg);
        }

        .sidebar-subnav {
            padding: 0.25rem 0 0 0.95rem;
        }

        .sidebar-subnav li a {
            font-size: 0.8125rem;
            padding: 0.55rem 0.75rem;
        }

        /* ── MAIN CONTENT ──────────────────────── */
        #main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--sidebar-duration) var(--sidebar-ease);
            overflow-x: hidden;
        }

        @media (min-width: 992px) {
            html.sidebar-collapsed #sidebar {
                transform: translateX(-100%);
                visibility: hidden;
                transition: transform var(--sidebar-duration) var(--sidebar-ease),
                            visibility 0s linear var(--sidebar-duration);
            }

            html.sidebar-collapsed #main-wrapper {
                margin-left: 0;
            }
        }

        /* ── NAVBAR ────────────────────────────── */
        #topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: var(--surface);
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--border);
            gap: 0.75rem;
        }

        #sidebarToggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            min-height: 44px;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: var(--radius-control);
            transition: background var(--transition), color var(--transition);
        }

        #sidebarToggle:hover {
            background: var(--surface-subtle);
            color: var(--primary);
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin: 0;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: auto;
            flex-shrink: 0;
        }

        .topbar-user .dropdown > .btn {
            border-radius: var(--radius-control);
            padding: 0.35rem 0.5rem;
            transition: background var(--transition);
        }

        .topbar-user .dropdown > .btn:hover {
            background: var(--surface-subtle) !important;
        }

        .topbar-user .user-avatar {
            width: 34px;
            height: 34px;
            background: var(--primary-soft);
            border: 1px solid rgba(37,99,235,0.14);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-strong);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .topbar-user .user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-user .user-role {
            font-size: 0.6875rem;
            color: var(--text-muted);
            line-height: 1;
        }

        /* ── DROPDOWN (polish visual) ──────────── */
        .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            box-shadow: var(--shadow);
            padding: 0.45rem;
        }

        .dropdown-item {
            border-radius: var(--radius-control);
            padding: 0.55rem 0.75rem;
            font-size: 0.8125rem;
            transition: background var(--transition), color var(--transition);
        }

        .dropdown-item:hover {
            background: var(--primary-soft);
        }

        /* ── PAGE CONTENT ──────────────────────── */
        #page-content {
            flex: 1;
            padding: 1.5rem;
            overflow-x: hidden;
            font-size: 0.875rem;
            color: var(--text);
        }

        .page-header {
            margin-bottom: 1.25rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.25;
            color: var(--text);
            margin-bottom: 0.25rem;
        }

        /* ── FOOTER ────────────────────────────── */
        #page-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 0.9rem 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* ── CARD ──────────────────────────────── */
        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            border-radius: var(--radius-panel) var(--radius-panel) 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .card-header h5,
        .card-header h6 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
        }

        .card-body {
            padding: 1.25rem;
        }

        .btn {
            min-height: 40px;
            border-radius: var(--radius-control);
            font-weight: 600;
            transition: background var(--transition), border-color var(--transition), color var(--transition), box-shadow var(--transition);
        }

        .btn-sm {
            min-height: 38px;
            padding: 0.45rem 0.7rem;
            font-size: 0.8125rem;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: none;
        }

        .btn-primary:hover {
            background: var(--primary-strong);
            border-color: var(--primary-strong);
        }

        .btn-warning {
            background: var(--warning);
            border-color: var(--warning);
            color: #fff;
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
        }

        .form-control,
        .form-select {
            background-color: var(--surface);
            border-color: var(--border);
            border-radius: var(--radius-control);
            color: var(--text);
            font-size: 0.875rem;
            min-height: 42px;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem var(--focus-ring);
            outline: 0;
        }

        .form-label {
            color: var(--text-secondary);
            font-size: .75rem;
            font-weight: 500;
            margin-bottom: .4rem;
        }

        .form-actions .btn {
            min-width: 120px;
        }

        @media (max-width: 575.98px) {
            .form-actions .btn {
                width: 100%;
            }
        }

        .breadcrumb {
            --bs-breadcrumb-divider-color: var(--border-strong);
            color: var(--text-secondary);
            font-size: 0.8125rem;
        }

        .breadcrumb a {
            color: var(--primary);
        }

        .alert {
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            box-shadow: var(--shadow);
            font-size: 0.875rem;
        }

        .table-responsive {
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
            background: var(--surface);
        }

        .table {
            --bs-table-striped-bg: transparent;
            --bs-table-hover-bg: rgba(37,99,235,.04);
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
            color: var(--text);
            font-size: 0.875rem;
            overflow: hidden;
        }

        .table-bordered > :not(caption) > * {
            border-width: 0;
        }

        .table > :not(caption) > * > * {
            padding: 0.8rem 0.95rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            line-height: 1.35;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--surface-subtle);
            color: var(--text-secondary);
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            border-bottom: 1px solid var(--border-strong);
            white-space: nowrap;
        }

        .table thead th:first-child {
            border-top-left-radius: calc(var(--radius-panel) - 1px);
        }

        .table thead th:last-child {
            border-top-right-radius: calc(var(--radius-panel) - 1px);
        }

        .table tbody tr {
            transition: background-color var(--transition);
        }

        .table tbody tr:hover {
            background-color: var(--bs-table-hover-bg);
        }

        .table tbody tr:last-child > * {
            border-bottom: none;
        }

        .table td {
            font-size: 0.875rem;
        }

        .table td:first-child,
        .table th:first-child {
            padding-left: 1.15rem;
        }

        .table td:last-child,
        .table th:last-child {
            padding-right: 1.15rem;
        }

        .table-actions {
            column-gap: .5rem !important;
            row-gap: .35rem !important;
        }

        .table td .btn {
            min-width: 38px;
            min-height: 38px;
            border-radius: var(--radius-control);
            box-shadow: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .3rem;
            margin-bottom: .2rem;
            transition: background var(--transition), border-color var(--transition), color var(--transition);
        }

        .table td .btn-warning {
            background: rgba(245,158,11,.12);
            border-color: transparent;
            color: #B45309;
        }

        .table td .btn-warning:hover {
            background: rgba(245,158,11,.18);
        }

        .table td .btn-danger {
            background: rgba(220,38,38,.10);
            border-color: transparent;
            color: var(--danger);
        }

        .table td .btn-danger:hover {
            background: rgba(220,38,38,.16);
        }

        .table td .btn-outline-info {
            background: rgba(8,145,178,.10);
            border-color: transparent;
            color: var(--info);
        }

        .table td .btn-outline-info:hover {
            background: rgba(8,145,178,.16);
        }

        .badge {
            border-radius: 999px;
            padding: .38rem .62rem;
            font-weight: 600;
        }

        .status-badge {
            border: 1px solid transparent;
            font-size: .75rem;
            letter-spacing: .01em;
        }

        .status-badge--success {
            background: color-mix(in srgb, var(--success) 12%, transparent);
            border-color: color-mix(in srgb, var(--success) 24%, transparent);
            color: #166534;
        }

        .status-badge--warning {
            background: color-mix(in srgb, var(--warning) 14%, transparent);
            border-color: color-mix(in srgb, var(--warning) 28%, transparent);
            color: #92400E;
        }

        .status-badge--danger {
            background: color-mix(in srgb, var(--danger) 10%, transparent);
            border-color: color-mix(in srgb, var(--danger) 22%, transparent);
            color: #991B1B;
        }

        .status-badge--info {
            background: color-mix(in srgb, var(--info) 12%, transparent);
            border-color: color-mix(in srgb, var(--info) 24%, transparent);
            color: #155E75;
        }

        .status-badge--secondary {
            background: var(--surface-subtle);
            border-color: var(--border);
            color: var(--text-secondary);
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
            padding: .85rem 1rem;
            background: var(--surface-subtle);
            border: 1px solid var(--border);
            border-radius: var(--radius-panel);
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
            border-radius: var(--radius-control);
            min-height: 42px;
            margin: 0;
            background-color: var(--surface);
            color: var(--text);
            box-shadow: none;
            transition: border-color var(--transition), box-shadow var(--transition);
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
            box-shadow: 0 0 0 .2rem var(--focus-ring);
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
            opacity: .45;
        }

        .page-item .page-link {
            border: none;
            border-radius: var(--radius-control);
            color: var(--text-secondary);
            margin: 0 .14rem;
            min-width: 40px;
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background var(--transition), color var(--transition);
        }

        .page-item .page-link:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: var(--border-strong);
            background: transparent;
        }

        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        a:focus-visible,
        button:focus-visible,
        .btn:focus-visible,
        .form-control:focus-visible,
        .form-select:focus-visible {
            box-shadow: 0 0 0 .2rem var(--focus-ring);
        }

        @media (prefers-reduced-motion: reduce) {
            #sidebar,
            #sidebarOverlay,
            #main-wrapper {
                transition: none;
            }
        }

        /* ── RESPONSIVE ────────────────────────── */
        @media (max-width: 991.98px) {
            #topbar {
                z-index: 1050;
            }

            #sidebar {
                top: var(--navbar-height);
                height: calc(100vh - var(--navbar-height));
                transform: translateX(-100%);
                visibility: hidden;
                transition: transform var(--sidebar-duration) var(--sidebar-ease),
                            visibility 0s linear var(--sidebar-duration);
            }

            #sidebar.show {
                transform: translateX(0);
                visibility: visible;
                transition: transform var(--sidebar-duration) var(--sidebar-ease), visibility 0s;
            }

            #main-wrapper {
                margin-left: 0;
            }

            #sidebarOverlay {
                display: block;
                position: fixed;
                inset: var(--navbar-height) 0 0;
                background: rgba(15,23,42,0.48);
                z-index: 1039;
                opacity: 0;
                visibility: hidden;
                transition: opacity var(--sidebar-duration) var(--sidebar-ease),
                            visibility 0s linear var(--sidebar-duration);
            }

            #sidebarOverlay.show {
                opacity: 1;
                visibility: visible;
                transition: opacity var(--sidebar-duration) var(--sidebar-ease), visibility 0s;
            }
        }

        @media (max-width: 767.98px) {
            #page-content {
                padding: 1rem;
            }

            #topbar {
                padding: 0 0.75rem;
            }

            .topbar-title {
                font-size: 0.9375rem;
            }

            .card-header {
                align-items: flex-start !important;
                gap: .75rem;
                flex-direction: column;
            }

            .card-header .btn {
                width: 100%;
            }

            .btn,
            .btn-sm,
            .form-control,
            .form-select,
            .dataTables_wrapper .dataTables_filter input,
            .dataTables_wrapper .dataTables_length select {
                min-height: 44px;
            }
        }

        @media (max-width: 575.98px) {
            #page-content {
                padding: 0.85rem;
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

    @stack('styles')
</head>
<body>
<a href="#page-content" class="skip-link">Lewati ke konten utama</a>

{{-- Sidebar Overlay (mobile) --}}
<div id="sidebarOverlay"></div>

@php($wilayahMenuActive = request()->routeIs('kabupaten.*', 'kecamatan.*', 'desa.*', 'wilayah.*'))
<nav id="sidebar" aria-label="Navigasi utama">
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

    <div class="sidebar-section-label">Data Wilayah</div>
    <ul class="sidebar-nav">
        <li>
            <button type="button" class="sidebar-group-toggle {{ $wilayahMenuActive ? 'is-active' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#wilayahMenu"
                    aria-expanded="{{ $wilayahMenuActive ? 'true' : 'false' }}" aria-controls="wilayahMenu">
                <i class="bi bi-diagram-3"></i>
                <span>Data Wilayah</span>
                <i class="bi bi-chevron-down sidebar-group-chevron" aria-hidden="true"></i>
            </button>
            <div class="collapse {{ $wilayahMenuActive ? 'show' : '' }}" id="wilayahMenu">
                <ul class="sidebar-nav sidebar-subnav">
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
            </div>
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
                <i class="bi bi-lightning-charge"></i>
                <span>Energi</span>
            </a>
        </li>
        <li>
            <a href="{{ route('ketenagalistrikan.index') }}" class="{{ request()->routeIs('ketenagalistrikan.*') ? 'active' : '' }}">
                <i class="bi bi-plug"></i>
                <span>Ketenagalistrikan</span>
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

    @if(Auth::user()->canManageUsers())
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
        <button id="sidebarToggle" type="button" aria-label="Tutup navigasi" aria-controls="sidebar" aria-expanded="true">
            <i id="sidebarToggleIcon" class="bi bi-chevron-left" aria-hidden="true"></i>
        </button>

        <script>
            window.syncSidebarControl = function () {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.getElementById('sidebarToggle');
                const icon = document.getElementById('sidebarToggleIcon');

                if (!sidebar || !toggle || !icon) {
                    return;
                }

                const isMobile = window.matchMedia('(max-width: 991.98px)').matches;
                const isOpen = isMobile
                    ? sidebar.classList.contains('show')
                    : !document.documentElement.classList.contains('sidebar-collapsed');

                icon.className = isOpen ? 'bi bi-chevron-left' : 'bi bi-chevron-right';
                toggle.setAttribute('aria-label', isOpen ? 'Tutup navigasi' : 'Buka navigasi');
                toggle.setAttribute('aria-expanded', String(isOpen));
                sidebar.inert = !isOpen;
            };

            window.syncSidebarControl();
        </script>

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
    <main id="page-content" tabindex="-1">

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
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const mobileQuery = window.matchMedia('(max-width: 991.98px)');
        const storageKey = 'esdm-sidebar-collapsed';

        function isMobile() {
            return mobileQuery.matches;
        }

        function persistCollapsed(collapsed) {
            try {
                localStorage.setItem(storageKey, String(collapsed));
            } catch (error) {}
        }

        function closeDrawer() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            window.syncSidebarControl();
        }

        function toggleDrawer() {
            if (sidebar.classList.contains('show')) {
                closeDrawer();

                return;
            }

            sidebar.classList.add('show');
            overlay.classList.add('show');
            window.syncSidebarControl();
        }

        function toggleSidebar() {
            if (isMobile()) {
                toggleDrawer();

                return;
            }

            const collapsed = document.documentElement.classList.toggle('sidebar-collapsed');
            persistCollapsed(collapsed);
            window.syncSidebarControl();
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeDrawer);

        function handleBreakpointChange() {
            closeDrawer();
        }

        if (mobileQuery.addEventListener) {
            mobileQuery.addEventListener('change', handleBreakpointChange);
        } else {
            mobileQuery.addListener(handleBreakpointChange);
        }

        sidebar.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (isMobile()) {
                    closeDrawer();
                }
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && sidebar.classList.contains('show')) {
                closeDrawer();
                toggleBtn.focus();
            }
        });
    })();

    document.addEventListener('DOMContentLoaded', function () {
        const validationSummary = Array.from(document.querySelectorAll('.alert-danger'))
            .find((alert) => alert.querySelector('ul li'));

        if (validationSummary) {
            validationSummary.setAttribute('tabindex', '-1');
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            } else {
                validationSummary.focus();
            }
        }
    });

    // Global delete confirmation
    function deleteConfirm(event, formId) {
        event.preventDefault();
        const label = event.currentTarget.dataset.deleteLabel || 'data ini';
        Swal.fire({
            title: `Hapus ${label}?`,
            text: 'Tindakan ini tidak dapat dibatalkan.',
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
