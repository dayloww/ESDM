@extends('layouts.app')

@section('title', 'Data Kabupaten')
@section('page-title', 'Data Kabupaten')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kabupaten</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Kabupaten</h5>
        <a href="{{ route('kabupaten.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kabupaten
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="kabupatenTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Nama Kabupaten</th>
                        <th>Jumlah Kecamatan</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kabupatens as $index => $kab)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kab->nama }}</td>
                            <td>{{ $kab->kecamatans_count }}</td>
                            <td>
                                <a href="{{ route('kabupaten.edit', $kab->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('kabupaten.destroy', $kab->id) }}" method="POST" class="d-inline" id="delete-form-{{ $kab->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $kab->id }}')">
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
        $('#kabupatenTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
