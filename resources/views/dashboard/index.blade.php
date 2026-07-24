@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── STAT CARDS ──────────────────────────── */
    .stat-card {
        border: none;
        border-radius: 14px;
        padding: 1.4rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
        position: relative;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        right: -15px;
        top: -15px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    .stat-card .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-card .stat-icon i {
        font-size: 1.6rem;
        color: #fff;
    }

    .stat-card .stat-info {
        flex: 1;
        min-width: 0;
    }

    .stat-card .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-card .stat-label {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.85);
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-card .stat-footer {
        font-size: 0.7rem;
        color: rgba(255,255,255,0.7);
        margin-top: 0.35rem;
    }

    /* Warna card */
    .stat-card.card-blue    { background: linear-gradient(135deg, #0D6EFD, #0a58ca); }
    .stat-card.card-green   { background: linear-gradient(135deg, #198754, #146c43); }
    .stat-card.card-purple  { background: linear-gradient(135deg, #6f42c1, #5a359e); }
    .stat-card.card-orange  { background: linear-gradient(135deg, #fd7e14, #e96c0b); }
    .stat-card.card-teal    { background: linear-gradient(135deg, #0dcaf0, #0aadcf); }

    /* ── SECTION TITLE ──────────────────────── */
    .section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #0D6EFD;
    }

    /* ── CHART CARD ─────────────────────────── */
    .chart-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 1.5rem;
    }

    /* ── INFO CARD ──────────────────────────── */
    .info-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 1.5rem;
    }

    /* ── EMPTY STATE ────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state p {
        font-size: 0.82rem;
        margin: 0;
    }

    /* ── ACTIVITY LIST ──────────────────────── */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .activity-text {
        font-size: 0.82rem;
        color: #495057;
        line-height: 1.4;
    }

    .activity-time {
        font-size: 0.72rem;
        color: #adb5bd;
        margin-top: 0.15rem;
    }

    /* ── WELCOME BANNER ─────────────────────── */
    .welcome-banner {
        background: linear-gradient(135deg, #0D6EFD 0%, #0a3d8f 100%);
        border-radius: 14px;
        padding: 1.5rem 2rem;
        color: #fff;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .welcome-banner h2 {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .welcome-banner p {
        font-size: 0.82rem;
        opacity: 0.85;
        margin: 0;
    }

    .welcome-banner .banner-icon {
        font-size: 3rem;
        opacity: 0.3;
        flex-shrink: 0;
    }

    @media (max-width: 575.98px) {
        .welcome-banner .banner-icon { display: none; }
        .welcome-banner { padding: 1.25rem; }
    }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div>
        <h2>Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
        <p>
            <i class="bi bi-calendar3 me-1"></i>
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            &nbsp;|&nbsp;
            <i class="bi bi-shield-fill me-1"></i>
            {{ Auth::user()->role?->nama_role ?? 'Pengguna' }}
        </p>
    </div>
    <i class="bi bi-lightning-charge-fill banner-icon"></i>
</div>

{{-- ── STAT CARDS ──────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Data Wilayah --}}
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card card-blue">
            <div class="stat-icon">
                <i class="bi bi-map-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['wilayah']) }}</div>
                <div class="stat-label">Data Wilayah</div>
                <div class="stat-footer">
                    <i class="bi bi-geo-alt me-1"></i>Sangihe · Talaud · Sitaro
                </div>
            </div>
        </div>
    </div>

    {{-- Usaha ESDM --}}
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card card-green">
            <div class="stat-icon">
                <i class="bi bi-briefcase-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['usaha']) }}</div>
                <div class="stat-label">Data Usaha ESDM</div>
                <div class="stat-footer">
                    <i class="bi bi-building me-1"></i>Pelaku usaha terdaftar
                </div>
            </div>
        </div>
    </div>

    {{-- Mineral & Pertambangan --}}
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card card-purple">
            <div class="stat-icon">
                <i class="bi bi-gem"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['mineral']) }}</div>
                <div class="stat-label">Mineral & Pertambangan</div>
                <div class="stat-footer">
                    <i class="bi bi-layers me-1"></i>Data komoditas mineral
                </div>
            </div>
        </div>
    </div>

    {{-- Energi & Ketenagalistrikan --}}
    <div class="col-sm-6 col-xl-6">
        <div class="stat-card card-orange">
            <div class="stat-icon">
                <i class="bi bi-plug-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['energi']) }}</div>
                <div class="stat-label">Energi & Ketenagalistrikan</div>
                <div class="stat-footer">
                    <i class="bi bi-lightning me-1"></i>Data infrastruktur energi
                </div>
            </div>
        </div>
    </div>

    {{-- Pengawasan --}}
    <div class="col-sm-6 col-xl-6">
        <div class="stat-card card-teal">
            <div class="stat-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['pengawasan']) }}</div>
                <div class="stat-label">Pengawasan</div>
                <div class="stat-footer">
                    <i class="bi bi-clipboard-check me-1"></i>Laporan pemantauan lapangan
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── CHART + INFO ─────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Bar Chart --}}
    <div class="col-lg-8">
        <div class="chart-card h-100">
            <div class="section-title">
                <i class="bi bi-bar-chart-fill"></i>
                Distribusi Data per Kabupaten
            </div>
            <canvas id="chartKabupaten" height="260"></canvas>
        </div>
    </div>

    {{-- Info Panel --}}
    <div class="col-lg-4">
        <div class="info-card h-100">
            <div class="section-title">
                <i class="bi bi-info-circle-fill"></i>
                Informasi Wilayah Kerja
            </div>

            <ul class="list-group list-group-flush">
                @php
                    $wilayas = [
                        ['nama' => 'Kab. Kepulauan Sangihe', 'icon' => 'bi-geo-alt-fill', 'color' => 'text-primary'],
                        ['nama' => 'Kab. Kepulauan Talaud',  'icon' => 'bi-geo-alt-fill', 'color' => 'text-success'],
                        ['nama' => 'Kab. Kepulauan Sitaro',  'icon' => 'bi-geo-alt-fill', 'color' => 'text-purple'],
                    ];
                @endphp
                @foreach ($wilayas as $w)
                <li class="list-group-item px-0 py-2 border-0 border-bottom d-flex align-items-center gap-2">
                    <i class="bi {{ $w['icon'] }} {{ $w['color'] }}" style="color: {{ $loop->index === 2 ? '#6f42c1' : '' }}"></i>
                    <span style="font-size:0.85rem;">{{ $w['nama'] }}</span>
                </li>
                @endforeach
            </ul>

            <div class="mt-3 p-3 rounded-3" style="background:#f8f9fa;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-clock-history text-primary"></i>
                    <span style="font-size:0.82rem; font-weight:600;">Sesi Login</span>
                </div>
                <div style="font-size:0.8rem; color:#6c757d;">
                    <div><i class="bi bi-person me-1"></i>{{ Auth::user()->name }}</div>
                    <div><i class="bi bi-envelope me-1"></i>{{ Auth::user()->email }}</div>
                    <div><i class="bi bi-shield me-1"></i>{{ Auth::user()->role?->nama_role ?? '-' }}</div>
                    <div><i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── AKTIVITAS TERBARU ────────────────────── --}}
<div class="row g-3">
    <div class="col-12">
        <div class="info-card">
            <div class="section-title">
                <i class="bi bi-activity"></i>
                Aktivitas Terbaru
            </div>

            {{-- Empty state — akan diisi data nyata setelah modul data selesai --}}
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Belum ada aktivitas data yang tercatat.<br>Data akan muncul setelah modul-modul data dikembangkan.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const labels    = @json($chartData['labels']);
    const dataUsaha = @json($chartData['usaha']);
    const dataMiner = @json($chartData['mineral']);
    const dataEner  = @json($chartData['energi']);
    const dataPengw = @json($chartData['pengawasan']);

    const ctx = document.getElementById('chartKabupaten').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Usaha ESDM',
                    data: dataUsaha,
                    backgroundColor: 'rgba(25, 135, 84, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Mineral',
                    data: dataMiner,
                    backgroundColor: 'rgba(111, 66, 193, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Energi',
                    data: dataEner,
                    backgroundColor: 'rgba(253, 126, 20, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Pengawasan',
                    data: dataPengw,
                    backgroundColor: 'rgba(13, 202, 240, 0.8)',
                    borderRadius: 6,
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
                        font: { family: 'Poppins', size: 11 },
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
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
                        maxRotation: 0,
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
                        color: 'rgba(0,0,0,0.05)',
                    }
                }
            }
        }
    });
</script>
@endpush
