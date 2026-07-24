@extends('layouts.app')

@section('title', 'Pengawasan')
@section('page-title', 'Pengawasan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengawasan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Laporan Pengawasan Lapangan</h5>
        <a href="{{ route('pengawasan.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Pengawasan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="pengawasanTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Objek Pengawasan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Temuan</th>
                        <th>Rekomendasi</th>
                        <th>Dokumentasi</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengawasans as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM Y') }}</td>
                            <td>{{ $p->petugas }}</td>
                            <td><strong>{{ $p->objek }}</strong></td>
                            <td>{{ $p->lokasi }}</td>
                            <td>
                                @if($p->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($p->status == 'dalam_proses')
                                    <span class="badge bg-warning text-dark">Dalam Proses</span>
                                @else
                                    <span class="badge bg-danger">Tertunda</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $p->temuan }}">
                                    {{ $p->temuan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $p->rekomendasi }}">
                                    {{ $p->rekomendasi ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($p->dokumentasi)
                                    <a href="{{ asset('storage/' . $p->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-xs py-0 px-2">
                                        <i class="bi bi-file-earmark-image"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pengawasan.edit', $p->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('pengawasan.destroy', $p->id) }}" method="POST" class="d-inline" id="delete-form-{{ $p->id }}">
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
        $('#pengawasanTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
