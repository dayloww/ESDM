@extends('layouts.app')

@section('title', 'Detail Ketenagalistrikan')
@section('page-title', 'Detail Ketenagalistrikan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ketenagalistrikan.index') }}">Ketenagalistrikan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')

{{-- Tombol atas --}}
<div class="d-flex gap-2 mb-3">
    <a href="{{ route('ketenagalistrikan.index') }}" class="btn btn-secondary btn-sm">
        <i aria-hidden="true" class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('ketenagalistrikan.edit', $energi->id) }}" class="btn btn-warning btn-sm">
        <i aria-hidden="true" class="bi bi-pencil"></i> Edit
    </a>
</div>

{{-- ── INFORMASI UMUM ──────────────────────────────────────────── --}}
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-info-circle-fill text-primary"></i>
        <h6 class="mb-0 fw-semibold">Informasi Umum</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Jenis Usaha</div>
                <div class="fw-semibold mt-1">
                    <span class="badge bg-info text-dark fs-6 fw-normal">UPTL</span>
                    <div class="text-muted small mt-1">Usaha Penunjang Tenaga Listrik</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Desa / Lokasi</div>
                <div class="fw-semibold mt-1">{{ $energi->desa ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Status</div>
                <div class="mt-1">
                    @if($energi->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($energi->status === 'nonaktif')
                        <span class="badge bg-secondary">Nonaktif</span>
                    @elseif($energi->status === 'habis')
                        <span class="badge bg-danger">Habis</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── INFORMASI UPTL ──────────────────────────────────────────── --}}
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-building-fill text-info"></i>
        <h6 class="mb-0 fw-semibold">Informasi UPTL</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Nomor Izin</div>
                <div class="fw-semibold mt-1">{{ $energi->nomor_izin ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Nama Badan Usaha</div>
                <div class="fw-semibold mt-1">{{ $energi->nama_badan_usaha ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">NIB</div>
                <div class="fw-semibold mt-1">{{ $energi->nib ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Penanggung Jawab</div>
                <div class="fw-semibold mt-1">{{ $energi->penanggung_jawab ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jenis Usaha Penunjang</div>
                <div class="fw-semibold mt-1">{{ $energi->jenis_usaha_penunjang ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Bidang Kegiatan</div>
                <div class="fw-semibold mt-1">{{ $energi->bidang_kegiatan ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Klasifikasi Usaha</div>
                <div class="fw-semibold mt-1">{{ $energi->klasifikasi_usaha ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── LOKASI ──────────────────────────────────────────────────── --}}
@if($energi->latitude || $energi->longitude)
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-geo-alt-fill text-danger"></i>
        <h6 class="mb-0 fw-semibold">Lokasi / Koordinat</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted small">Latitude</div>
                <div class="fw-semibold mt-1">{{ $energi->latitude ?: '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Longitude</div>
                <div class="fw-semibold mt-1">{{ $energi->longitude ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── PERIZINAN ───────────────────────────────────────────────── --}}
@if($energi->tanggal_terbit || $energi->masa_berlaku || $energi->status)
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-calendar2-check-fill text-success"></i>
        <h6 class="mb-0 fw-semibold">Perizinan</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Tanggal Terbit</div>
                <div class="fw-semibold mt-1">
                    {{ $energi->tanggal_terbit ? $energi->tanggal_terbit->format('d/m/Y') : '-' }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Masa Berlaku</div>
                <div class="fw-semibold mt-1">
                    {{ $energi->masa_berlaku ? $energi->masa_berlaku->format('d/m/Y') : '-' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── INFORMASI TAMBAHAN ──────────────────────────────────────── --}}
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-card-text text-secondary"></i>
        <h6 class="mb-0 fw-semibold">Informasi Tambahan</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @if($energi->keterangan)
            <div class="col-md-6">
                <div class="text-muted small">Keterangan</div>
                <div class="mt-1">{{ $energi->keterangan }}</div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="text-muted small">Dokumentasi</div>
                <div class="mt-1">
                    @if($energi->dokumentasi)
                        <a href="{{ asset('storage/' . $energi->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-sm">
                            <i aria-hidden="true" class="bi bi-file-earmark-arrow-down"></i> Lihat / Unduh Dokumentasi
                        </a>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Diinput pada</div>
                <div class="mt-1 text-muted small">{{ $energi->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol bawah --}}
<div class="d-flex gap-2">
    <a href="{{ route('ketenagalistrikan.index') }}" class="btn btn-secondary btn-sm">
        <i aria-hidden="true" class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('ketenagalistrikan.edit', $energi->id) }}" class="btn btn-warning btn-sm">
        <i aria-hidden="true" class="bi bi-pencil"></i> Edit
    </a>
</div>

@endsection
