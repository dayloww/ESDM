@extends('layouts.app')

@section('title', 'Data Desa')
@section('page-title', 'Data Desa')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Desa</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Desa</h5>
        <a href="{{ route('desa.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Desa
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="desaTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Nama Desa</th>
                        <th>Terkait Data Wilayah</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($desas as $index => $desa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $desa->kecamatan->kabupaten->nama }}</td>
                            <td>{{ $desa->kecamatan->nama }}</td>
                            <td>{{ $desa->nama }}</td>
                            <td>{{ $desa->data_wilayahs_count }} record</td>
                            <td>
                                <a href="{{ route('desa.edit', $desa->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('desa.destroy', $desa->id) }}" method="POST" class="d-inline" id="delete-form-{{ $desa->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $desa->id }}')">
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
        $('#desaTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
