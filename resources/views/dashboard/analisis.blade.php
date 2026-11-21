@extends('layouts.app')

@section('title', 'Analisis Data')
@section('page-title', 'Analisis Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Analisis</li>
@endsection

@section('content')
@php($totalKeseluruhan = array_sum($stats))
<div class="dashboard-shell">
    <div class="dashboard-header section-spacer">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="dashboard-overline">Wilayah IV — Sulawesi Utara</div>
                <h1>Analisis &amp; Sebaran Data</h1>
                <p>Lihat komposisi data per modul dan sebaran titik lokasi di wilayah kerja.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary align-self-md-end">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke ringkasan
            </a>
        </div>
    </div>

    <div class="row g-3 section-spacer">
        <div class="col-xl-7">
            <div class="panel-card h-100">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-geo-alt"></i>
                        Sebaran Data Wilayah
                    </div>
                    <div class="panel-subtitle">Titik lokasi dari koordinat data yang tersedia.</div>
                    <div class="map-preview">
                        <div id="dashboardMap"></div>
                    </div>
                    @if (empty($mapMarkers))
                        <p class="text-muted small mt-2 mb-0">Belum ada koordinat valid untuk ditampilkan pada peta.</p>
                    @endif

                    @if (! empty($mapMarkers))
                        <div class="map-legend" aria-label="Legenda sebaran data">
                            <span class="map-legend-item">
                                <span class="map-legend-dot" style="--legend-color: #2563EB;" aria-hidden="true"></span>
                                Data wilayah
                            </span>
                            <span class="map-legend-item">
                                <span class="map-legend-dot" style="--legend-color: #0891B2;" aria-hidden="true"></span>
                                Usaha ESDM
                            </span>
                            <span class="map-legend-count">{{ count($mapMarkers) }} titik</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="panel-card h-100">
                <div class="card-body">
                    <div class="panel-title">
                        <i class="bi bi-pie-chart"></i>
                        Komposisi &amp; Informasi Wilayah
                    </div>
                    <div class="panel-subtitle">Proporsi data per modul dan sebaran per wilayah kerja.</div>

                    @if ($totalKeseluruhan > 0)
                        <div class="donut-wrap">
                            <canvas id="chartKomposisi" aria-label="Grafik komposisi data per modul" role="img"></canvas>
                        </div>
                    @else
                        <div class="dashboard-empty">
                            <i class="bi bi-pie-chart"></i>
                            Belum ada data untuk ditampilkan.
                        </div>
                    @endif

                    <div class="region-divider"></div>

                    <div class="region-list">
                        @forelse ($regionalSummary as $region)
                            <div class="region-item">
                                <span class="region-icon"><i class="bi bi-geo-alt"></i></span>
                                <span class="region-info min-w-0">
                                    <span class="region-name d-block">{{ $region['name'] }}</span>
                                    <span class="region-meta d-block">{{ $region['meta'] }}</span>
                                    <span class="region-progress" aria-hidden="true">
                                        <span class="region-progress-fill" style="width: {{ $region['percent'] }}%;"></span>
                                    </span>
                                </span>
                                <span class="region-total">
                                    <span class="region-total-value d-block">{{ number_format($region['total'], 0, ',', '.') }}</span>
                                    <span class="region-total-label">Total Data</span>
                                </span>
                            </div>
                        @empty
                            <div class="dashboard-empty">
                                <i class="bi bi-geo"></i>
                                Belum ada data wilayah.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/json" id="dashboard-map-data">@json(['markers' => $mapMarkers])</script>
<script type="application/json" id="dashboard-composition-data">@json($compositionData)</script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
@vite(['resources/css/dashboard.css'])
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
@vite(['resources/js/dashboard.js'])
@endpush
