@extends('layouts.app')

@section('title', 'Mineral & Pertambangan')
@section('page-title', 'Mineral & Pertambangan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Mineral & Pertambangan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Komoditas Mineral & Pertambangan</h5>
        <a href="{{ route('mineral.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Data Mineral
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mineralTable">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Pemegang Izin</th>
                        <th>Komoditas</th>
                        <th>Luas (Ha)</th>
                        <th>Produksi (Ton/Thn)</th>
                        <th>Lokasi</th>
                        <th>Hasil Pemantauan</th>
                        <th>Dokumentasi</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($minerals as $index => $m)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $m->pemegang_izin }}</strong></td>
                            <td>{{ $m->jenis_komoditas }}</td>
                            <td>{{ $m->luas ? number_format($m->luas) . ' Ha' : '-' }}</td>
                            <td>{{ $m->produksi ? number_format($m->produksi) . ' Ton' : '-' }}</td>
                            <td>{{ $m->lokasi }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $m->hasil_pemantauan }}">
                                    {{ $m->hasil_pemantauan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($m->dokumentasi)
                                    <a href="{{ asset('storage/' . $m->dokumentasi) }}" target="_blank" class="btn btn-outline-info btn-xs py-0 px-2">
                                        <i class="bi bi-file-earmark-image"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('mineral.edit', $m->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('mineral.destroy', $m->id) }}" method="POST" class="d-inline" id="delete-form-{{ $m->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="deleteConfirm(event, 'delete-form-{{ $m->id }}')">
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
        $('#mineralTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
