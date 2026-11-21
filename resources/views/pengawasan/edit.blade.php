@extends('layouts.app')

@section('title', 'Edit Pengawasan')
@section('page-title', 'Edit Pengawasan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pengawasan.index') }}">Pengawasan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Laporan Pengawasan</h5>
    </div>
    <div class="card-body">
        @include('partials.form-errors')

        <form action="{{ route('pengawasan.update', $pengawasan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal pengawasan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $pengawasan->tanggal) }}" required @error('tanggal') aria-invalid="true" aria-describedby="tanggal-error" @enderror>
                    @error('tanggal')
                        <div id="tanggal-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="petugas" class="form-label fw-semibold">Petugas pemeriksa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('petugas') is-invalid @enderror" id="petugas" name="petugas" value="{{ old('petugas', $pengawasan->petugas) }}" placeholder="Contoh: Tim Pengawas Wilayah IV" required @error('petugas') aria-invalid="true" aria-describedby="petugas-error" @enderror>
                    @error('petugas')
                        <div id="petugas-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="objek" class="form-label fw-semibold">Objek pengawasan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('objek') is-invalid @enderror" id="objek" name="objek" value="{{ old('objek', $pengawasan->objek) }}" placeholder="Contoh: Tambang Emas Rakyat PT. Sangihe Emas" required @error('objek') aria-invalid="true" aria-describedby="objek-error" @enderror>
                    @error('objek')
                        <div id="objek-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Lokasi pengawasan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $pengawasan->lokasi) }}" placeholder="Contoh: Desa Taloarane, Sangihe" required @error('lokasi') aria-invalid="true" aria-describedby="lokasi-error" @enderror>
                    @error('lokasi')
                        <div id="lokasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status tindak lanjut <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required  @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
                        <option value="selesai" {{ old('status', $pengawasan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dalam_proses" {{ old('status', $pengawasan->status) == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="tertunda" {{ old('status', $pengawasan->status) == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                    </select>
                    @error('status')
                        <div id="status-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dokumentasi" class="form-label fw-semibold">Upload berkas/foto lapangan (max 10MB - biarkan kosong jika tidak diubah)</label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" id="dokumentasi" name="dokumentasi"  @error('dokumentasi') aria-invalid="true" aria-describedby="dokumentasi-error" @enderror>
                    @if($pengawasan->dokumentasi)
                        <div class="form-text text-success">File saat ini: <a href="{{ asset('storage/' . $pengawasan->dokumentasi) }}" target="_blank">Lihat Dokumentasi</a></div>
                    @endif
                    @error('dokumentasi')
                        <div id="dokumentasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hasil" class="form-label fw-semibold">Hasil pengawasan</label>
                    <textarea class="form-control @error('hasil') is-invalid @enderror" id="hasil" name="hasil" rows="3" placeholder="Deskripsikan hasil pemeriksaan lapangan"  @error('hasil') aria-invalid="true" aria-describedby="hasil-error" @enderror>{{ old('hasil', $pengawasan->hasil) }}</textarea>
                    @error('hasil')
                        <div id="hasil-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="temuan" class="form-label fw-semibold">Temuan lapangan</label>
                    <textarea class="form-control @error('temuan') is-invalid @enderror" id="temuan" name="temuan" rows="3" placeholder="Contoh: Dokumen K3 kurang lengkap, ada erosi lereng"  @error('temuan') aria-invalid="true" aria-describedby="temuan-error" @enderror>{{ old('temuan', $pengawasan->temuan) }}</textarea>
                    @error('temuan')
                        <div id="temuan-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="rekomendasi" class="form-label fw-semibold">Rekomendasi petugas</label>
                    <textarea class="form-control @error('rekomendasi') is-invalid @enderror" id="rekomendasi" name="rekomendasi" rows="3" placeholder="Contoh: Memperbaiki lereng dalam waktu 14 hari"  @error('rekomendasi') aria-invalid="true" aria-describedby="rekomendasi-error" @enderror>{{ old('rekomendasi', $pengawasan->rekomendasi) }}</textarea>
                    @error('rekomendasi')
                        <div id="rekomendasi-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tindak_lanjut" class="form-label fw-semibold">Tindak lanjut pelaku usaha</label>
                    <textarea class="form-control @error('tindak_lanjut') is-invalid @enderror" id="tindak_lanjut" name="tindak_lanjut" rows="3" placeholder="Realisasi perbaikan lapangan oleh pelaku usaha"  @error('tindak_lanjut') aria-invalid="true" aria-describedby="tindak_lanjut-error" @enderror>{{ old('tindak_lanjut', $pengawasan->tindak_lanjut) }}</textarea>
                    @error('tindak_lanjut')
                        <div id="tindak_lanjut-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('partials.form-actions', ['cancelRoute' => route('pengawasan.index'), 'submitLabel' => 'Perbarui'])
        </form>
    </div>
</div>
@endsection
