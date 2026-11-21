@extends('layouts.app')

@section('title', 'Data Usaha ESDM')
@section('page-title', 'Data Usaha ESDM')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Usaha ESDM</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'status', 'label' => 'Status', 'options' => $statusOptions],
        ['name' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'options' => $jenisUsahaOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Pelaku Usaha ESDM</h5>
        @include('partials.create-button', ['route' => 'usaha.create', 'label' => 'Tambah Usaha ESDM'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'usaha.index', 'filters' => $filters])

        @if ($usahas->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="usahaTable">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Pelaku Usaha</th>
                            <th>No. Perizinan</th>
                            <th>Jenis Usaha</th>
                            <th>Komoditas</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Dokumen</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usahas as $u)
                            <tr>
                                <td>
                                    @if($u->foto)
                                        <img src="{{ asset('storage/' . $u->foto) }}" alt="Foto Usaha" class="rounded" style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <span class="text-muted small">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $u->nama_pelaku_usaha }}</strong><br>
                                    <span class="text-muted small">ID: {{ $u->nomor_identitas ?? '-' }}</span>
                                </td>
                                <td><code>{{ $u->nomor_perizinan ?? '-' }}</code></td>
                                <td>{{ $u->jenis_usaha }}</td>
                                <td>{{ $u->komoditas ?? '-' }}</td>
                                <td>{{ $u->lokasi }}</td>
                                <td>
                                    @if($u->status == 'aktif')
                                        @include('partials.status-badge', ['status' => 'aktif'])
                                    @elseif($u->status == 'nonaktif')
                                        @include('partials.status-badge', ['status' => 'nonaktif'])
                                    @else
                                        @include('partials.status-badge', ['status' => 'izin_habis', 'label' => 'Izin Habis'])
                                    @endif
                                </td>
                                <td>
                                    @if($u->dokumen)
                                        <a href="{{ asset('storage/' . $u->dokumen) }}" target="_blank" class="btn btn-outline-info btn-sm table-file-link" aria-label="Unduh dokumen usaha {{ $u->nama_pelaku_usaha }}" title="Unduh dokumen usaha {{ $u->nama_pelaku_usaha }}">
                                            <i class="bi bi-file-earmark-arrow-down"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $u->id,
                                        'label' => $u->nama_pelaku_usaha,
                                        'editRoute' => 'usaha.edit',
                                        'deleteRoute' => 'usaha.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'usaha ESDM',
                'createRoute' => 'usaha.create',
                'createLabel' => 'Tambah Usaha ESDM',
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
        $('#usahaTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
