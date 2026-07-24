@extends('layouts.app')

@section('title', 'Data Kecamatan')
@section('page-title', 'Data Kecamatan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kecamatan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Kecamatan</h5>
        <a href="{{ route('kecamatan.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kecamatan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="kecamatanTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Kabupaten</th>
                        <th>Nama Kecamatan</th>
                        <th>Jumlah Desa</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kecamatans as $index => $kec)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kec->kabupaten->nama }}</td>
                            <td>{{ $kec->nama }}</td>
                            <td>{{ $kec->desas_count }}</td>
                            <td>
                                <a href="{{ route('kecamatan.edit', $kec->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('kecamatan.destroy', $kec->id) }}" method="POST" class="d-inline" id="delete-form-{{ $kec->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $kec->id }}')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
