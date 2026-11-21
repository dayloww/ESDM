@extends('layouts.app')

@section('title', 'Potensi PAD')
@section('page-title', 'Potensi PAD')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Potensi PAD</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'jenis_kegiatan', 'label' => 'Jenis Kegiatan', 'options' => $jenisKegiatanOptions],
        ['name' => 'periode', 'label' => 'Periode', 'type' => 'text', 'placeholder' => 'Contoh: 2025'],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Potensi Pendapatan Asli Daerah (PAD)</h5>
        @include('partials.create-button', ['route' => 'pad.create', 'label' => 'Tambah Potensi PAD'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'pad.index', 'filters' => $filters])

        @if ($pads->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="padTable">
                    <thead>
                        <tr>
                            <th>Jenis Kegiatan</th>
                            <th>Komoditas</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Periode</th>
                            <th>Nilai Produksi</th>
                            <th>Pelaku Usaha</th>
                            <th>Lokasi</th>
                            <th>Estimasi Penerimaan PAD</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pads as $p)
                            <tr>
                                <td><strong>{{ $p->jenis_kegiatan }}</strong></td>
                                <td>{{ $p->komoditas ?? '-' }}</td>
                                <td>{{ $p->volume ? number_format($p->volume) : '-' }}</td>
                                <td>{{ $p->satuan ?? '-' }}</td>
                                <td>{{ $p->periode ?? '-' }}</td>
                                <td>{{ $p->nilai_produksi ? 'Rp ' . number_format($p->nilai_produksi, 0, ',', '.') : '-' }}</td>
                                <td>{{ $p->pelaku_usaha ?? '-' }}</td>
                                <td>{{ $p->lokasi }}</td>
                                <td>
                                    <strong class="text-success">
                                        {{ $p->estimasi_penerimaan ? 'Rp ' . number_format($p->estimasi_penerimaan, 0, ',', '.') : '-' }}
                                    </strong>
                                </td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $p->id,
                                        'label' => $p->jenis_kegiatan,
                                        'editRoute' => 'pad.edit',
                                        'deleteRoute' => 'pad.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'potensi PAD',
                'createRoute' => 'pad.create',
                'createLabel' => 'Tambah Potensi PAD',
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
        $('#padTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
