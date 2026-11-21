@extends('layouts.app')

@section('title', 'Edit Kecamatan')
@section('page-title', 'Edit Kecamatan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kecamatan.index') }}">Kecamatan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Kecamatan</h5>
            </div>
            <div class="card-body">
                @include('partials.form-errors')

                <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kabupaten_id" class="form-label fw-semibold">Kabupaten <span class="text-danger">*</span></label>
                        <select class="form-select @error('kabupaten_id') is-invalid @enderror" id="kabupaten_id" name="kabupaten_id" required  @error('kabupaten_id') aria-invalid="true" aria-describedby="kabupaten_id-error" @enderror>
                            <option value="">-- Pilih Kabupaten --</option>
                            @foreach($kabupatens as $kab)
                                <option value="{{ $kab->id }}" {{ old('kabupaten_id', $kecamatan->kabupaten_id) == $kab->id ? 'selected' : '' }}>{{ $kab->nama }}</option>
                            @endforeach
                        </select>
                        @error('kabupaten_id')
                            <div id="kabupaten_id-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama kecamatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kecamatan->nama) }}" required placeholder="Contoh: Kecamatan Manganitu" @error('nama') aria-invalid="true" aria-describedby="nama-error" @enderror>
                        @error('nama')
                            <div id="nama-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @include('partials.form-actions', ['cancelRoute' => route('kecamatan.index'), 'submitLabel' => 'Perbarui'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
