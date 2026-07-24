@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@php
    $activityRows = [
        ['time' => '10 menit lalu', 'module' => 'Data Wilayah', 'action' => 'Menambahkan data desa', 'detail' => 'Desa Taloarane, Kabupaten Kepulauan Sangihe', 'user' => 'Operator Wilayah', 'status' => 'Selesai'],
        ['time' => '25 menit lalu', 'module' => 'Usaha ESDM', 'action' => 'Memperbarui status izin', 'detail' => 'PT Sangihe Energi Mandiri', 'user' => 'Administrator', 'status' => 'Diproses'],
        ['time' => '1 jam lalu', 'module' => 'Pengawasan', 'action' => 'Input hasil pemantauan', 'detail' => 'Tambang Pasir Besi, Manganitu', 'user' => 'Tim Pengawas', 'status' => 'Selesai'],
        ['time' => '2 jam lalu', 'module' => 'Energi', 'action' => 'Menambah data infrastruktur', 'detail' => 'PLTS Komunal, Desa Taloarane', 'user' => 'Operator Energi', 'status' => 'Selesai'],
        ['time' => 'Kemarin', 'module' => 'Potensi PAD', 'action' => 'Menyusun estimasi penerimaan', 'detail' => 'Sangihe, Triwulan III 2026', 'user' => 'Admin Keuangan', 'status' => 'Draft'],
    ];

    $dummyMarkers = [
        ['name' => 'Kabupaten Kepulauan Sangihe', 'lat' => 3.6236, 'lng' => 125.4678, 'info' => 'Jenis data: Data wilayah dan layanan administrasi'],
        ['name' => 'Kabupaten Kepulauan Talaud', 'lat' => 4.1005, 'lng' => 126.7802, 'info' => 'Jenis data: Pengawasan dan potensi energi'],
        ['name' => 'Kabupaten Kepulauan Siau Tagulandang Biaro', 'lat' => 2.7428, 'lng' => 125.3952, 'info' => 'Jenis data: Infrastruktur energi dan mineral'],
    ];

    $workAreas = [
        ['name' => 'Kab. Kepulauan Sangihe', 'color' => 'primary', 'note' => 'Pusat data wilayah Sangihe'],
        ['name' => 'Kab. Kepulauan Talaud', 'color' => 'success', 'note' => 'Pengawasan dan potensi energi'],
        ['name' => 'Kab. Kepulauan Sitaro', 'color' => 'info', 'note' => 'Infrastruktur energi dan mineral'],
    ];
@endphp

@push('styles')
<style>
    :root {
        --dash-primary: #2563EB;
        --dash-secondary: #1E40AF;
        --dash-success: #16A34A;
        --dash-warning: #F59E0B;
        --dash-danger: #DC2626;
        --dash-info: #0EA5E9;
        --dash-bg: #F5F7FB;
        --dash-card: #FFFFFF;
        --dash-border: #E5E7EB;
        --dash-text: #1F2937;
        --dash-text-muted: #6B7280;
        --dash-radius: 18px;
        --dash-shadow: 0 8px 24px rgba(15,23,42,.06);
        --dash-shadow-hover: 0 14px 34px rgba(15,23,42,.10);
    }

    .dashboard-shell {
        color: var(--dash-text);
    }

    .dashboard-header {
        background:
            radial-gradient(circle at top right, rgba(37,99,235,.10), transparent 34%),
            linear-gradient(135deg, #ffffff, #f8fbff);
        border-radius: 20px;
        padding: 1.35rem 1.5rem;
        margin-bottom: 1.35rem;
        box-shadow: var(--dash-shadow);
    }

    .dashboard-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--dash-text);
    }

    .dashboard-header p {
        margin: .35rem 0 0;
        color: var(--dash-text-muted);
        font-size: .88rem;
    }

    .dashboard-date {
        color: #374151;
        font-size: .88rem;
        font-weight: 600;
    }

    .section-spacer {
        margin-bottom: 1.35rem;
    }

    .stat-card {
        border: none;
        border-radius: 18px;
        background: var(--dash-card);
        box-shadow: var(--dash-shadow);
        transition: transform .3s ease, box-shadow .3s ease;
        height: 100%;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--dash-shadow-hover);
    }

    .stat-card .card-body {
        padding: 1rem 1.05rem;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .stat-icon i {
        font-size: 1.2rem;
    }

    .stat-title {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--dash-text-muted);
    }

    .stat-value {
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--dash-text);
        line-height: 1.05;
    }

    .stat-desc {
        font-size: .76rem;
        color: var(--dash-text-muted);
    }

    .stat-updated {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        color: var(--dash-text-muted);
        font-size: .68rem;
        margin-top: .35rem;
    }

    .panel-card {
        border: none;
        border-radius: 20px;
        background: var(--dash-card);
        box-shadow: var(--dash-shadow);
        height: 100%;
        overflow: hidden;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .panel-card:hover,
    .welcome-card:hover,
    .work-area-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--dash-shadow-hover);
    }

    .panel-card .card-body {
        padding: 1.25rem;
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .98rem;
        font-weight: 700;
        color: var(--dash-text);
        margin-bottom: .3rem;
    }

    .panel-subtitle {
        color: var(--dash-text-muted);
        font-size: .82rem;
        margin-bottom: 1rem;
    }

    .panel-title i {
        color: var(--dash-primary);
    }

    .welcome-card {
        border: none;
        border-radius: 20px;
        background:
            radial-gradient(circle at 96% 14%, rgba(14,165,233,.18), transparent 30%),
            linear-gradient(135deg, var(--dash-primary), var(--dash-secondary));
        box-shadow: var(--dash-shadow);
        overflow: hidden;
        color: #fff;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .welcome-card .card-body {
        padding: 1.35rem;
    }

    .welcome-figure {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        background: rgba(255,255,255,.16);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .welcome-meta {
        color: rgba(255,255,255,.78);
        font-size: .86rem;
        line-height: 1.7;
    }

    .map-preview {
        min-height: 390px;
        border-radius: 16px;
        overflow: hidden;
        background: #F8FAFC;
        border: 1px solid rgba(229,231,235,.65);
    }

    .map-preview #dashboardMap {
        width: 100%;
        height: 100%;
        min-height: 390px;
    }

    .chart-preview {
        height: 410px;
    }

    .welcome-actions .btn {
        border-radius: 999px;
        padding: .45rem .75rem;
        font-size: .78rem;
        box-shadow: none;
    }

    .welcome-actions .btn-light {
        color: var(--dash-primary);
        border: none;
    }

    .welcome-actions .btn-outline-light {
        border-color: rgba(255,255,255,.38);
        color: #fff;
    }

    .work-area-card {
        border: none;
        border-radius: 18px;
        background: #fff;
        box-shadow: var(--dash-shadow);
        transition: transform .3s ease, box-shadow .3s ease;
        overflow: hidden;
    }

    .work-area-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: .95rem 0;
        border-bottom: 1px solid rgba(229,231,235,.72);
    }

    .work-area-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .work-area-icon {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        background: rgba(37,99,235,.10);
        color: var(--dash-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-timeline {
        position: relative;
        display: grid;
        gap: 1rem;
        margin-top: 1rem;
    }

    .timeline-item {
        display: grid;
        grid-template-columns: 34px 1fr auto;
        gap: .85rem;
        align-items: flex-start;
    }

    .timeline-dot {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: var(--dash-primary);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(37,99,235,.18);
    }

    .timeline-content {
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(229,231,235,.72);
    }

    .timeline-item:last-child .timeline-content {
        border-bottom: none;
        padding-bottom: 0;
    }

    .timeline-title {
        font-weight: 700;
        color: var(--dash-text);
        font-size: .9rem;
    }

    .timeline-detail {
        color: var(--dash-text-muted);
        font-size: .8rem;
        margin-top: .2rem;
    }

    .status-badge {
        border-radius: 999px;
        padding: .34rem .58rem;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .activity-table {
        margin-bottom: 0;
    }

    .activity-table thead th {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--dash-text-muted);
        background: #F8FAFC;
        border-bottom: 1px solid var(--dash-border);
    }

    .activity-table tbody td {
        vertical-align: middle;
        font-size: .88rem;
        border-bottom-color: rgba(229,231,235,.72);
    }

    .activity-table tbody tr:hover {
        background: #F8FAFC;
    }

    .module-pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .6rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
    }

    .module-pill.primary { background: rgba(37,99,235,.10); color: var(--dash-primary); }
    .module-pill.success { background: rgba(22,163,74,.10); color: var(--dash-success); }
    .module-pill.warning { background: rgba(245,158,11,.12); color: #B45309; }
    .module-pill.info { background: rgba(14,165,233,.12); color: var(--dash-info); }
    .module-pill.danger { background: rgba(220,38,38,.10); color: var(--dash-danger); }

    .status-badge.done,
    .status-badge.selesai { background: rgba(22,163,74,.10); color: var(--dash-success); }
    .status-badge.progress,
    .status-badge.diproses { background: rgba(14,165,233,.12); color: var(--dash-info); }
    .status-badge.draft { background: rgba(245,158,11,.12); color: #B45309; }

    .fade-in {
        animation: fadeInUp .35s ease both;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .leaflet-control-attribution,
    .leaflet-control-zoom {
        box-shadow: none !important;
    }

    .leaflet-container {
        font-family: 'Poppins', sans-serif;
    }

    @media (max-width: 575.98px) {
        .dashboard-header,
        .panel-card .card-body,
        .welcome-card .card-body {
            padding: 1rem;
        }

        .map-preview,
        .map-preview #dashboardMap {
            min-height: 350px;
        }

        .chart-preview {
            height: 340px;
        }

        .timeline-item {
            grid-template-columns: 30px 1fr;
        }

        .timeline-item .status-badge {
            grid-column: 2;
            justify-self: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-shell">
    <div class="dashboard-header fade-in section-spacer">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <div>
                <h1>Dashboard</h1>
                <p>Ringkasan data operasional Wilayah IV Dinas ESDM Sulawesi Utara.</p>
            </div>
            <div class="text-md-end dashboard-date">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>

    <div class="row g-3 section-spacer">
        <div class="col-sm-6 col-xl">
            <div class="stat-card fade-in">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--dash-primary), var(--dash-secondary));">
                        <i class="bi bi-map-fill"></i>
                    </div>
                    <div>
                        <div class="stat-title">Data Wilayah</div>
                        <div class="stat-value">{{ number_format($stats['wilayah']) }}</div>
                        <div class="stat-desc">Wilayah desa yang terdata</div>
                        <div class="stat-updated"><i class="bi bi-clock"></i> Terakhir diperbarui hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl">
            <div class="stat-card fade-in">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--dash-primary), var(--dash-info));">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div>
                        <div class="stat-title">Usaha ESDM</div>
                        <div class="stat-value">{{ number_format($stats['usaha']) }}</div>
                        <div class="stat-desc">Pelaku usaha aktif terdaftar</div>
                        <div class="stat-updated"><i class="bi bi-clock"></i> Terakhir diperbarui hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl">
            <div class="stat-card fade-in">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #1D4ED8, #2563EB);">
                        <i class="bi bi-gem"></i>
                    </div>
                    <div>
                        <div class="stat-title">Mineral & Pertambangan</div>
                        <div class="stat-value">{{ number_format($stats['mineral']) }}</div>
                        <div class="stat-desc">Data komoditas mineral</div>
                        <div class="stat-updated"><i class="bi bi-clock"></i> Terakhir diperbarui hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl">
            <div class="stat-card fade-in">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--dash-info), #0284C7);">
                        <i class="bi bi-plug-fill"></i>
                    </div>
                    <div>
                        <div class="stat-title">Energi & Ketenagalistrikan</div>
                        <div class="stat-value">{{ number_format($stats['energi']) }}</div>
                        <div class="stat-desc">Infrastruktur energi yang terdata</div>
                        <div class="stat-updated"><i class="bi bi-clock"></i> Terakhir diperbarui hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl">
            <div class="stat-card fade-in">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #64748B, #334155);">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <div class="stat-title">Pengawasan</div>
                        <div class="stat-value">{{ number_format($stats['pengawasan']) }}</div>
                        <div class="stat-desc">Laporan pemantauan lapangan</div>
                        <div class="stat-updated"><i class="bi bi-clock"></i> Terakhir diperbarui hari ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome-card fade-in section-spacer">
        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div class="d-flex align-items-start gap-3">
                <div class="welcome-figure">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">Halo, {{ Auth::user()->name }}</h4>
                    <div class="welcome-meta">
                        Selamat datang kembali di Sistem Informasi ESDM Wilayah IV.
                    </div>
                </div>
            </div>
            <div class="welcome-actions d-flex flex-wrap gap-2">
                <a href="{{ route('wilayah.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-map me-1"></i> Data Wilayah
                </a>
                <a href="{{ route('laporan.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-file-earmark-bar-graph me-1"></i> Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3 section-spacer">
        <div class="col-xl-7">
            <div class="panel-card fade-in">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-bar-chart-fill"></i>
                        Grafik Data per Kabupaten
                    </div>
                    <div class="panel-subtitle">Perbandingan data utama berdasarkan wilayah kerja.</div>
                    <div class="chart-preview">
                        <canvas id="chartKabupaten"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="panel-card fade-in">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-geo-alt-fill"></i>
                        Preview Peta Digital
                    </div>
                    <div class="panel-subtitle">Lokasi indikator wilayah kerja Cabang Dinas Wilayah IV.</div>
                    <div class="map-preview">
                        <div id="dashboardMap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-7">
            <div class="panel-card fade-in">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-clock-history"></i>
                        Aktivitas Terbaru
                    </div>
                    <div class="panel-subtitle">Ringkasan aktivitas operasional terbaru.</div>
                    <div class="activity-timeline">
                        @foreach ($activityRows as $row)
                            @php
                                $pillClass = match ($row['module']) {
                                    'Data Wilayah' => 'primary',
                                    'Usaha ESDM' => 'success',
                                    'Pengawasan' => 'danger',
                                    'Energi' => 'info',
                                    default => 'warning',
                                };

                                $statusClass = strtolower($row['status']);
                            @endphp
                            <div class="timeline-item">
                                <div class="timeline-dot">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <span class="module-pill {{ $pillClass }}">{{ $row['module'] }}</span>
                                        <span class="text-secondary small">{{ $row['time'] }}</span>
                                    </div>
                                    <div class="timeline-title">{{ $row['action'] }}</div>
                                    <div class="timeline-detail">{{ $row['detail'] }} oleh {{ $row['user'] }}</div>
                                </div>
                                <span class="status-badge {{ $statusClass }}">{{ $row['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="work-area-card fade-in">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-pin-map-fill"></i>
                        Informasi Wilayah
                    </div>
                    <div class="panel-subtitle">Wilayah kerja aktif dalam pengelolaan data ESDM.</div>
                    @foreach ($workAreas as $area)
                        <div class="work-area-item">
                            <div class="d-flex align-items-start gap-3">
                                <div class="work-area-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $area['name'] }}</div>
                                    <div class="text-secondary small">{{ $area['note'] }}</div>
                                </div>
                            </div>
                            <span class="module-pill {{ $area['color'] }}">Aktif</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const labels = @json($chartData['labels']);
    const dataUsaha = @json($chartData['usaha']);
    const dataMiner = @json($chartData['mineral']);
    const dataEner = @json($chartData['energi']);
    const dataPengw = @json($chartData['pengawasan']);

    const chartCtx = document.getElementById('chartKabupaten').getContext('2d');

    new Chart(chartCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Usaha ESDM',
                    data: dataUsaha,
                    backgroundColor: 'rgba(37, 99, 235, 0.82)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Mineral',
                    data: dataMiner,
                    backgroundColor: 'rgba(30, 64, 175, 0.72)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Energi',
                    data: dataEner,
                    backgroundColor: 'rgba(14, 165, 233, 0.72)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Pengawasan',
                    data: dataPengw,
                    backgroundColor: 'rgba(100, 116, 139, 0.58)',
                    borderRadius: 8,
                    borderSkipped: false,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { family: 'Poppins', size: 11 },
                        padding: 16,
                    }
                },
                tooltip: {
                    bodyFont: { family: 'Poppins', size: 12 },
                    titleFont: { family: 'Poppins', size: 12 },
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Poppins', size: 11 },
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { family: 'Poppins', size: 11 },
                        stepSize: 1,
                        precision: 0,
                    },
                    grid: {
                        color: 'rgba(17,24,39,0.06)',
                    }
                }
            }
        }
    });

    const map = L.map('dashboardMap', {
        scrollWheelZoom: false
    }).setView([3.6236, 125.4678], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markers = @json($dummyMarkers);

    markers.forEach((marker) => {
        L.marker([marker.lat, marker.lng]).addTo(map)
            .bindPopup(`<strong>${marker.name}</strong><br>${marker.info}`);
    });
</script>
@endpush
