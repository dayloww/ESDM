@extends('layouts.app')

@section('title', 'Data Desa')
@section('page-title', 'Data Desa')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Desa</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'kecamatan_id', 'label' => 'Kecamatan', 'options' => $kecamatanOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Desa</h5>
        @include('partials.create-button', ['route' => 'desa.create', 'label' => 'Tambah Desa'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'desa.index', 'filters' => $filters])

        @if ($desas->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="desaTable">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Nama Desa</th>
                            <th>Terkait Data Wilayah</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desas as $desa)
                            <tr>
                                <td>{{ $desa->kecamatan->kabupaten->nama }}</td>
                                <td>{{ $desa->kecamatan->nama }}</td>
                                <td>{{ $desa->nama }}</td>
                                <td>{{ $desa->data_wilayahs_count }} record</td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $desa->id,
                                        'label' => $desa->nama,
                                        'editRoute' => 'desa.edit',
                                        'deleteRoute' => 'desa.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'desa',
                'createRoute' => 'desa.create',
                'createLabel' => 'Tambah Desa',
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
        $('#desaTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
