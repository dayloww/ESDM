@extends('layouts.app')

@section('title', 'Edit Usaha ESDM')
@section('page-title', 'Edit Usaha ESDM')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('usaha.index') }}">Usaha ESDM</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Usaha ESDM</h5>
    </div>
    <div class="card-body">
        @include('partials.form-errors')

        <form action="{{ route('usaha.update', $usaha->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_pelaku_usaha" class="form-label fw-semibold">Nama pelaku usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_pelaku_usaha') is-invalid @enderror" id="nama_pelaku_usaha" name="nama_pelaku_usaha" value="{{ old('nama_pelaku_usaha', $usaha->nama_pelaku_usaha) }}" placeholder="Contoh: PT. Minahasa Mining" required @error('nama_pelaku_usaha') aria-invalid="true" aria-describedby="nama_pelaku_usaha-error" @enderror>
                    @error('nama_pelaku_usaha')
                        <div id="nama_pelaku_usaha-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_identitas" class="form-label fw-semibold">Nomor identitas (NIK/NIB)</label>
                    <input type="text" class="form-control @error('nomor_identitas') is-invalid @enderror" id="nomor_identitas" name="nomor_identitas" value="{{ old('nomor_identitas', $usaha->nomor_identitas) }}" placeholder="Contoh: 71710123456789" @error('nomor_identitas') aria-invalid="true" aria-describedby="nomor_identitas-error" @enderror>
                    @error('nomor_identitas')
                        <div id="nomor_identitas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_perizinan" class="form-label fw-semibold">Nomor perizinan</label>
                    <input type="text" class="form-control @error('nomor_perizinan') is-invalid @enderror" id="nomor_perizinan" name="nomor_perizinan" value="{{ old('nomor_perizinan', $usaha->nomor_perizinan) }}" placeholder="Contoh: IUP-1234/ESDM/2026" @error('nomor_perizinan') aria-invalid="true" aria-describedby="nomor_perizinan-error" @enderror>
                    @error('nomor_perizinan')
                        <div id="nomor_perizinan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_usaha" class="form-label fw-semibold">Jenis usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror" id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha', $usaha->jenis_usaha) }}" placeholder="Contoh: Pertambangan Emas, Ketenagalistrikan" required @error('jenis_usaha') aria-invalid="true" aria-describedby="jenis_usaha-error" @enderror>
                    @error('jenis_usaha')
                        <div id="jenis_usaha-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="komoditas" class="form-label fw-semibold">Komoditas</label>
                    <input type="text" class="form-control @error('komoditas') is-invalid @enderror" id="komoditas" name="komoditas" value="{{ old('komoditas', $usaha->komoditas) }}" placeholder="Contoh: Biji Emas, Listrik PLTMH" @error('komoditas') aria-invalid="true" aria-describedby="komoditas-error" @enderror>
                    @error('komoditas')
                        <div id="komoditas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $usaha->lokasi) }}" placeholder="Contoh: Manganitu, Sangihe" required @error('lokasi') aria-invalid="true" aria-describedby="lokasi-error" @enderror>
                    @error('lokasi')
                        <div id="lokasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="koordinat" class="form-label fw-semibold">Koordinat GPS</label>
                    <input type="text" class="form-control @error('koordinat') is-invalid @enderror" id="koordinat" name="koordinat" value="{{ old('koordinat', $usaha->koordinat) }}" placeholder="Contoh: 1.456, 125.123" @error('koordinat') aria-invalid="true" aria-describedby="koordinat-error" @enderror>
                    @error('koordinat')
                        <div id="koordinat-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status perizinan <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required  @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
                        <option value="aktif" {{ old('status', $usaha->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $usaha->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="izin_habis" {{ old('status', $usaha->status) == 'izin_habis' ? 'selected' : '' }}>Izin Habis</option>
                    </select>
                    @error('status')
                        <div id="status-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="produksi" class="form-label fw-semibold">Nilai/volume produksi (jika ada)</label>
                    <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi', $usaha->produksi) }}" placeholder="Masukkan nilai produksi" @error('produksi') aria-invalid="true" aria-describedby="produksi-error" @enderror>
                    @error('produksi')
                        <div id="produksi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="penjualan" class="form-label fw-semibold">Nilai penjualan (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('penjualan') is-invalid @enderror" id="penjualan" name="penjualan" value="{{ old('penjualan', $usaha->penjualan) }}" placeholder="Masukkan nilai penjualan" @error('penjualan') aria-invalid="true" aria-describedby="penjualan-error" @enderror>
                    @error('penjualan')
                        <div id="penjualan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumen" class="form-label fw-semibold">Upload dokumen perizinan (PDF, Word, Excel, max 10MB - biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen" name="dokumen"  @error('dokumen') aria-invalid="true" aria-describedby="dokumen-error" @enderror>
                    @if($usaha->dokumen)
                        <div class="form-text text-success">Dokumen saat ini: <a href="{{ asset('storage/' . $usaha->dokumen) }}" target="_blank">Lihat Dokumen</a></div>
                    @endif
                    @error('dokumen')
                        <div id="dokumen-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="foto" class="form-label fw-semibold">Upload foto usaha/lapangan (JPEG, PNG, JPG, max 5MB - biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*"  @error('foto') aria-invalid="true" aria-describedby="foto-error" @enderror>
                    @if($usaha->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $usaha->foto) }}" alt="Foto Usaha" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    @endif
                    @error('foto')
                        <div id="foto-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('partials.form-actions', ['cancelRoute' => route('usaha.index'), 'submitLabel' => 'Perbarui'])
        </form>
    </div>
</div>
@endsection
