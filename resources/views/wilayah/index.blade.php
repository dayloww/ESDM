@extends('layouts.app')

@section('title', 'Data Wilayah')
@section('page-title', 'Data Wilayah')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Data Wilayah</li>
@endsection

@section('content')
@php
    $filters = [
        [
            'name' => 'status_berlistrik',
            'label' => 'Status Berlistrik',
            'options' => [
                'berlistrik' => 'Berlistrik',
                'belum_berlistrik' => 'Belum Berlistrik',
                'sebagian' => 'Sebagian',
            ],
        ],
        ['name' => 'kabupaten_id', 'label' => 'Kabupaten', 'options' => $kabupatenOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Data Wilayah</h5>
        @include('partials.create-button', ['route' => 'wilayah.create', 'label' => 'Tambah Data Wilayah'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'wilayah.index', 'filters' => $filters])

        @if ($wilayahs->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="wilayahTable">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Koordinat</th>
                            <th>Status Berlistrik</th>
                            <th>Kependudukan</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wilayahs as $wil)
                            <tr>
                                <td>{{ $wil->desa->kecamatan->kabupaten->nama }}</td>
                                <td>{{ $wil->desa->kecamatan->nama }}</td>
                                <td>{{ $wil->desa->nama }}</td>
                                <td><code>{{ $wil->koordinat ?? '-' }}</code></td>
                                <td>
                                    @if($wil->status_berlistrik == 'berlistrik')
                                        @include('partials.status-badge', ['status' => 'berlistrik'])
                                    @elseif($wil->status_berlistrik == 'belum_berlistrik')
                                        @include('partials.status-badge', ['status' => 'belum_berlistrik', 'label' => 'Belum Berlistrik'])
                                    @else
                                        @include('partials.status-badge', ['status' => 'sebagian'])
                                    @endif
                                </td>
                                <td>{{ number_format($wil->jumlah_penduduk) }} Jiwa</td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $wil->id,
                                        'label' => 'Data Wilayah ' . $wil->desa->nama,
                                        'editRoute' => 'wilayah.edit',
                                        'deleteRoute' => 'wilayah.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'data wilayah',
                'createRoute' => 'wilayah.create',
                'createLabel' => 'Tambah Data Wilayah',
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
        $('#wilayahTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
