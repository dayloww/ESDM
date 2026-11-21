@extends('layouts.app')

@section('title', 'Edit Data Mineral')
@section('page-title', 'Edit Data Mineral')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mineral.index') }}">Mineral & Pertambangan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Data Mineral & Pertambangan</h5>
    </div>
    <div class="card-body">
        @include('partials.form-errors')

        <form action="{{ route('mineral.update', $mineral->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pemegang_izin" class="form-label fw-semibold">Pemegang izin <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pemegang_izin') is-invalid @enderror" id="pemegang_izin" name="pemegang_izin" value="{{ old('pemegang_izin', $mineral->pemegang_izin) }}" placeholder="Contoh: Koperasi Tambang Sejahtera" required @error('pemegang_izin') aria-invalid="true" aria-describedby="pemegang_izin-error" @enderror>
                    @error('pemegang_izin')
                        <div id="pemegang_izin-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_komoditas" class="form-label fw-semibold">Jenis komoditas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jenis_komoditas') is-invalid @enderror" id="jenis_komoditas" name="jenis_komoditas" value="{{ old('jenis_komoditas', $mineral->jenis_komoditas) }}" placeholder="Contoh: Pasir Besi, Emas" required @error('jenis_komoditas') aria-invalid="true" aria-describedby="jenis_komoditas-error" @enderror>
                    @error('jenis_komoditas')
                        <div id="jenis_komoditas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="luas" class="form-label fw-semibold">Luas area (hektar)</label>
                    <input type="number" step="0.01" class="form-control @error('luas') is-invalid @enderror" id="luas" name="luas" value="{{ old('luas', $mineral->luas) }}" placeholder="Contoh: 15.5" @error('luas') aria-invalid="true" aria-describedby="luas-error" @enderror>
                    @error('luas')
                        <div id="luas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="produksi" class="form-label fw-semibold">Volume produksi (ton/tahun)</label>
                    <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi', $mineral->produksi) }}" placeholder="Contoh: 1200" @error('produksi') aria-invalid="true" aria-describedby="produksi-error" @enderror>
                    @error('produksi')
                        <div id="produksi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi tambang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $mineral->lokasi) }}" placeholder="Contoh: Kecamatan Manganitu, Sangihe" required @error('lokasi') aria-invalid="true" aria-describedby="lokasi-error" @enderror>
                    @error('lokasi')
                        <div id="lokasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumentasi" class="form-label fw-semibold">Dokumentasi file/foto (max 10MB - biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" id="dokumentasi" name="dokumentasi"  @error('dokumentasi') aria-invalid="true" aria-describedby="dokumentasi-error" @enderror>
                    @if($mineral->dokumentasi)
                        <div class="form-text text-success">File saat ini: <a href="{{ asset('storage/' . $mineral->dokumentasi) }}" target="_blank">Lihat Dokumentasi</a></div>
                    @endif
                    @error('dokumentasi')
                        <div id="dokumentasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hasil_pemantauan" class="form-label fw-semibold">Hasil pemantauan</label>
                    <textarea class="form-control @error('hasil_pemantauan') is-invalid @enderror" id="hasil_pemantauan" name="hasil_pemantauan" rows="3" placeholder="Contoh: Penambangan berjalan sesuai AMDAL"  @error('hasil_pemantauan') aria-invalid="true" aria-describedby="hasil_pemantauan-error" @enderror>{{ old('hasil_pemantauan', $mineral->hasil_pemantauan) }}</textarea>
                    @error('hasil_pemantauan')
                        <div id="hasil_pemantauan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tindak_lanjut" class="form-label fw-semibold">Tindak lanjut</label>
                    <textarea class="form-control @error('tindak_lanjut') is-invalid @enderror" id="tindak_lanjut" name="tindak_lanjut" rows="3" placeholder="Contoh: Diperlukan pembinaan berkala"  @error('tindak_lanjut') aria-invalid="true" aria-describedby="tindak_lanjut-error" @enderror>{{ old('tindak_lanjut', $mineral->tindak_lanjut) }}</textarea>
                    @error('tindak_lanjut')
                        <div id="tindak_lanjut-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('partials.form-actions', ['cancelRoute' => route('mineral.index'), 'submitLabel' => 'Perbarui'])
        </form>
    </div>
</div>
@endsection
