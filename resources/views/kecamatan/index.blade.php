@extends('layouts.app')

@section('title', 'Data Kecamatan')
@section('page-title', 'Data Kecamatan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kecamatan</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'kabupaten_id', 'label' => 'Kabupaten', 'options' => $kabupatenOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Kecamatan</h5>
        @include('partials.create-button', ['route' => 'kecamatan.create', 'label' => 'Tambah Kecamatan'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'kecamatan.index', 'filters' => $filters])

        @if ($kecamatans->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="kecamatanTable">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Nama Kecamatan</th>
                            <th>Jumlah Desa</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kecamatans as $kec)
                            <tr>
                                <td>{{ $kec->kabupaten->nama }}</td>
                                <td>{{ $kec->nama }}</td>
                                <td>{{ $kec->desas_count }}</td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $kec->id,
                                        'label' => $kec->nama,
                                        'editRoute' => 'kecamatan.edit',
                                        'deleteRoute' => 'kecamatan.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'kecamatan',
                'createRoute' => 'kecamatan.create',
                'createLabel' => 'Tambah Kecamatan',
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
        $('#kecamatanTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
