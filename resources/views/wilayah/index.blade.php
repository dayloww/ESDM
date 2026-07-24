@extends('layouts.app')

@section('title', 'Data Wilayah')
@section('page-title', 'Data Wilayah')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Data Wilayah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Data Wilayah</h5>
        <a href="{{ route('wilayah.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Data Wilayah
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="wilayahTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Koordinat</th>
                        <th>Status Berlistrik</th>
                        <th>Kependudukan</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wilayahs as $index => $wil)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $wil->desa->kecamatan->kabupaten->nama }}</td>
                            <td>{{ $wil->desa->kecamatan->nama }}</td>
                            <td>{{ $wil->desa->nama }}</td>
                            <td><code>{{ $wil->koordinat ?? '-' }}</code></td>
                            <td>
                                @if($wil->status_berlistrik == 'berlistrik')
                                    <span class="badge bg-success">Berlistrik</span>
                                @elseif($wil->status_berlistrik == 'belum_berlistrik')
                                    <span class="badge bg-danger">Belum Berlistrik</span>
                                @else
                                    <span class="badge bg-warning text-dark">Sebagian</span>
                                @endif
                            </td>
                            <td>{{ number_format($wil->jumlah_penduduk) }} Jiwa</td>
                            <td>
                                <a href="{{ route('wilayah.edit', $wil->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('wilayah.destroy', $wil->id) }}" method="POST" class="d-inline" id="delete-form-{{ $wil->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $wil->id }}')">
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
        $('#wilayahTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
