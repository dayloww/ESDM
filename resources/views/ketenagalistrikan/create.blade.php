@extends('layouts.app')

@section('title', 'Tambah Data Ketenagalistrikan')
@section('page-title', 'Tambah Data Ketenagalistrikan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ketenagalistrikan.index') }}">Ketenagalistrikan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('partials.form-errors')

<form action="{{ route('ketenagalistrikan.store') }}" method="POST" enctype="multipart/form-data" id="ketenagalistrikanForm">
    @csrf

    <input type="hidden" name="jenis_usaha" value="UPTL">

    {{-- ── INFORMASI UPTL ────────────────────────────────────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-building-fill text-info"></i>
            <div>
                <h6 class="mb-0 fw-semibold">Informasi UPTL</h6>
                <small class="text-muted">Usaha Penunjang Tenaga Listrik</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nomor_izin" class="form-label fw-semibold">Nomor izin</label>
                    <input type="text" class="form-control @error('nomor_izin') is-invalid @enderror"
                           id="nomor_izin" name="nomor_izin"
                           value="{{ old('nomor_izin') }}"
                           placeholder="Contoh: 503/UPTL/001/2024"  @error('nomor_izin') aria-invalid="true" aria-describedby="nomor_izin-error" @enderror>
                    @error('nomor_izin') <div id="nomor_izin-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="nama_badan_usaha" class="form-label fw-semibold">Nama badan usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_badan_usaha') is-invalid @enderror"
                           id="nama_badan_usaha" name="nama_badan_usaha"
                           value="{{ old('nama_badan_usaha') }}"
                           placeholder="Contoh: CV Talaud Teknik Listrik" required  @error('nama_badan_usaha') aria-invalid="true" aria-describedby="nama_badan_usaha-error" @enderror>
                    @error('nama_badan_usaha') <div id="nama_badan_usaha-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="nib" class="form-label fw-semibold">NIB</label>
                    <input type="text" class="form-control @error('nib') is-invalid @enderror"
                           id="nib" name="nib"
                           value="{{ old('nib') }}"
                           placeholder="Nomor Induk Berusaha"  @error('nib') aria-invalid="true" aria-describedby="nib-error" @enderror>
                    @error('nib') <div id="nib-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="penanggung_jawab" class="form-label fw-semibold">Penanggung jawab</label>
                    <input type="text" class="form-control @error('penanggung_jawab') is-invalid @enderror"
                           id="penanggung_jawab" name="penanggung_jawab"
                           value="{{ old('penanggung_jawab') }}"
                           placeholder="Nama penanggung jawab"  @error('penanggung_jawab') aria-invalid="true" aria-describedby="penanggung_jawab-error" @enderror>
                    @error('penanggung_jawab') <div id="penanggung_jawab-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="jenis_usaha_penunjang" class="form-label fw-semibold">Jenis usaha penunjang</label>
                    <input type="text" class="form-control @error('jenis_usaha_penunjang') is-invalid @enderror"
                           id="jenis_usaha_penunjang" name="jenis_usaha_penunjang"
                           value="{{ old('jenis_usaha_penunjang') }}"
                           placeholder="Contoh: Konsultansi, Pembangunan"  @error('jenis_usaha_penunjang') aria-invalid="true" aria-describedby="jenis_usaha_penunjang-error" @enderror>
                    @error('jenis_usaha_penunjang') <div id="jenis_usaha_penunjang-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="bidang_kegiatan" class="form-label fw-semibold">Bidang kegiatan</label>
                    <input type="text" class="form-control @error('bidang_kegiatan') is-invalid @enderror"
                           id="bidang_kegiatan" name="bidang_kegiatan"
                           value="{{ old('bidang_kegiatan') }}"
                           placeholder="Contoh: Instalasi jaringan distribusi"  @error('bidang_kegiatan') aria-invalid="true" aria-describedby="bidang_kegiatan-error" @enderror>
                    @error('bidang_kegiatan') <div id="bidang_kegiatan-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="klasifikasi_usaha" class="form-label fw-semibold">Klasifikasi usaha</label>
                    <input type="text" class="form-control @error('klasifikasi_usaha') is-invalid @enderror"
                           id="klasifikasi_usaha" name="klasifikasi_usaha"
                           value="{{ old('klasifikasi_usaha') }}"
                           placeholder="Contoh: Kecil / Menengah / Besar"  @error('klasifikasi_usaha') aria-invalid="true" aria-describedby="klasifikasi_usaha-error" @enderror>
                    @error('klasifikasi_usaha') <div id="klasifikasi_usaha-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── LOKASI & PERIZINAN ───────────────────────────────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-calendar2-check-fill text-success"></i>
            <h6 class="mb-0 fw-semibold">Lokasi & Perizinan</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="latitude" class="form-label fw-semibold">Latitude</label>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                           id="latitude" name="latitude"
                           value="{{ old('latitude') }}"
                           placeholder="Contoh: 3.6121"  @error('latitude') aria-invalid="true" aria-describedby="latitude-error" @enderror>
                    @error('latitude') <div id="latitude-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="longitude" class="form-label fw-semibold">Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                           id="longitude" name="longitude"
                           value="{{ old('longitude') }}"
                           placeholder="Contoh: 125.4752"  @error('longitude') aria-invalid="true" aria-describedby="longitude-error" @enderror>
                    @error('longitude') <div id="longitude-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal terbit</label>
                    <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror"
                           id="tanggal_terbit" name="tanggal_terbit"
                           value="{{ old('tanggal_terbit') }}"  @error('tanggal_terbit') aria-invalid="true" aria-describedby="tanggal_terbit-error" @enderror>
                    @error('tanggal_terbit') <div id="tanggal_terbit-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="masa_berlaku" class="form-label fw-semibold">Masa berlaku</label>
                    <input type="date" class="form-control @error('masa_berlaku') is-invalid @enderror"
                           id="masa_berlaku" name="masa_berlaku"
                           value="{{ old('masa_berlaku') }}"  @error('masa_berlaku') aria-invalid="true" aria-describedby="masa_berlaku-error" @enderror>
                    @error('masa_berlaku') <div id="masa_berlaku-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status"  @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
                        <option value="">— Pilih Status —</option>
                        <option value="aktif"    {{ old('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="habis"    {{ old('status') === 'habis'    ? 'selected' : '' }}>Habis / Kedaluwarsa</option>
                    </select>
                    @error('status') <div id="status-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── INFORMASI LOKASI ENERGI (selalu tampil) ──────────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-lightning-charge-fill text-warning"></i>
            <h6 class="mb-0 fw-semibold">Informasi Lokasi</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="desa" class="form-label fw-semibold">Desa / lokasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                           id="desa" name="desa"
                           value="{{ old('desa') }}"
                           required placeholder="Contoh: Desa Taloarane, Sitaro"  @error('desa') aria-invalid="true" aria-describedby="desa-error" @enderror>
                    @error('desa') <div id="desa-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3"
                              placeholder="Catatan tambahan"  @error('keterangan') aria-invalid="true" aria-describedby="keterangan-error" @enderror>{{ old('keterangan') }}</textarea>
                    @error('keterangan') <div id="keterangan-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="dokumentasi" class="form-label fw-semibold">
                        Dokumentasi <small class="text-muted fw-normal">(PDF, Word, Excel, gambar — maks. 10MB)</small>
                    </label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror"
                           id="dokumentasi" name="dokumentasi"  @error('dokumentasi') aria-invalid="true" aria-describedby="dokumentasi-error" @enderror>
                    @error('dokumentasi') <div id="dokumentasi-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── TOMBOL ───────────────────────────────────────────────── --}}
    @include('partials.form-actions', ['cancelRoute' => route('ketenagalistrikan.index'), 'submitLabel' => 'Simpan'])

</form>
@endsection
