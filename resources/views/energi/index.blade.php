@extends('layouts.app')

@section('title', 'Energi')
@section('page-title', 'Energi')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Energi</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'sumber_energi', 'label' => 'Sumber Energi', 'options' => $sumberEnergiOptions],
        ['name' => 'status', 'label' => 'Status', 'options' => $statusOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Pembangkit & Jaringan Energi</h5>
        @include('partials.create-button', ['route' => 'energi.create', 'label' => 'Tambah Data Energi'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'energi.index', 'filters' => $filters])

        @if ($energis->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="energiTable">
                    <thead>
                        <tr>
                            <th>Desa / Lokasi</th>
                            <th>Jenis Usaha</th>
                            <th>Sumber Energi</th>
                            <th>Kapasitas</th>
                            <th>Jaringan</th>
                            <th>Status</th>
                            <th>Potensi EBT</th>
                            <th>Permasalahan</th>
                            <th>Dokumentasi</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($energis as $e)
                            <tr>
                                <td><strong>{{ $e->desa }}</strong></td>
                                <td>
                                    @if($e->jenis_usaha === 'IUPTLS')
                                        @include('partials.status-badge', ['status' => 'IUPTLS', 'tone' => 'info', 'label' => 'IUPTLS'])
                                    @elseif($e->jenis_usaha)
                                        @include('partials.status-badge', ['status' => $e->jenis_usaha, 'label' => $e->jenis_usaha])
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ $e->sumber_energi ?? '-' }}</td>
                                <td>{{ $e->kapasitas ?? '-' }}</td>
                                <td>{{ $e->jaringan ?? '-' }}</td>
                                <td>
                                    @if($e->status === 'aktif')
                                        @include('partials.status-badge', ['status' => 'aktif'])
                                    @elseif($e->status === 'nonaktif')
                                        @include('partials.status-badge', ['status' => 'nonaktif'])
                                    @elseif($e->status === 'habis')
                                        @include('partials.status-badge', ['status' => 'habis', 'tone' => 'danger', 'label' => 'Habis'])
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 130px;" title="{{ $e->potensi_ebt }}">
                                        {{ $e->potensi_ebt ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 130px;" title="{{ $e->permasalahan }}">
                                        {{ $e->permasalahan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($e->dokumentasi)
                                        <a href="{{ asset('storage/' . $e->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-sm table-file-link" aria-label="Unduh dokumentasi {{ $e->desa }}" title="Unduh dokumentasi {{ $e->desa }}">
                                            <i class="bi bi-file-earmark-image"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $e->id,
                                        'label' => $e->desa,
                                        'showRoute' => 'energi.show',
                                        'editRoute' => 'energi.edit',
                                        'deleteRoute' => 'energi.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'data energi',
                'createRoute' => 'energi.create',
                'createLabel' => 'Tambah Data Energi',
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
        $('#energiTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
