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
        @include('partials.form-errors')

        <form action="{{ route('wilayah.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="desa_id" class="form-label fw-semibold">Pilih desa <span class="text-danger">*</span></label>
                    <select class="form-select @error('desa_id') is-invalid @enderror" id="desa_id" name="desa_id" required  @error('desa_id') aria-invalid="true" aria-describedby="desa_id-error" @enderror>
                        <option value="">-- Pilih Desa --</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>
                                {{ $desa->kecamatan->kabupaten->nama }} - {{ $desa->kecamatan->nama }} - {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <div id="desa_id-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="koordinat" class="form-label fw-semibold">Koordinat GPS</label>
                    <input type="text" class="form-control @error('koordinat') is-invalid @enderror" id="koordinat" name="koordinat" value="{{ old('koordinat') }}" placeholder="Contoh: 1.456, 125.123"  @error('koordinat') aria-invalid="true" aria-describedby="koordinat-error" @enderror>
                    @error('koordinat')
                        <div id="koordinat-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jumlah_penduduk" class="form-label fw-semibold">Jumlah penduduk (jiwa)</label>
                    <input type="number" class="form-control @error('jumlah_penduduk') is-invalid @enderror" id="jumlah_penduduk" name="jumlah_penduduk" value="{{ old('jumlah_penduduk') }}" min="0" placeholder="Contoh: 1500"  @error('jumlah_penduduk') aria-invalid="true" aria-describedby="jumlah_penduduk-error" @enderror>
                    @error('jumlah_penduduk')
                        <div id="jumlah_penduduk-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status_berlistrik" class="form-label fw-semibold">Status berlistrik <span class="text-danger">*</span></label>
                    <select class="form-select @error('status_berlistrik') is-invalid @enderror" id="status_berlistrik" name="status_berlistrik" required  @error('status_berlistrik') aria-invalid="true" aria-describedby="status_berlistrik-error" @enderror>
                        <option value="berlistrik" {{ old('status_berlistrik') == 'berlistrik' ? 'selected' : '' }}>Berlistrik</option>
                        <option value="belum_berlistrik" {{ old('status_berlistrik') == 'belum_berlistrik' ? 'selected' : '' }}>Belum Berlistrik</option>
                        <option value="sebagian" {{ old('status_berlistrik') == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                    </select>
                    @error('status_berlistrik')
                        <div id="status_berlistrik-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="kondisi_ketenagalistrikan" class="form-label fw-semibold">Kondisi ketenagalistrikan</label>
                    <input type="text" class="form-control @error('kondisi_ketenagalistrikan') is-invalid @enderror" id="kondisi_ketenagalistrikan" name="kondisi_ketenagalistrikan" value="{{ old('kondisi_ketenagalistrikan') }}" placeholder="Contoh: Gardu sering padam, atau jaringan stabil"  @error('kondisi_ketenagalistrikan') aria-invalid="true" aria-describedby="kondisi_ketenagalistrikan-error" @enderror>
                    @error('kondisi_ketenagalistrikan')
                        <div id="kondisi_ketenagalistrikan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="potensi_energi" class="form-label fw-semibold">Potensi energi</label>
                    <textarea class="form-control @error('potensi_energi') is-invalid @enderror" id="potensi_energi" name="potensi_energi" rows="3" placeholder="Contoh: Tenaga surya, angin, panas bumi"  @error('potensi_energi') aria-invalid="true" aria-describedby="potensi_energi-error" @enderror>{{ old('potensi_energi') }}</textarea>
                    @error('potensi_energi')
                        <div id="potensi_energi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="potensi_sumber_daya_mineral" class="form-label fw-semibold">Potensi sumber daya mineral</label>
                    <textarea class="form-control @error('potensi_sumber_daya_mineral') is-invalid @enderror" id="potensi_sumber_daya_mineral" name="potensi_sumber_daya_mineral" rows="3" placeholder="Contoh: Emas, tembaga, pasir besi"  @error('potensi_sumber_daya_mineral') aria-invalid="true" aria-describedby="potensi_sumber_daya_mineral-error" @enderror>{{ old('potensi_sumber_daya_mineral') }}</textarea>
                    @error('potensi_sumber_daya_mineral')
                        <div id="potensi_sumber_daya_mineral-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('partials.form-actions', ['cancelRoute' => route('wilayah.index'), 'submitLabel' => 'Simpan'])
        </form>
    </div>
</div>
@endsection
