@extends('layouts.app')

@section('title', 'Tambah Potensi PAD')
@section('page-title', 'Tambah Potensi PAD')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pad.index') }}">Potensi PAD</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Potensi PAD</h5>
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

        <form action="{{ route('pad.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_kegiatan" class="form-label fw-semibold">Jenis Kegiatan</label>
                    <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan') }}" required placeholder="Contoh: Pajak MBLB, Retribusi Perizinan">
                    @error('jenis_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="komoditas" class="form-label fw-semibold">Komoditas</label>
                    <input type="text" class="form-control @error('komoditas') is-invalid @enderror" id="komoditas" name="komoditas" value="{{ old('komoditas') }}" placeholder="Contoh: Pasir, Batu Kali, Kerikil">
                    @error('komoditas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="volume" class="form-label fw-semibold">Volume / Jumlah</label>
                    <input type="number" step="0.01" class="form-control @error('volume') is-invalid @enderror" id="volume" name="volume" value="{{ old('volume') }}" placeholder="Contoh: 15000">
                    @error('volume')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="satuan" class="form-label fw-semibold">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: m3, Ton">
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="periode" class="form-label fw-semibold">Periode Laporan</label>
                    <input type="text" class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ old('periode') }}" placeholder="Contoh: Triwulan I 2026, Tahun 2026">
                    @error('periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nilai_produksi" class="form-label fw-semibold">Nilai Produksi (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('nilai_produksi') is-invalid @enderror" id="nilai_produksi" name="nilai_produksi" value="{{ old('nilai_produksi') }}" placeholder="Contoh: 150000000">
                    @error('nilai_produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pelaku_usaha" class="form-label fw-semibold">Pelaku Usaha Terkait</label>
                    <input type="text" class="form-control @error('pelaku_usaha') is-invalid @enderror" id="pelaku_usaha" name="pelaku_usaha" value="{{ old('pelaku_usaha') }}" placeholder="Contoh: CV. Sangihe Makmur">
                    @error('pelaku_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi Sumber PAD</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Manganitu, Kepulauan Sangihe">
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="estimasi_penerimaan" class="form-label fw-semibold">Estimasi Penerimaan PAD (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('estimasi_penerimaan') is-invalid @enderror" id="estimasi_penerimaan" name="estimasi_penerimaan" value="{{ old('estimasi_penerimaan') }}" placeholder="Contoh: 35000000">
                    @error('estimasi_penerimaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('pad.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
