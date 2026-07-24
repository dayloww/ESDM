@extends('layouts.app')

@section('title', 'Tambah Kecamatan')
@section('page-title', 'Tambah Kecamatan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kecamatan.index') }}">Kecamatan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Kecamatan</h5>
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

                <form action="{{ route('kecamatan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kabupaten_id" class="form-label fw-semibold">Kabupaten</label>
                        <select class="form-select @error('kabupaten_id') is-invalid @enderror" id="kabupaten_id" name="kabupaten_id" required>
                            <option value="">-- Pilih Kabupaten --</option>
                            @foreach($kabupatens as $kab)
                                <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>{{ $kab->nama }}</option>
                            @endforeach
                        </select>
                        @error('kabupaten_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Kecamatan</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Kecamatan Manganitu">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
