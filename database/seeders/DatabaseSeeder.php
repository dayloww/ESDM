<?php

namespace Database\Seeders;

use App\Models\DataWilayah;
use App\Models\Desa;
use App\Models\Energi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Mineral;
use App\Models\Pengawasan;
use App\Models\PotensiPad;
use App\Models\UsahaEsdm;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed roles terlebih dahulu
        $this->call(RoleSeeder::class);
        $this->call(KabupatenSeeder::class);
        $this->seedDemoDashboardData();

        // 2. Buat user admin default
        $adminRole = Role::where('nama_role', 'Admin')->first();

        User::firstOrCreate(
            ['email' => 'admin@esdm.go.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
                'role_id'  => $adminRole?->id,
                'status'   => 'aktif',
            ]
        );
    }

    private function seedDemoDashboardData(): void
    {
        $kabupatens = Kabupaten::whereIn('nama', [
            'Kabupaten Kepulauan Sangihe',
            'Kabupaten Kepulauan Talaud',
            'Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)',
        ])->get()->keyBy('nama');

        $kecamatanData = [
            'Kabupaten Kepulauan Sangihe' => [
                'Kecamatan Manganitu',
                'Kecamatan Tahuna',
            ],
            'Kabupaten Kepulauan Talaud' => [
                'Kecamatan Melonguane',
                'Kecamatan Beo',
            ],
            'Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)' => [
                'Kecamatan Siau Barat',
                'Kecamatan Tagulandang',
            ],
        ];

        $desaData = [
            'Kecamatan Manganitu' => ['Desa Taloarane', 'Desa Lalumpe'],
            'Kecamatan Tahuna' => ['Desa Santiago', 'Desa Dumuhung'],
            'Kecamatan Melonguane' => ['Desa Melonguane', 'Desa Kiama'],
            'Kecamatan Beo' => ['Desa Beo', 'Desa Lalue'],
            'Kecamatan Siau Barat' => ['Desa Balirangen', 'Desa Kapeta'],
            'Kecamatan Tagulandang' => ['Desa Lirung', 'Desa Buhias'],
        ];

        $kecamatans = [];

        foreach ($kecamatanData as $kabupatenNama => $names) {
            $kabupaten = $kabupatens->get($kabupatenNama);

            if (! $kabupaten) {
                continue;
            }

            foreach ($names as $index => $nama) {
                $kecamatan = Kecamatan::firstOrCreate(
                    [
                        'kabupaten_id' => $kabupaten->id,
                        'nama' => $nama,
                    ]
                );

                $kecamatans[$nama] = $kecamatan;
            }
        }

        $desas = [];

        foreach ($desaData as $kecamatanNama => $names) {
            $kecamatan = $kecamatans[$kecamatanNama] ?? null;

            if (! $kecamatan) {
                continue;
            }

            foreach ($names as $nama) {
                $desa = Desa::firstOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'nama' => $nama,
                    ]
                );

                $desas[$nama] = $desa;
            }
        }

        $dataWilayahData = [
            ['desa' => 'Desa Taloarane', 'koordinat' => '3.6121, 125.4752', 'jumlah_penduduk' => 1840, 'status' => 'berlistrik', 'kondisi' => 'Jaringan listrik stabil', 'energi' => 'PLTS atap dan listrik PLN', 'mineral' => 'Potensi pasir dan batu alam'],
            ['desa' => 'Desa Santiago', 'koordinat' => '3.6184, 125.4720', 'jumlah_penduduk' => 1265, 'status' => 'sebagian', 'kondisi' => 'Sebagian rumah tangga belum tersambung', 'energi' => 'Potensi mikrohidro', 'mineral' => 'Potensi material galian C'],
            ['desa' => 'Desa Melonguane', 'koordinat' => '4.0035, 126.6781', 'jumlah_penduduk' => 2120, 'status' => 'berlistrik', 'kondisi' => 'Pasokan listrik cukup stabil', 'energi' => 'Potensi tenaga surya', 'mineral' => 'Potensi pasir pantai'],
            ['desa' => 'Desa Beo', 'koordinat' => '4.1604, 126.7521', 'jumlah_penduduk' => 980, 'status' => 'belum_berlistrik', 'kondisi' => 'Belum ada jaringan permanen', 'energi' => 'Potensi angin pesisir', 'mineral' => 'Potensi batu gunung'],
            ['desa' => 'Desa Balirangen', 'koordinat' => '2.7479, 125.3795', 'jumlah_penduduk' => 1475, 'status' => 'berlistrik', 'kondisi' => 'Jaringan listrik menjangkau seluruh rumah', 'energi' => 'Potensi panas bumi', 'mineral' => 'Potensi batu andesit'],
            ['desa' => 'Desa Lirung', 'koordinat' => '2.7552, 125.3419', 'jumlah_penduduk' => 1090, 'status' => 'sebagian', 'kondisi' => 'Distribusi listrik belum merata', 'energi' => 'Potensi surya dan angin', 'mineral' => 'Potensi pasir dan kerikil'],
        ];

        foreach ($dataWilayahData as $data) {
            $desa = $desas[$data['desa']] ?? null;

            if (! $desa) {
                continue;
            }

            DataWilayah::firstOrCreate(
                ['desa_id' => $desa->id],
                [
                    'koordinat' => $data['koordinat'],
                    'jumlah_penduduk' => $data['jumlah_penduduk'],
                    'status_berlistrik' => $data['status'],
                    'kondisi_ketenagalistrikan' => $data['kondisi'],
                    'potensi_energi' => $data['energi'],
                    'potensi_sumber_daya_mineral' => $data['mineral'],
                ]
            );
        }

        $usahaData = [
            ['nama_pelaku_usaha' => 'PT Sangihe Energi Mandiri', 'jenis_usaha' => 'Ketenagalistrikan', 'lokasi' => 'Manganitu, Sangihe', 'status' => 'aktif'],
            ['nama_pelaku_usaha' => 'CV Talaud Mineral Jaya', 'jenis_usaha' => 'Pertambangan', 'lokasi' => 'Melonguane, Talaud', 'status' => 'aktif'],
            ['nama_pelaku_usaha' => 'PT Sitaro Surya Lestari', 'jenis_usaha' => 'Energi Terbarukan', 'lokasi' => 'Siau Barat, Sitaro', 'status' => 'izin_habis'],
        ];

        foreach ($usahaData as $data) {
            UsahaEsdm::firstOrCreate(
                ['nama_pelaku_usaha' => $data['nama_pelaku_usaha']],
                [
                    'nomor_identitas' => 'NIB-' . rand(100000, 999999),
                    'nomor_perizinan' => 'IZIN-' . rand(1000, 9999),
                    'jenis_usaha' => $data['jenis_usaha'],
                    'komoditas' => 'Komoditas utama',
                    'lokasi' => $data['lokasi'],
                    'koordinat' => '1.0000, 124.0000',
                    'status' => $data['status'],
                    'produksi' => 1200,
                    'penjualan' => 950,
                ]
            );
        }

        $mineralData = [
            ['lokasi' => 'Kecamatan Manganitu, Sangihe', 'jenis_komoditas' => 'Pasir Besi', 'pemegang_izin' => 'PT Sangihe Mineral'],
            ['lokasi' => 'Melonguane, Talaud', 'jenis_komoditas' => 'Batu Andesit', 'pemegang_izin' => 'CV Talaud Batu Prima'],
            ['lokasi' => 'Siau Barat, Sitaro', 'jenis_komoditas' => 'Batu Kapur', 'pemegang_izin' => 'PT Sitaro Quarry'],
        ];

        foreach ($mineralData as $data) {
            Mineral::firstOrCreate(
                ['lokasi' => $data['lokasi'], 'jenis_komoditas' => $data['jenis_komoditas']],
                [
                    'pemegang_izin' => $data['pemegang_izin'],
                    'luas' => 15.5,
                    'produksi' => 320.75,
                    'hasil_pemantauan' => 'Kegiatan berjalan sesuai ketentuan pengawasan.',
                    'tindak_lanjut' => 'Monitoring rutin setiap triwulan.',
                ]
            );
        }

        $energiData = [
            ['desa' => 'Desa Taloarane, Sangihe', 'sumber_energi' => 'PLTS Komunal'],
            ['desa' => 'Desa Melonguane, Talaud', 'sumber_energi' => 'PLTD'],
            ['desa' => 'Desa Balirangen, Sitaro', 'sumber_energi' => 'Mikrohidro'],
        ];

        foreach ($energiData as $data) {
            Energi::firstOrCreate(
                ['desa' => $data['desa'], 'sumber_energi' => $data['sumber_energi']],
                [
                    'kapasitas' => '250 kW',
                    'jaringan' => 'TM/TR',
                    'potensi_ebt' => 'Potensi energi terbarukan cukup besar.',
                    'kondisi_infrastruktur' => 'Infrastruktur dalam kondisi baik.',
                    'permasalahan' => 'Perlu penguatan distribusi pada jam beban puncak.',
                ]
            );
        }

        $pengawasanData = [
            ['tanggal' => '2026-07-20', 'petugas' => 'Tim Pengawas Wilayah IV', 'objek' => 'Tambang Pasir Besi', 'lokasi' => 'Manganitu, Sangihe', 'status' => 'selesai'],
            ['tanggal' => '2026-07-21', 'petugas' => 'Tim Pengawas Wilayah IV', 'objek' => 'PLTD Melonguane', 'lokasi' => 'Melonguane, Talaud', 'status' => 'dalam_proses'],
            ['tanggal' => '2026-07-22', 'petugas' => 'Tim Pengawas Wilayah IV', 'objek' => 'PLTS Komunal', 'lokasi' => 'Siau Barat, Sitaro', 'status' => 'selesai'],
        ];

        foreach ($pengawasanData as $data) {
            Pengawasan::firstOrCreate(
                ['tanggal' => $data['tanggal'], 'objek' => $data['objek']],
                [
                    'petugas' => $data['petugas'],
                    'lokasi' => $data['lokasi'],
                    'hasil' => 'Pemeriksaan lapangan telah dilakukan.',
                    'temuan' => 'Tidak ada temuan berat.',
                    'rekomendasi' => 'Lanjutkan pemantauan berkala.',
                    'tindak_lanjut' => 'Dokumentasi dan tindak lanjut dicatat pada sistem.',
                    'status' => $data['status'],
                ]
            );
        }

        $padData = [
            ['jenis_kegiatan' => 'Pajak Galian C', 'lokasi' => 'Sangihe'],
            ['jenis_kegiatan' => 'Retribusi Perizinan', 'lokasi' => 'Talaud'],
            ['jenis_kegiatan' => 'Pemanfaatan Material Lokal', 'lokasi' => 'Sitaro'],
        ];

        foreach ($padData as $data) {
            PotensiPad::firstOrCreate(
                ['jenis_kegiatan' => $data['jenis_kegiatan'], 'lokasi' => $data['lokasi']],
                [
                    'komoditas' => 'Komoditas lokal',
                    'volume' => 15000,
                    'satuan' => 'm3',
                    'periode' => 'Triwulan III 2026',
                    'nilai_produksi' => 125000000,
                    'pelaku_usaha' => 'Pelaku Usaha Demo',
                    'estimasi_penerimaan' => 35000000,
                ]
            );
        }
    }
}
