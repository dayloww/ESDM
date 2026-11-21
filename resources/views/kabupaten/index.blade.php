@extends('layouts.app')

@section('title', 'Data Kabupaten')
@section('page-title', 'Data Kabupaten')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kabupaten</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'nama', 'label' => 'Nama Kabupaten', 'type' => 'text', 'placeholder' => 'Cari nama kabupaten'],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Kabupaten</h5>
        @include('partials.create-button', ['route' => 'kabupaten.create', 'label' => 'Tambah Kabupaten'])
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'kabupaten.index', 'filters' => $filters])

        @if ($kabupatens->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="kabupatenTable">
                    <thead>
                        <tr>
                            <th>Nama Kabupaten</th>
                            <th>Jumlah Kecamatan</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kabupatens as $kab)
                            <tr>
                                <td>{{ $kab->nama }}</td>
                                <td>{{ $kab->kecamatans_count }}</td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $kab->id,
                                        'label' => $kab->nama,
                                        'editRoute' => 'kabupaten.edit',
                                        'deleteRoute' => 'kabupaten.destroy',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'kabupaten',
                'createRoute' => 'kabupaten.create',
                'createLabel' => 'Tambah Kabupaten',
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
        $('#kabupatenTable').DataTable({
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
