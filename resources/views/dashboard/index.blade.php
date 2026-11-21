@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
@php
    $hour = now()->hour;
    $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
    $totalKeseluruhan = array_sum($stats);
@endphp
<div class="dashboard-shell">

    <div class="dashboard-header section-spacer">
        <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-between gap-3">
            <div class="dashboard-header-copy">
                <div class="dashboard-overline">{{ $greeting }}, {{ auth()->user()->name }}</div>
                <h1>Ringkasan Data Wilayah IV</h1>
                <p>Pantau data operasional Dinas ESDM Sulawesi Utara dalam satu halaman.</p>
                <div class="dashboard-date">
                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
            <div class="dashboard-header-actions">
                <div class="dashboard-total-pill" title="Total seluruh data dari semua modul">
                    <span class="dashboard-total-value">{{ number_format($totalKeseluruhan, 0, ',', '.') }}</span>
                    <span class="dashboard-total-label">Total<br>Data</span>
                </div>
                <a href="{{ route('dashboard.analisis') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-map me-1" aria-hidden="true"></i> Lihat Analisis
                </a>
            </div>
        </div>
    </div>

    <section class="kpi-grid section-spacer" aria-label="Enam metrik utama dashboard">
        @foreach ([
            'wilayah' => ['route' => 'wilayah.index', 'title' => 'Data Wilayah', 'icon' => 'bi-map', 'accent' => '#2563EB', 'tint' => '#EFF6FF'],
            'usaha' => ['route' => 'usaha.index', 'title' => 'Usaha ESDM', 'icon' => 'bi-briefcase', 'accent' => '#0891B2', 'tint' => '#ECFEFF'],
            'mineral' => ['route' => 'mineral.index', 'title' => 'Mineral & Pertambangan', 'icon' => 'bi-gem', 'accent' => '#7C3AED', 'tint' => '#F5F3FF'],
            'energi' => ['route' => 'energi.index', 'title' => 'Energi & Ketenagalistrikan', 'icon' => 'bi-lightning', 'accent' => '#16A34A', 'tint' => '#F0FDF4'],
            'pengawasan' => ['route' => 'pengawasan.index', 'title' => 'Pengawasan', 'icon' => 'bi-shield-check', 'accent' => '#475569', 'tint' => '#F1F5F9'],
            'pad' => ['route' => 'pad.index', 'title' => 'Potensi PAD', 'icon' => 'bi-wallet2', 'accent' => '#D97706', 'tint' => '#FFFBEB'],
        ] as $key => $metric)
            <a href="{{ route($metric['route']) }}" class="kpi-card"
               style="--kpi-accent: {{ $metric['accent'] }}; --kpi-tint: {{ $metric['tint'] }};"
               aria-label="{{ $metric['title'] }}: {{ number_format($stats[$key], 0, ',', '.') }} data">
                <span class="kpi-card__icon" aria-hidden="true">
                    <i class="bi {{ $metric['icon'] }}"></i>
                </span>
                <span class="kpi-card__value">{{ number_format($stats[$key], 0, ',', '.') }}</span>
                <span class="kpi-card__label">{{ $metric['title'] }}</span>
            </a>
        @endforeach
    </section>

    <div class="row g-3 section-spacer">
        <div class="col-12">
            <div class="panel-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">
                                <i class="bi bi-bar-chart-line" aria-hidden="true"></i>
                                Grafik Data per Kabupaten
                            </div>
                            <div class="panel-subtitle">Perbandingan data utama berdasarkan wilayah kerja.</div>
                        </div>
                        <div class="chart-toolbar" role="group" aria-label="Filter dataset grafik">
                            <button type="button" class="chart-chip is-active" data-dataset="0" style="--chip: #2563EB;">
                                <span class="chip-dot" aria-hidden="true"></span>Usaha
                            </button>
                            <button type="button" class="chart-chip is-active" data-dataset="1" style="--chip: #1E40AF;">
                                <span class="chip-dot" aria-hidden="true"></span>Mineral
                            </button>
                            <button type="button" class="chart-chip is-active" data-dataset="2" style="--chip: #0891B2;">
                                <span class="chip-dot" aria-hidden="true"></span>Energi
                            </button>
                            <button type="button" class="chart-chip is-active" data-dataset="3" style="--chip: #64748B;">
                                <span class="chip-dot" aria-hidden="true"></span>Pengawasan
                            </button>
                        </div>
                    </div>
                    <div class="chart-preview @if(! $hasRegionalData) is-empty @endif">
                        @if($hasRegionalData)
                            <canvas id="chartKabupaten" aria-label="Grafik data per kabupaten" role="img"></canvas>
                        @else
                            <div class="dashboard-empty">
                                <i class="bi bi-bar-chart" aria-hidden="true"></i>
                                Belum ada data grafik wilayah.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="panel-card h-100">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-clock-history" aria-hidden="true"></i>
                        Aktivitas Terbaru
                    </div>
                    <div class="panel-subtitle">Pembaruan data terakhir dari setiap modul.</div>

                    @if ($recentActivities->isEmpty())
                        <div class="dashboard-empty">
                            <i class="bi bi-inbox" aria-hidden="true"></i>
                            Belum ada aktivitas terbaru.
                        </div>
                    @else
                        <div class="activity-feed">
                            @foreach ($recentActivities as $activity)
                                @include('partials.activity-item', ['activity' => $activity])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/json" id="dashboard-chart-data">@json($chartData)</script>
@endsection

@push('styles')
@vite(['resources/css/dashboard.css'])
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@vite(['resources/js/dashboard.js'])
@endpush
