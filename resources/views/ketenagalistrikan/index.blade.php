@extends('layouts.app')

@section('title', 'Ketenagalistrikan')
@section('page-title', 'Ketenagalistrikan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Ketenagalistrikan</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'status', 'label' => 'Status', 'options' => $statusOptions],
        ['name' => 'bidang_kegiatan', 'label' => 'Bidang Kegiatan', 'options' => $bidangOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Usaha Penunjang Tenaga Listrik (UPTL)</h5>
        @include('partials.create-button', ['route' => 'ketenagalistrikan.create', 'label' => 'Tambah Data Ketenagalistrikan'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'ketenagalistrikan.index', 'filters' => $filters])

        @if ($energis->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="ketenagalistrikanTable">
                    <thead>
                        <tr>
                            <th>Desa / Lokasi</th>
                            <th>Jenis Usaha</th>
                            <th>Nama Badan Usaha</th>
                            <th>Penanggung Jawab</th>
                            <th>Jenis Usaha Penunjang</th>
                            <th>Bidang Kegiatan</th>
                            <th>Status</th>
                            <th>Dokumentasi</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($energis as $e)
                            <tr>
                                <td><strong>{{ $e->desa }}</strong></td>
                                <td>
                                    @if($e->jenis_usaha === 'UPTL')
                                        @include('partials.status-badge', ['status' => 'UPTL', 'tone' => 'info', 'label' => 'UPTL'])
                                    @else
                                        @include('partials.status-badge', ['status' => $e->jenis_usaha ?? '-', 'label' => $e->jenis_usaha ?? '-'])
                                    @endif
                                </td>
                                <td>{{ $e->nama_badan_usaha ?? '-' }}</td>
                                <td>{{ $e->penanggung_jawab ?? '-' }}</td>
                                <td>{{ $e->jenis_usaha_penunjang ?? '-' }}</td>
                                <td>{{ $e->bidang_kegiatan ?? '-' }}</td>
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
                                        'showRoute' => 'ketenagalistrikan.show',
                                        'editRoute' => 'ketenagalistrikan.edit',
                                        'deleteRoute' => 'ketenagalistrikan.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'data ketenagalistrikan',
                'createRoute' => 'ketenagalistrikan.create',
                'createLabel' => 'Tambah Data Ketenagalistrikan',
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
        $('#ketenagalistrikanTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
