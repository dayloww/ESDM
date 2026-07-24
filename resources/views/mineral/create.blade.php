@extends('layouts.app')

@section('title', 'Tambah Data Mineral')
@section('page-title', 'Tambah Data Mineral')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mineral.index') }}">Mineral & Pertambangan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Data Mineral & Pertambangan</h5>
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

        <form action="{{ route('mineral.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pemegang_izin" class="form-label fw-semibold">Pemegang Izin</label>
                    <input type="text" class="form-control @error('pemegang_izin') is-invalid @enderror" id="pemegang_izin" name="pemegang_izin" value="{{ old('pemegang_izin') }}" required placeholder="Contoh: Koperasi Tambang Sejahtera">
                    @error('pemegang_izin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_komoditas" class="form-label fw-semibold">Jenis Komoditas</label>
                    <input type="text" class="form-control @error('jenis_komoditas') is-invalid @enderror" id="jenis_komoditas" name="jenis_komoditas" value="{{ old('jenis_komoditas') }}" required placeholder="Contoh: Pasir Besi, Emas">
                    @error('jenis_komoditas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="luas" class="form-label fw-semibold">Luas Area (Hektar)</label>
                    <input type="number" step="0.01" class="form-control @error('luas') is-invalid @enderror" id="luas" name="luas" value="{{ old('luas') }}" placeholder="Contoh: 15.5">
                    @error('luas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="produksi" class="form-label fw-semibold">Volume Produksi (Ton/Tahun)</label>
                    <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi') }}" placeholder="Contoh: 1200">
                    @error('produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi Tambang</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Kecamatan Manganitu, Sangihe">
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumentasi" class="form-label fw-semibold">Dokumentasi File/Foto (Max 10MB)</label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" id="dokumentasi" name="dokumentasi">
                    @error('dokumentasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hasil_pemantauan" class="form-label fw-semibold">Hasil Pemantauan</label>
                    <textarea class="form-control @error('hasil_pemantauan') is-invalid @enderror" id="hasil_pemantauan" name="hasil_pemantauan" rows="3" placeholder="Contoh: Penambangan berjalan sesuai AMDAL">{{ old('hasil_pemantauan') }}</textarea>
                    @error('hasil_pemantauan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tindak_lanjut" class="form-label fw-semibold">Tindak Lanjut</label>
                    <textarea class="form-control @error('tindak_lanjut') is-invalid @enderror" id="tindak_lanjut" name="tindak_lanjut" rows="3" placeholder="Contoh: Diperlukan pembinaan berkala">{{ old('tindak_lanjut') }}</textarea>
                    @error('tindak_lanjut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('mineral.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
