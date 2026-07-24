@extends('layouts.app')

@section('title', 'Edit Desa')
@section('page-title', 'Edit Desa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('desa.index') }}">Desa</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Desa</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('desa.update', $desa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kecamatan_id" class="form-label fw-semibold">Kecamatan</label>
                        <select class="form-select @error('kecamatan_id') is-invalid @enderror" id="kecamatan_id" name="kecamatan_id" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id', $desa->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                    {{ $kec->kabupaten->nama }} - {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Desa</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $desa->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('desa.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
