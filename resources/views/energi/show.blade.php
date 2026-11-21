@extends('layouts.app')

@section('title', 'Detail Energi')
@section('page-title', 'Detail Energi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('energi.index') }}">Energi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')

{{-- Tombol atas --}}
<div class="d-flex gap-2 mb-3">
    <a href="{{ route('energi.index') }}" class="btn btn-secondary btn-sm">
        <i aria-hidden="true" class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('energi.edit', $energi->id) }}" class="btn btn-warning btn-sm">
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
                    @if($energi->jenis_usaha === 'IUPTLS')
                        <span class="badge bg-primary fs-6 fw-normal">IUPTLS</span>
                        <div class="text-muted small mt-1">Izin Usaha Penyediaan Tenaga Listrik untuk Kepentingan Sendiri</div>
                    @elseif($energi->jenis_usaha === 'UPTL')
                        <span class="badge bg-info text-dark fs-6 fw-normal">UPTL</span>
                        <div class="text-muted small mt-1">Usaha Penunjang Tenaga Listrik</div>
                    @elseif($energi->jenis_usaha)
                        <span class="badge bg-secondary fs-6 fw-normal">{{ $energi->jenis_usaha }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
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

{{-- ── INFORMASI IUPTLS ────────────────────────────────────────── --}}
@if($energi->jenis_usaha === 'IUPTLS')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-file-earmark-check-fill text-primary"></i>
        <h6 class="mb-0 fw-semibold">Informasi IUPTLS</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Nomor Izin</div>
                <div class="fw-semibold mt-1">{{ $energi->nomor_izin ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Nama Pemegang Izin</div>
                <div class="fw-semibold mt-1">{{ $energi->nama_pemegang_izin ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">NIB</div>
                <div class="fw-semibold mt-1">{{ $energi->nib ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Badan Usaha / Instansi</div>
                <div class="fw-semibold mt-1">{{ $energi->badan_usaha ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jenis Pembangkit</div>
                <div class="fw-semibold mt-1">{{ $energi->jenis_pembangkit ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Sumber Energi</div>
                <div class="fw-semibold mt-1">{{ $energi->sumber_energi ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Kapasitas</div>
                <div class="fw-semibold mt-1">{{ $energi->kapasitas ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jumlah Unit</div>
                <div class="fw-semibold mt-1">{{ $energi->jumlah_unit ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jaringan</div>
                <div class="fw-semibold mt-1">{{ $energi->jaringan ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── LAINNYA (tidak spesifik IUPTLS/UPTL) ───────────────────── --}}
@if(!in_array($energi->jenis_usaha, ['IUPTLS', 'UPTL']) && ($energi->sumber_energi || $energi->kapasitas || $energi->jaringan))
<div class="card mb-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i aria-hidden="true" class="bi bi-lightning-fill text-warning"></i>
        <h6 class="mb-0 fw-semibold">Informasi Energi</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Sumber Energi</div>
                <div class="fw-semibold mt-1">{{ $energi->sumber_energi ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Kapasitas</div>
                <div class="fw-semibold mt-1">{{ $energi->kapasitas ?: '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jaringan</div>
                <div class="fw-semibold mt-1">{{ $energi->jaringan ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endif

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
            <div class="col-md-6">
                <div class="text-muted small">Potensi EBT</div>
                <div class="mt-1">{{ $energi->potensi_ebt ?: '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Permasalahan</div>
                <div class="mt-1">{{ $energi->permasalahan ?: '-' }}</div>
            </div>
            @if($energi->kondisi_infrastruktur)
            <div class="col-md-6">
                <div class="text-muted small">Kondisi Infrastruktur</div>
                <div class="mt-1">{{ $energi->kondisi_infrastruktur }}</div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="text-muted small">Keterangan</div>
                <div class="mt-1">{{ $energi->keterangan ?: '-' }}</div>
            </div>
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
    <a href="{{ route('energi.index') }}" class="btn btn-secondary btn-sm">
        <i aria-hidden="true" class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('energi.edit', $energi->id) }}" class="btn btn-warning btn-sm">
        <i aria-hidden="true" class="bi bi-pencil"></i> Edit
    </a>
</div>

@endsection
