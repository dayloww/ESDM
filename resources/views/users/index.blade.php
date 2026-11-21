@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manajemen Pengguna</li>
@endsection

@section('content')
@php
    $filters = [
        ['name' => 'role_id', 'label' => 'Role', 'options' => $roleOptions],
        ['name' => 'status', 'label' => 'Status', 'options' => $statusOptions],
    ];
@endphp
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Daftar Pengguna</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        @include('partials.filter-bar', ['routeName' => 'users.index', 'filters' => $filters])

        @if ($users->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="usersTable">
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tgl Terdaftar</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $user->role->nama_role ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @include('partials.table-actions', [
                                        'id' => $user->id,
                                        'label' => $user->name,
                                        'editRoute' => 'users.edit',
                                        'deleteRoute' => 'users.destroy',
                                        'canDelete' => $user->id !== auth()->id(),
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('partials.empty-state', [
                'label' => 'pengguna',
                'createRoute' => 'users.create',
                'createLabel' => 'Tambah Pengguna',
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
        $('#usersTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
