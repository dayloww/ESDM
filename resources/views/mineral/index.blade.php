@extends('layouts.app')

@section('title', 'Data Mineral')
@section('page-title', 'Data Mineral')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Mineral</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'jenis_komoditas', 'label' => 'Jenis Komoditas', 'options' => $komoditasOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Data Mineral</h5>
        @include('partials.create-button', ['route' => 'mineral.create', 'label' => 'Tambah Data Mineral'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'mineral.index', 'filters' => $filters])

        @if ($minerals->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mineralTable">
                    <thead>
                        <tr>
                            <th>Pemegang Izin</th>
                            <th>Jenis Komoditas</th>
                            <th>Lokasi Tambang</th>
                            <th>Luas (Ha)</th>
                            <th>Produksi (Ton/Thn)</th>
                            <th>Dokumentasi</th>
                            <th>Hasil Pemantauan</th>
                            <th>Tindak Lanjut</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($minerals as $m)
                            <tr>
                                <td><strong>{{ $m->pemegang_izin }}</strong></td>
                                <td>{{ $m->jenis_komoditas }}</td>
                                <td>{{ $m->lokasi }}</td>
                                <td class="text-end">{{ $m->luas !== null ? number_format($m->luas, 2, ',', '.') : '-' }}</td>
                                <td class="text-end">{{ $m->produksi !== null ? number_format($m->produksi, 2, ',', '.') : '-' }}</td>
                                <td>
                                    @if($m->dokumentasi)
                                        <a href="{{ asset('storage/' . $m->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-sm table-file-link" aria-label="Unduh dokumentasi {{ $m->pemegang_izin }}" title="Unduh dokumentasi {{ $m->pemegang_izin }}">
                                            <i class="bi bi-file-earmark-arrow-down"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 160px;" title="{{ $m->hasil_pemantauan }}">
                                        {{ $m->hasil_pemantauan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 160px;" title="{{ $m->tindak_lanjut }}">
                                        {{ $m->tindak_lanjut ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $m->id,
                                        'label' => $m->pemegang_izin,
                                        'editRoute' => 'mineral.edit',
                                        'deleteRoute' => 'mineral.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'data mineral',
                'createRoute' => 'mineral.create',
                'createLabel' => 'Tambah Data Mineral',
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
        $('#mineralTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
