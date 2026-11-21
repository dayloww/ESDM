@extends('layouts.app')

@section('title', 'Edit Data Energi')
@section('page-title', 'Edit Data Energi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('energi.index') }}">Energi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
@include('partials.form-errors')

<form action="{{ route('energi.update', $energi->id) }}" method="POST" enctype="multipart/form-data" id="energiForm">
    @csrf
    @method('PUT')

    {{-- ── JENIS USAHA ─────────────────────────────────────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-ui-checks text-primary"></i>
            <h6 class="mb-0 fw-semibold">Jenis Usaha</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="jenis_usaha" class="form-label fw-semibold">Jenis usaha <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_usaha') is-invalid @enderror"
                            id="jenis_usaha" name="jenis_usaha"
                            onchange="updateFormSections(this.value)" required  @error('jenis_usaha') aria-invalid="true" aria-describedby="jenis_usaha-error" @enderror>
                        <option value="">— Pilih Jenis Usaha —</option>
                        <option value="IUPTLS" {{ old('jenis_usaha', $energi->jenis_usaha) === 'IUPTLS' ? 'selected' : '' }}>IUPTLS — Izin Usaha Penyediaan Tenaga Listrik untuk Kepentingan Sendiri</option>
                        <option value="Lainnya" {{ old('jenis_usaha', $energi->jenis_usaha) === 'Lainnya' ? 'selected' : '' }}>Jenis Usaha Lainnya</option>
                    </select>
                    @error('jenis_usaha')
                        <div id="jenis_usaha-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── SECTION IUPTLS ──────────────────────────────────────── --}}
    <div class="card mb-3" id="iuptlsFields" style="display:none;">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-file-earmark-check-fill text-primary"></i>
            <div>
                <h6 class="mb-0 fw-semibold">Informasi IUPTLS</h6>
                <small class="text-muted">Izin Usaha Penyediaan Tenaga Listrik untuk Kepentingan Sendiri</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="iuptls_nomor_izin" class="form-label fw-semibold">Nomor izin</label>
                    <input type="text" class="form-control @error('nomor_izin') is-invalid @enderror"
                           id="iuptls_nomor_izin" name="nomor_izin"
                           value="{{ old('nomor_izin', $energi->nomor_izin) }}"
                           placeholder="Contoh: 503/IUPTLS/001/2024" disabled @error('nomor_izin') aria-invalid="true" aria-describedby="nomor_izin-error" @enderror>
                    @error('nomor_izin') <div id="nomor_izin-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="nama_pemegang_izin" class="form-label fw-semibold">Nama pemegang izin</label>
                    <input type="text" class="form-control @error('nama_pemegang_izin') is-invalid @enderror"
                           id="nama_pemegang_izin" name="nama_pemegang_izin"
                           value="{{ old('nama_pemegang_izin', $energi->nama_pemegang_izin) }}"
                           placeholder="Contoh: PT Sangihe Energi Mandiri" disabled @error('nama_pemegang_izin') aria-invalid="true" aria-describedby="nama_pemegang_izin-error" @enderror>
                    @error('nama_pemegang_izin') <div id="nama_pemegang_izin-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="iuptls_nib" class="form-label fw-semibold">NIB</label>
                    <input type="text" class="form-control @error('nib') is-invalid @enderror"
                           id="iuptls_nib" name="nib"
                           value="{{ old('nib', $energi->nib) }}"
                           placeholder="Nomor Induk Berusaha" disabled @error('nib') aria-invalid="true" aria-describedby="nib-error" @enderror>
                    @error('nib') <div id="nib-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8">
                    <label for="badan_usaha" class="form-label fw-semibold">Badan usaha / instansi</label>
                    <input type="text" class="form-control @error('badan_usaha') is-invalid @enderror"
                           id="badan_usaha" name="badan_usaha"
                           value="{{ old('badan_usaha', $energi->badan_usaha) }}"
                           placeholder="Contoh: PT Sangihe Energi Mandiri" disabled @error('badan_usaha') aria-invalid="true" aria-describedby="badan_usaha-error" @enderror>
                    @error('badan_usaha') <div id="badan_usaha-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="jenis_pembangkit" class="form-label fw-semibold">Jenis pembangkit</label>
                    <select class="form-select @error('jenis_pembangkit') is-invalid @enderror"
                            id="jenis_pembangkit" name="jenis_pembangkit" disabled  @error('jenis_pembangkit') aria-invalid="true" aria-describedby="jenis_pembangkit-error" @enderror>
                        <option value="">— Pilih —</option>
                        @foreach(['PLTS' => 'PLTS — Pembangkit Listrik Tenaga Surya', 'PLTD' => 'PLTD — Pembangkit Listrik Tenaga Diesel', 'PLTMH' => 'PLTMH — Pembangkit Listrik Tenaga Mikrohidro', 'PLTAn' => 'PLTAn — Pembangkit Listrik Tenaga Angin', 'Lainnya' => 'Lainnya'] as $val => $label)
                            <option value="{{ $val }}" {{ old('jenis_pembangkit', $energi->jenis_pembangkit) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis_pembangkit') <div id="jenis_pembangkit-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="jumlah_unit" class="form-label fw-semibold">Jumlah unit</label>
                    <input type="text" class="form-control @error('jumlah_unit') is-invalid @enderror"
                           id="jumlah_unit" name="jumlah_unit"
                           value="{{ old('jumlah_unit', $energi->jumlah_unit) }}"
                           placeholder="Contoh: 2 unit" disabled @error('jumlah_unit') aria-invalid="true" aria-describedby="jumlah_unit-error" @enderror>
                    @error('jumlah_unit') <div id="jumlah_unit-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── LOKASI & PERIZINAN (IUPTLS) ─────────────────────────── --}}
    <div class="card mb-3" id="lokasiPerizinanFields" style="display:none;">
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
                           value="{{ old('latitude', $energi->latitude) }}"
                           placeholder="Contoh: 3.6121" disabled @error('latitude') aria-invalid="true" aria-describedby="latitude-error" @enderror>
                    @error('latitude') <div id="latitude-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="longitude" class="form-label fw-semibold">Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                           id="longitude" name="longitude"
                           value="{{ old('longitude', $energi->longitude) }}"
                           placeholder="Contoh: 125.4752" disabled @error('longitude') aria-invalid="true" aria-describedby="longitude-error" @enderror>
                    @error('longitude') <div id="longitude-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal terbit</label>
                    <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror"
                           id="tanggal_terbit" name="tanggal_terbit"
                           value="{{ old('tanggal_terbit', $energi->tanggal_terbit?->format('Y-m-d')) }}" disabled @error('tanggal_terbit') aria-invalid="true" aria-describedby="tanggal_terbit-error" @enderror>
                    @error('tanggal_terbit') <div id="tanggal_terbit-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="masa_berlaku" class="form-label fw-semibold">Masa berlaku</label>
                    <input type="date" class="form-control @error('masa_berlaku') is-invalid @enderror"
                           id="masa_berlaku" name="masa_berlaku"
                           value="{{ old('masa_berlaku', $energi->masa_berlaku?->format('Y-m-d')) }}" disabled @error('masa_berlaku') aria-invalid="true" aria-describedby="masa_berlaku-error" @enderror>
                    @error('masa_berlaku') <div id="masa_berlaku-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" disabled  @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
                        <option value="">— Pilih Status —</option>
                        <option value="aktif"    {{ old('status', $energi->status) === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $energi->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="habis"    {{ old('status', $energi->status) === 'habis'    ? 'selected' : '' }}>Habis / Kedaluwarsa</option>
                    </select>
                    @error('status') <div id="status-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── INFORMASI ENERGI & LOKASI (selalu tampil) ───────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-lightning-charge-fill text-warning"></i>
            <h6 class="mb-0 fw-semibold">Informasi Energi & Lokasi</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="desa" class="form-label fw-semibold">Desa / lokasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                           id="desa" name="desa"
                           value="{{ old('desa', $energi->desa) }}"
                           required placeholder="Contoh: Desa Taloarane, Sitaro" @error('desa') aria-invalid="true" aria-describedby="desa-error" @enderror>
                    @error('desa') <div id="desa-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sumber_energi" class="form-label fw-semibold">Sumber energi</label>
                    <input type="text" class="form-control @error('sumber_energi') is-invalid @enderror"
                           id="sumber_energi" name="sumber_energi"
                           value="{{ old('sumber_energi', $energi->sumber_energi) }}"
                           placeholder="Contoh: PLTD, Solar Panel, PLTMH" @error('sumber_energi') aria-invalid="true" aria-describedby="sumber_energi-error" @enderror>
                    @error('sumber_energi') <div id="sumber_energi-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="kapasitas" class="form-label fw-semibold">Kapasitas</label>
                    <input type="text" class="form-control @error('kapasitas') is-invalid @enderror"
                           id="kapasitas" name="kapasitas"
                           value="{{ old('kapasitas', $energi->kapasitas) }}"
                           placeholder="Contoh: 500 kW" @error('kapasitas') aria-invalid="true" aria-describedby="kapasitas-error" @enderror>
                    @error('kapasitas') <div id="kapasitas-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="jaringan" class="form-label fw-semibold">Jaringan</label>
                    <input type="text" class="form-control @error('jaringan') is-invalid @enderror"
                           id="jaringan" name="jaringan"
                           value="{{ old('jaringan', $energi->jaringan) }}"
                           placeholder="Contoh: TM/TR 3 Phase" @error('jaringan') aria-invalid="true" aria-describedby="jaringan-error" @enderror>
                    @error('jaringan') <div id="jaringan-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── INFORMASI TAMBAHAN (selalu tampil) ─────────────────── --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i aria-hidden="true" class="bi bi-card-text text-secondary"></i>
            <h6 class="mb-0 fw-semibold">Informasi Tambahan</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="potensi_ebt" class="form-label fw-semibold">Potensi EBT</label>
                    <textarea class="form-control @error('potensi_ebt') is-invalid @enderror"
                              id="potensi_ebt" name="potensi_ebt" rows="3"
                              placeholder="Contoh: Potensi arus laut, potensi hidro"  @error('potensi_ebt') aria-invalid="true" aria-describedby="potensi_ebt-error" @enderror>{{ old('potensi_ebt', $energi->potensi_ebt) }}</textarea>
                    @error('potensi_ebt') <div id="potensi_ebt-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="kondisi_infrastruktur" class="form-label fw-semibold">Kondisi infrastruktur</label>
                    <textarea class="form-control @error('kondisi_infrastruktur') is-invalid @enderror"
                              id="kondisi_infrastruktur" name="kondisi_infrastruktur" rows="3"
                              placeholder="Contoh: Genset terawat baik, tiang transmisi aman"  @error('kondisi_infrastruktur') aria-invalid="true" aria-describedby="kondisi_infrastruktur-error" @enderror>{{ old('kondisi_infrastruktur', $energi->kondisi_infrastruktur) }}</textarea>
                    @error('kondisi_infrastruktur') <div id="kondisi_infrastruktur-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="permasalahan" class="form-label fw-semibold">Permasalahan</label>
                    <textarea class="form-control @error('permasalahan') is-invalid @enderror"
                              id="permasalahan" name="permasalahan" rows="3"
                              placeholder="Contoh: Distribusi BBM solar sering terkendala cuaca laut"  @error('permasalahan') aria-invalid="true" aria-describedby="permasalahan-error" @enderror>{{ old('permasalahan', $energi->permasalahan) }}</textarea>
                    @error('permasalahan') <div id="permasalahan-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3"
                              placeholder="Catatan tambahan"  @error('keterangan') aria-invalid="true" aria-describedby="keterangan-error" @enderror>{{ old('keterangan', $energi->keterangan) }}</textarea>
                    @error('keterangan') <div id="keterangan-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="dokumentasi" class="form-label fw-semibold">
                        Dokumentasi <small class="text-muted fw-normal">(kosongkan jika tidak ingin mengganti)</small>
                    </label>
                    <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror"
                           id="dokumentasi" name="dokumentasi"  @error('dokumentasi') aria-invalid="true" aria-describedby="dokumentasi-error" @enderror>
                    @if($energi->dokumentasi)
                        <div class="form-text">
                            <i aria-hidden="true" class="bi bi-paperclip"></i>
                            File saat ini:
                            <a href="{{ asset('storage/' . $energi->dokumentasi) }}" target="_blank" class="text-primary">
                                Lihat Dokumentasi
                            </a>
                        </div>
                    @endif
                    @error('dokumentasi') <div id="dokumentasi-error" class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── TOMBOL ───────────────────────────────────────────────── --}}
    @include('partials.form-actions', ['cancelRoute' => route('energi.index'), 'submitLabel' => 'Perbarui'])

</form>
@endsection

@push('scripts')
<script>
    function setDisabled(containerId, disabled) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = disabled;
        });
    }

    function updateFormSections(jenis) {
        const iuptlsFields    = document.getElementById('iuptlsFields');
        const lokasiPerizinan = document.getElementById('lokasiPerizinanFields');

        iuptlsFields.style.display    = 'none';
        lokasiPerizinan.style.display = 'none';

        setDisabled('iuptlsFields', true);
        setDisabled('lokasiPerizinanFields', true);

        if (jenis === 'IUPTLS') {
            iuptlsFields.style.display    = '';
            lokasiPerizinan.style.display = '';
            setDisabled('iuptlsFields', false);
            setDisabled('lokasiPerizinanFields', false);
        }
    }

    // Auto-restore section sesuai jenis_usaha yang tersimpan
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('jenis_usaha');
        if (select && select.value) {
            updateFormSections(select.value);
        }
    });
</script>
@endpush
