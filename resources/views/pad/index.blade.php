@extends('layouts.app')

@section('title', 'Potensi PAD')
@section('page-title', 'Potensi PAD')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Potensi PAD</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Potensi Pendapatan Asli Daerah (PAD)</h5>
        <a href="{{ route('pad.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Potensi PAD
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="padTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Jenis Kegiatan</th>
                        <th>Komoditas</th>
                        <th>Volume</th>
                        <th>Satuan</th>
                        <th>Periode</th>
                        <th>Nilai Produksi</th>
                        <th>Pelaku Usaha</th>
                        <th>Lokasi</th>
                        <th>Estimasi Penerimaan PAD</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pads as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
                                <a href="{{ route('pad.edit', $p->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('pad.destroy', $p->id) }}" method="POST" class="d-inline" id="delete-form-{{ $p->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $p->id }}')">
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
        $('#padTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
