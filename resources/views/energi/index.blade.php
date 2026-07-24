@extends('layouts.app')

@section('title', 'Energi & Ketenagalistrikan')
@section('page-title', 'Energi & Ketenagalistrikan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Energi & Ketenagalistrikan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Jaringan & Infrastruktur Energi</h5>
        <a href="{{ route('energi.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Data Energi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="energiTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Desa / Lokasi</th>
                        <th>Sumber Energi</th>
                        <th>Kapasitas</th>
                        <th>Jaringan</th>
                        <th>Potensi EBT</th>
                        <th>Permasalahan</th>
                        <th>Dokumentasi</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($energis as $index => $e)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $e->desa }}</strong></td>
                            <td>{{ $e->sumber_energi }}</td>
                            <td>{{ $e->kapasitas ?? '-' }}</td>
                            <td>{{ $e->jaringan ?? '-' }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $e->potensi_ebt }}">
                                    {{ $e->potensi_ebt ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $e->permasalahan }}">
                                    {{ $e->permasalahan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($e->dokumentasi)
                                    <a href="{{ asset('storage/' . $e->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-xs py-0 px-2">
                                        <i class="bi bi-file-earmark-image"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('energi.edit', $e->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('energi.destroy', $e->id) }}" method="POST" class="d-inline" id="delete-form-{{ $e->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $e->id }}')">
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
        $('#energiTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
