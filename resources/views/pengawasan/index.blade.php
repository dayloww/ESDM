@extends('layouts.app')

@section('title', 'Pengawasan')
@section('page-title', 'Pengawasan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengawasan</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'status', 'label' => 'Status', 'options' => $statusOptions],
        ['name' => 'tanggal_dari', 'label' => 'Dari Tanggal', 'type' => 'date'],
        ['name' => 'tanggal_sampai', 'label' => 'Sampai Tanggal', 'type' => 'date'],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Laporan Pengawasan Lapangan</h5>
        @include('partials.create-button', ['route' => 'pengawasan.create', 'label' => 'Tambah Pengawasan'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'pengawasan.index', 'filters' => $filters])

        @if ($pengawasans->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pengawasanTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Petugas</th>
                            <th>Objek Pengawasan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Temuan</th>
                            <th>Rekomendasi</th>
                            <th>Dokumentasi</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengawasans as $p)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td>{{ $p->petugas }}</td>
                                <td><strong>{{ $p->objek }}</strong></td>
                                <td>{{ $p->lokasi }}</td>
                                <td>
                                    @if($p->status == 'selesai')
                                        @include('partials.status-badge', ['status' => 'selesai'])
                                    @elseif($p->status == 'dalam_proses')
                                        @include('partials.status-badge', ['status' => 'dalam_proses', 'label' => 'Dalam Proses'])
                                    @else
                                        @include('partials.status-badge', ['status' => 'tertunda'])
                                    @endif
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $p->temuan }}">
                                        {{ $p->temuan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $p->rekomendasi }}">
                                        {{ $p->rekomendasi ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->dokumentasi)
                                        <a href="{{ asset('storage/' . $p->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-sm table-file-link" aria-label="Unduh dokumentasi {{ $p->objek }}" title="Unduh dokumentasi {{ $p->objek }}">
                                            <i class="bi bi-file-earmark-image"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $p->id,
                                        'label' => $p->objek,
                                        'editRoute' => 'pengawasan.edit',
                                        'deleteRoute' => 'pengawasan.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'laporan pengawasan',
                'createRoute' => 'pengawasan.create',
                'createLabel' => 'Tambah Pengawasan',
            ])
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pengawasanTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
