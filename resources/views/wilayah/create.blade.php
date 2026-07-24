@extends('layouts.app')

@section('title', 'Tambah Data Wilayah')
@section('page-title', 'Tambah Data Wilayah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('wilayah.index') }}">Data Wilayah</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Data Wilayah</h5>
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

        <form action="{{ route('wilayah.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="desa_id" class="form-label fw-semibold">Pilih Desa</label>
                    <select class="form-select @error('desa_id') is-invalid @enderror" id="desa_id" name="desa_id" required>
                        <option value="">-- Pilih Desa --</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>
                                {{ $desa->kecamatan->kabupaten->nama }} - {{ $desa->kecamatan->nama }} - {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="koordinat" class="form-label fw-semibold">Koordinat GPS</label>
                    <input type="text" class="form-control @error('koordinat') is-invalid @enderror" id="koordinat" name="koordinat" value="{{ old('koordinat') }}" placeholder="Contoh: 1.456, 125.123">
                    @error('koordinat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jumlah_penduduk" class="form-label fw-semibold">Jumlah Penduduk (Jiwa)</label>
                    <input type="number" class="form-control @error('jumlah_penduduk') is-invalid @enderror" id="jumlah_penduduk" name="jumlah_penduduk" value="{{ old('jumlah_penduduk') }}" min="0" placeholder="Contoh: 1500">
                    @error('jumlah_penduduk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status_berlistrik" class="form-label fw-semibold">Status Berlistrik</label>
                    <select class="form-select @error('status_berlistrik') is-invalid @enderror" id="status_berlistrik" name="status_berlistrik" required>
                        <option value="berlistrik" {{ old('status_berlistrik') == 'berlistrik' ? 'selected' : '' }}>Berlistrik</option>
                        <option value="belum_berlistrik" {{ old('status_berlistrik') == 'belum_berlistrik' ? 'selected' : '' }}>Belum Berlistrik</option>
                        <option value="sebagian" {{ old('status_berlistrik') == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                    </select>
                    @error('status_berlistrik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="kondisi_ketenagalistrikan" class="form-label fw-semibold">Kondisi Ketenagalistrikan</label>
                    <input type="text" class="form-control @error('kondisi_ketenagalistrikan') is-invalid @enderror" id="kondisi_ketenagalistrikan" name="kondisi_ketenagalistrikan" value="{{ old('kondisi_ketenagalistrikan') }}" placeholder="Contoh: Gardu sering padam, atau jaringan stabil">
                    @error('kondisi_ketenagalistrikan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="potensi_energi" class="form-label fw-semibold">Potensi Energi</label>
                    <textarea class="form-control @error('potensi_energi') is-invalid @enderror" id="potensi_energi" name="potensi_energi" rows="3" placeholder="Contoh: Tenaga surya, angin, panas bumi">{{ old('potensi_energi') }}</textarea>
                    @error('potensi_energi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="potensi_sumber_daya_mineral" class="form-label fw-semibold">Potensi Sumber Daya Mineral</label>
                    <textarea class="form-control @error('potensi_sumber_daya_mineral') is-invalid @enderror" id="potensi_sumber_daya_mineral" name="potensi_sumber_daya_mineral" rows="3" placeholder="Contoh: Emas, tembaga, pasir besi">{{ old('potensi_sumber_daya_mineral') }}</textarea>
                    @error('potensi_sumber_daya_mineral')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('wilayah.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
