@extends('layouts.app')

@section('title', 'Tambah Data Energi')
@section('page-title', 'Tambah Data Energi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('energi.index') }}">Energi & Ketenagalistrikan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Data Energi & Ketenagalistrikan</h5>
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

        <form action="{{ route('energi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="desa" class="form-label fw-semibold">Desa / Lokasi</label>
                    <input type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" name="desa" value="{{ old('desa') }}" required placeholder="Contoh: Desa Taloarane, Sitaro">
                    @error('desa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sumber_energi" class="form-label fw-semibold">Sumber Energi</label>
                    <input type="text" class="form-control @error('sumber_energi') is-invalid @enderror" id="sumber_energi" name="sumber_energi" value="{{ old('sumber_energi') }}" required placeholder="Contoh: PLTD, Solar Panel, PLTMH">
                    @error('sumber_energi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kapasitas" class="form-label fw-semibold">Kapasitas (MW / kW)</label>
                    <input type="text" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="Contoh: 500 kW">
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jaringan" class="form-label fw-semibold">Kondisi Jaringan</label>
                    <input type="text" class="form-control @error('jaringan') is-invalid @enderror" id="jaringan" name="jaringan" value="{{ old('jaringan') }}" placeholder="Contoh: Jaringan TM & TR 3 Phase">
                    @error('jaringan')
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
                    <label for="potensi_ebt" class="form-label fw-semibold">Potensi EBT (Energi Baru Terbarukan)</label>
                    <textarea class="form-control @error('potensi_ebt') is-invalid @enderror" id="potensi_ebt" name="potensi_ebt" rows="3" placeholder="Contoh: Potensi arus laut, potensi hidro">{{ old('potensi_ebt') }}</textarea>
                    @error('potensi_ebt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kondisi_infrastruktur" class="form-label fw-semibold">Kondisi Infrastruktur</label>
                    <textarea class="form-control @error('kondisi_infrastruktur') is-invalid @enderror" id="kondisi_infrastruktur" name="kondisi_infrastruktur" rows="3" placeholder="Contoh: Genset terawat baik, tiang transmisi aman">{{ old('kondisi_infrastruktur') }}</textarea>
                    @error('kondisi_infrastruktur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="permasalahan" class="form-label fw-semibold">Permasalahan</label>
                    <textarea class="form-control @error('permasalahan') is-invalid @enderror" id="permasalahan" name="permasalahan" rows="3" placeholder="Contoh: Distribusi BBM solar sering terkendala cuaca laut">{{ old('permasalahan') }}</textarea>
                    @error('permasalahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('energi.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
