@extends('layouts.app')

@section('title', 'Edit Potensi PAD')
@section('page-title', 'Edit Potensi PAD')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pad.index') }}">Potensi PAD</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Potensi PAD</h5>
    </div>
    <div class="card-body">
        @include('partials.form-errors')

        <form action="{{ route('pad.update', $pad->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_kegiatan" class="form-label fw-semibold">Jenis kegiatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $pad->jenis_kegiatan) }}" placeholder="Contoh: Pajak MBLB, Retribusi Perizinan" required @error('jenis_kegiatan') aria-invalid="true" aria-describedby="jenis_kegiatan-error" @enderror>
                    @error('jenis_kegiatan')
                        <div id="jenis_kegiatan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="komoditas" class="form-label fw-semibold">Komoditas</label>
                    <input type="text" class="form-control @error('komoditas') is-invalid @enderror" id="komoditas" name="komoditas" value="{{ old('komoditas', $pad->komoditas) }}" placeholder="Contoh: Pasir, Batu Kali, Kerikil" @error('komoditas') aria-invalid="true" aria-describedby="komoditas-error" @enderror>
                    @error('komoditas')
                        <div id="komoditas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="volume" class="form-label fw-semibold">Volume / jumlah</label>
                    <input type="number" step="0.01" class="form-control @error('volume') is-invalid @enderror" id="volume" name="volume" value="{{ old('volume', $pad->volume) }}" placeholder="Contoh: 15000" @error('volume') aria-invalid="true" aria-describedby="volume-error" @enderror>
                    @error('volume')
                        <div id="volume-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="satuan" class="form-label fw-semibold">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $pad->satuan) }}" placeholder="Contoh: m3, Ton" @error('satuan') aria-invalid="true" aria-describedby="satuan-error" @enderror>
                    @error('satuan')
                        <div id="satuan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="periode" class="form-label fw-semibold">Periode laporan</label>
                    <input type="text" class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ old('periode', $pad->periode) }}" placeholder="Contoh: Triwulan I 2026, Tahun 2026" @error('periode') aria-invalid="true" aria-describedby="periode-error" @enderror>
                    @error('periode')
                        <div id="periode-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nilai_produksi" class="form-label fw-semibold">Nilai produksi (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('nilai_produksi') is-invalid @enderror" id="nilai_produksi" name="nilai_produksi" value="{{ old('nilai_produksi', $pad->nilai_produksi) }}" placeholder="Contoh: 150000000" @error('nilai_produksi') aria-invalid="true" aria-describedby="nilai_produksi-error" @enderror>
                    @error('nilai_produksi')
                        <div id="nilai_produksi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pelaku_usaha" class="form-label fw-semibold">Pelaku usaha terkait</label>
                    <input type="text" class="form-control @error('pelaku_usaha') is-invalid @enderror" id="pelaku_usaha" name="pelaku_usaha" value="{{ old('pelaku_usaha', $pad->pelaku_usaha) }}" placeholder="Contoh: CV. Sangihe Makmur" @error('pelaku_usaha') aria-invalid="true" aria-describedby="pelaku_usaha-error" @enderror>
                    @error('pelaku_usaha')
                        <div id="pelaku_usaha-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi sumber PAD <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $pad->lokasi) }}" placeholder="Contoh: Manganitu, Kepulauan Sangihe" required @error('lokasi') aria-invalid="true" aria-describedby="lokasi-error" @enderror>
                    @error('lokasi')
                        <div id="lokasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="estimasi_penerimaan" class="form-label fw-semibold">Estimasi penerimaan PAD (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('estimasi_penerimaan') is-invalid @enderror" id="estimasi_penerimaan" name="estimasi_penerimaan" value="{{ old('estimasi_penerimaan', $pad->estimasi_penerimaan) }}" placeholder="Contoh: 35000000" @error('estimasi_penerimaan') aria-invalid="true" aria-describedby="estimasi_penerimaan-error" @enderror>
                    @error('estimasi_penerimaan')
                        <div id="estimasi_penerimaan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('partials.form-actions', ['cancelRoute' => route('pad.index'), 'submitLabel' => 'Perbarui'])
        </form>
    </div>
</div>
@endsection
