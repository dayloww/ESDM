@extends('layouts.app')

@section('title', 'Tambah Pengawasan')
@section('page-title', 'Tambah Pengawasan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pengawasan.index') }}">Pengawasan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Laporan Pengawasan</h5>
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

        <form action="{{ route('pengawasan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal Pengawasan</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="petugas" class="form-label fw-semibold">Petugas Pemeriksa</label>
                    <input type="text" class="form-control @error('petugas') is-invalid @enderror" id="petugas" name="petugas" value="{{ old('petugas') }}" required placeholder="Contoh: Tim Pengawas Wilayah IV">
                    @error('petugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="objek" class="form-label fw-semibold">Objek Pengawasan</label>
                    <input type="text" class="form-control @error('objek') is-invalid @enderror" id="objek" name="objek" value="{{ old('objek') }}" required placeholder="Contoh: Tambang Emas Rakyat PT. Sangihe Emas">
                    @error('objek')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi Pengawasan</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Desa Taloarane, Sangihe">
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status Tindak Lanjut</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dalam_proses" {{ old('status') == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="tertunda" {{ old('status') == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumentasi" class="form-label fw-semibold">Upload Berkas/Foto Lapangan (Max 10MB)</label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" id="dokumentasi" name="dokumentasi">
                    @error('dokumentasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hasil" class="form-label fw-semibold">Hasil Pengawasan</label>
                    <textarea class="form-control @error('hasil') is-invalid @enderror" id="hasil" name="hasil" rows="3" placeholder="Deskripsikan hasil pemeriksaan lapangan">{{ old('hasil') }}</textarea>
                    @error('hasil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="temuan" class="form-label fw-semibold">Temuan Lapangan</label>
                    <textarea class="form-control @error('temuan') is-invalid @enderror" id="temuan" name="temuan" rows="3" placeholder="Contoh: Dokumen K3 kurang lengkap, ada erosi lereng">{{ old('temuan') }}</textarea>
                    @error('temuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="rekomendasi" class="form-label fw-semibold">Rekomendasi Petugas</label>
                    <textarea class="form-control @error('rekomendasi') is-invalid @enderror" id="rekomendasi" name="rekomendasi" rows="3" placeholder="Contoh: Memperbaiki lereng dalam waktu 14 hari">{{ old('rekomendasi') }}</textarea>
                    @error('rekomendasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tindak_lanjut" class="form-label fw-semibold">Tindak Lanjut Pelaku Usaha</label>
                    <textarea class="form-control @error('tindak_lanjut') is-invalid @enderror" id="tindak_lanjut" name="tindak_lanjut" rows="3" placeholder="Realisasi perbaikan lapangan oleh pelaku usaha">{{ old('tindak_lanjut') }}</textarea>
                    @error('tindak_lanjut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('pengawasan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
