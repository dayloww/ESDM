@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
@endsection

@section('content')
<div class="card mb-4 no-print">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="tipe" class="form-label fw-semibold">Tipe Laporan</label>
                <select class="form-select" id="tipe" name="tipe" onchange="this.form.submit()">
                    <option value="usaha" {{ $tipe == 'usaha' ? 'selected' : '' }}>Data Usaha ESDM</option>
                    <option value="mineral" {{ $tipe == 'mineral' ? 'selected' : '' }}>Mineral & Pertambangan</option>
                    <option value="energi" {{ $tipe == 'energi' ? 'selected' : '' }}>Energi & Ketenagalistrikan</option>
                    <option value="pengawasan" {{ $tipe == 'pengawasan' ? 'selected' : '' }}>Pengawasan</option>
                    <option value="pad" {{ $tipe == 'pad' ? 'selected' : '' }}>Potensi PAD</option>
                </select>
            </div>
            
            {{-- Optional conditional filters based on selected report --}}
            @if($tipe == 'usaha')
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Status Perizinan</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="izin_habis" {{ request('status') == 'izin_habis' ? 'selected' : '' }}>Izin Habis</option>
                    </select>
                </div>
            @elseif($tipe == 'pengawasan')
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Status Tindak Lanjut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dalam_proses" {{ request('status') == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="tertunda" {{ request('status') == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                    </select>
                </div>
            @endif

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Terapkan Filter
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success w-100" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak PDF
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Printable Area --}}
<div class="card printable-area">
    <div class="card-body">
        
        {{-- Print Header Header --}}
        <div class="print-header text-center mb-4 d-none d-print-block">
            <h4 class="mb-1 fw-bold">PEMERINTAH PROVINSI SULAWESI UTARA</h4>
            <h5 class="mb-1 fw-semibold">DINAS ENERGI DAN SUMBER DAYA MINERAL DAERAH</h5>
            <p class="mb-0 small text-muted">Cabang Dinas Wilayah IV · Kabupaten Sangihe, Talaud, dan Sitaro</p>
            <hr class="my-3 border-dark" style="border-width: 2px;">
            <h5 class="fw-bold text-uppercase mt-2">
                LAPORAN DATA @if($tipe == 'usaha') USAHA ESDM @elseif($tipe == 'mineral') MINERAL & PERTAMBANGAN @elseif($tipe == 'energi') ENERGI & KETENAGALISTRIKAN @elseif($tipe == 'pengawasan') PENGAWASAN LAPANGAN @elseif($tipe == 'pad') ESTIMASI POTENSI PAD @endif
            </h5>
            <p class="small text-muted mb-4">Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3 no-print">
            <h5 class="mb-0 fw-semibold text-primary text-uppercase">
                Pratinjau Laporan @if($tipe == 'usaha') Usaha ESDM @elseif($tipe == 'mineral') Mineral @elseif($tipe == 'energi') Energi @elseif($tipe == 'pengawasan') Pengawasan @elseif($tipe == 'pad') Potensi PAD @endif
            </h5>
            <span class="badge bg-secondary">Total: {{ $data->count() }} Data</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="reportResultTable">
                
                @if($tipe == 'usaha')
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Pelaku Usaha</th>
                            <th>No. Perizinan</th>
                            <th>Jenis Usaha</th>
                            <th>Komoditas</th>
                            <th>Lokasi</th>
                            <th>Produksi</th>
                            <th>Penjualan (Rp)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $u->nama_pelaku_usaha }}</strong><br>
                                    <span class="text-muted small">ID: {{ $u->nomor_identitas ?? '-' }}</span>
                                </td>
                                <td><code>{{ $u->nomor_perizinan ?? '-' }}</code></td>
                                <td>{{ $u->jenis_usaha }}</td>
                                <td>{{ $u->komoditas ?? '-' }}</td>
                                <td>{{ $u->lokasi }}</td>
                                <td>{{ $u->produksi ? number_format($u->produksi) : '-' }}</td>
                                <td>{{ $u->penjualan ? number_format($u->penjualan, 0, ',', '.') : '-' }}</td>
                                <td><span class="badge bg-{{ $u->status == 'aktif' ? 'success' : ($u->status == 'nonaktif' ? 'secondary' : 'danger') }}">{{ $u->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                
                @elseif($tipe == 'mineral')
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Pemegang Izin</th>
                            <th>Komoditas</th>
                            <th>Luas (Ha)</th>
                            <th>Produksi (Ton/Thn)</th>
                            <th>Lokasi Tambang</th>
                            <th>Hasil Pemantauan</th>
                            <th>Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $m)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $m->pemegang_izin }}</strong></td>
                                <td>{{ $m->jenis_komoditas }}</td>
                                <td>{{ $m->luas ? number_format($m->luas) . ' Ha' : '-' }}</td>
                                <td>{{ $m->produksi ? number_format($m->produksi) . ' Ton' : '-' }}</td>
                                <td>{{ $m->lokasi }}</td>
                                <td>{{ $m->hasil_pemantauan ?? '-' }}</td>
                                <td>{{ $m->tindak_lanjut ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($tipe == 'energi')
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Desa / Lokasi</th>
                            <th>Sumber Energi</th>
                            <th>Kapasitas</th>
                            <th>Jaringan</th>
                            <th>Potensi EBT</th>
                            <th>Kondisi Infrastruktur</th>
                            <th>Permasalahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $e)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $e->desa }}</strong></td>
                                <td>{{ $e->sumber_energi }}</td>
                                <td>{{ $e->kapasitas ?? '-' }}</td>
                                <td>{{ $e->jaringan ?? '-' }}</td>
                                <td>{{ $e->potensi_ebt ?? '-' }}</td>
                                <td>{{ $e->kondisi_infrastruktur ?? '-' }}</td>
                                <td>{{ $e->permasalahan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($tipe == 'pengawasan')
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Petugas</th>
                            <th>Objek Pengawasan</th>
                            <th>Lokasi</th>
                            <th>Hasil</th>
                            <th>Temuan</th>
                            <th>Rekomendasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td>{{ $p->petugas }}</td>
                                <td><strong>{{ $p->objek }}</strong></td>
                                <td>{{ $p->lokasi }}</td>
                                <td>{{ $p->hasil ?? '-' }}</td>
                                <td>{{ $p->temuan ?? '-' }}</td>
                                <td>{{ $p->rekomendasi ?? '-' }}</td>
                                <td><span class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'dalam_proses' ? 'warning text-dark' : 'danger') }}">{{ $p->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>

                @elseif($tipe == 'pad')
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Jenis Kegiatan</th>
                            <th>Komoditas</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Periode</th>
                            <th>Nilai Produksi</th>
                            <th>Pelaku Usaha</th>
                            <th>Lokasi</th>
                            <th>Estimasi Penerimaan PAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $p->jenis_kegiatan }}</strong></td>
                                <td>{{ $p->komoditas ?? '-' }}</td>
                                <td>{{ $p->volume ? number_format($p->volume) : '-' }}</td>
                                <td>{{ $p->satuan ?? '-' }}</td>
                                <td>{{ $p->periode ?? '-' }}</td>
                                <td>{{ $p->nilai_produksi ? 'Rp ' . number_format($p->nilai_produksi, 0, ',', '.') : '-' }}</td>
                                <td>{{ $p->pelaku_usaha ?? '-' }}</td>
                                <td>{{ $p->lokasi }}</td>
                                <td><strong>Rp {{ number_format($p->estimasi_penerimaan, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif

            </table>
        </div>

        {{-- Print Signatures mockup --}}
        <div class="print-signatures row mt-5 d-none d-print-flex">
            <div class="col-6"></div>
            <div class="col-6 text-center">
                <p class="mb-5">Mengetahui,<br>Kepala Cabang Dinas Wilayah IV</p>
                <div style="height: 60px;"></div>
                <p class="fw-bold mb-0">___________________________</p>
                <p class="small text-muted">NIP. 19780512 200501 1 002</p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        #sidebar, #topbar, .no-print, .breadcrumb, #page-footer {
            display: none !important;
        }
        #main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        #page-content {
            padding: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        .printable-area {
            border: none !important;
        }
        body {
            background-color: #fff !important;
        }
    }
</style>
@endpush
