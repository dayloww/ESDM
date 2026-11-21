@extends('layouts.app')

@section('title', 'Tambah Kabupaten')
@section('page-title', 'Tambah Kabupaten')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kabupaten.index') }}">Kabupaten</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Kabupaten</h5>
            </div>
            <div class="card-body">
                @include('partials.form-errors')

                <form action="{{ route('kabupaten.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama kabupaten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Kabupaten Kepulauan Sangihe"  @error('nama') aria-invalid="true" aria-describedby="nama-error" @enderror>
                        @error('nama')
                            <div id="nama-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @include('partials.form-actions', ['cancelRoute' => route('kabupaten.index'), 'submitLabel' => 'Simpan'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
