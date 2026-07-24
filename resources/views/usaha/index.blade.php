@extends('layouts.app')

@section('title', 'Data Usaha ESDM')
@section('page-title', 'Data Usaha ESDM')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Usaha ESDM</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Pelaku Usaha ESDM</h5>
        <a href="{{ route('usaha.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Usaha ESDM
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="usahaTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Foto</th>
                        <th>Nama Pelaku Usaha</th>
                        <th>No. Perizinan</th>
                        <th>Jenis Usaha</th>
                        <th>Komoditas</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usahas as $index => $u)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($u->foto)
                                    <img src="{{ asset('storage/' . $u->foto) }}" alt="Foto Usaha" class="rounded" style="width: 60px; height: 45px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $u->nama_pelaku_usaha }}</strong><br>
                                <span class="text-muted small">ID: {{ $u->nomor_identitas ?? '-' }}</span>
                            </td>
                            <td><code>{{ $u->nomor_perizinan ?? '-' }}</code></td>
                            <td>{{ $u->jenis_usaha }}</td>
                            <td>{{ $u->komoditas ?? '-' }}</td>
                            <td>{{ $u->lokasi }}</td>
                            <td>
                                @if($u->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($u->status == 'nonaktif')
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @else
                                    <span class="badge bg-danger">Izin Habis</span>
                                @endif
                            </td>
                            <td>
                                @if($u->dokumen)
                                    <a href="{{ asset('storage/' . $u->dokumen) }}" target="_blank" class="btn btn-outline-info btn-xs py-0 px-2" title="Unduh Dokumen">
                                        <i class="bi bi-file-earmark-arrow-down"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('usaha.edit', $u->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('usaha.destroy', $u->id) }}" method="POST" class="d-inline" id="delete-form-{{ $u->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $u->id }}')">
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
        $('#usahaTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
