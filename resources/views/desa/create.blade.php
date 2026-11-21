@extends('layouts.app')

@section('title', 'Tambah Desa')
@section('page-title', 'Tambah Desa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('desa.index') }}">Desa</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Desa</h5>
            </div>
            <div class="card-body">
                @include('partials.form-errors')

                <form action="{{ route('desa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kecamatan_id" class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('kecamatan_id') is-invalid @enderror" id="kecamatan_id" name="kecamatan_id" required  @error('kecamatan_id') aria-invalid="true" aria-describedby="kecamatan_id-error" @enderror>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                    {{ $kec->kabupaten->nama }} - {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <div id="kecamatan_id-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama desa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Desa Taloarane"  @error('nama') aria-invalid="true" aria-describedby="nama-error" @enderror>
                        @error('nama')
                            <div id="nama-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @include('partials.form-actions', ['cancelRoute' => route('desa.index'), 'submitLabel' => 'Simpan'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
