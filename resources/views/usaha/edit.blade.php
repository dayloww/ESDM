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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('usaha.update', $usaha->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_pelaku_usaha" class="form-label fw-semibold">Nama Pelaku Usaha</label>
                    <input type="text" class="form-control @error('nama_pelaku_usaha') is-invalid @enderror" id="nama_pelaku_usaha" name="nama_pelaku_usaha" value="{{ old('nama_pelaku_usaha', $usaha->nama_pelaku_usaha) }}" required>
                    @error('nama_pelaku_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_identitas" class="form-label fw-semibold">Nomor Identitas (NIK/NIB)</label>
                    <input type="text" class="form-control @error('nomor_identitas') is-invalid @enderror" id="nomor_identitas" name="nomor_identitas" value="{{ old('nomor_identitas', $usaha->nomor_identitas) }}">
                    @error('nomor_identitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_perizinan" class="form-label fw-semibold">Nomor Perizinan</label>
                    <input type="text" class="form-control @error('nomor_perizinan') is-invalid @enderror" id="nomor_perizinan" name="nomor_perizinan" value="{{ old('nomor_perizinan', $usaha->nomor_perizinan) }}">
                    @error('nomor_perizinan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_usaha" class="form-label fw-semibold">Jenis Usaha</label>
                    <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror" id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha', $usaha->jenis_usaha) }}" required>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="komoditas" class="form-label fw-semibold">Komoditas</label>
                    <input type="text" class="form-control @error('komoditas') is-invalid @enderror" id="komoditas" name="komoditas" value="{{ old('komoditas', $usaha->komoditas) }}">
                    @error('komoditas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi Usaha</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $usaha->lokasi) }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="koordinat" class="form-label fw-semibold">Koordinat GPS</label>
                    <input type="text" class="form-control @error('koordinat') is-invalid @enderror" id="koordinat" name="koordinat" value="{{ old('koordinat', $usaha->koordinat) }}">
                    @error('koordinat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status Perizinan</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="aktif" {{ old('status', $usaha->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $usaha->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="izin_habis" {{ old('status', $usaha->status) == 'izin_habis' ? 'selected' : '' }}>Izin Habis</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="produksi" class="form-label fw-semibold">Nilai/Volume Produksi (jika ada)</label>
                    <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi', $usaha->produksi) }}">
                    @error('produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="penjualan" class="form-label fw-semibold">Nilai Penjualan (Rp)</label>
                    <input type="number" step="0.01" class="form-control @error('penjualan') is-invalid @enderror" id="penjualan" name="penjualan" value="{{ old('penjualan', $usaha->penjualan) }}">
                    @error('penjualan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumen" class="form-label fw-semibold">Upload Dokumen Perizinan (PDF, Word, Excel, Max 10MB - Biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen" name="dokumen">
                    @if($usaha->dokumen)
                        <div class="form-text text-success">Dokumen saat ini: <a href="{{ asset('storage/' . $usaha->dokumen) }}" target="_blank">Lihat Dokumen</a></div>
                    @endif
                    @error('dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="foto" class="form-label fw-semibold">Upload Foto Usaha/Lapangan (JPEG, PNG, JPG, Max 5MB - Biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                    @if($usaha->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $usaha->foto) }}" alt="Foto Usaha" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    @endif
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('usaha.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
