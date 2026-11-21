<?php

namespace Tests\Feature;

use App\Models\DataWilayah;
use App\Models\Desa;
use App\Models\Energi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Mineral;
use App\Models\Pengawasan;
use App\Models\PotensiPad;
use App\Models\Role;
use App\Models\UsahaEsdm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['nama_role' => 'Admin']);
        Role::firstOrCreate(['nama_role' => 'Operator']);
    }

    public function test_dashboard_menampilkan_enam_kpi_dari_database(): void
    {
        $this->seedDashboardData();
        $admin = $this->createUser('Admin');

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Ringkasan Data Wilayah IV')
            ->assertSee('Potensi PAD')
            ->assertSee('Lihat Analisis')
            ->assertDontSee('Belum ada data grafik wilayah.', false)
            ->assertDontSee('data-count-to', false)
            ->assertDontSee('data-reveal', false)
            ->assertDontSee('>Ringkasan Data</h2>', false)
            ->assertSee('kpi-grid', false)
            ->assertSee('kpi-card', false)
            ->assertSee('kpi-card__icon', false)
            ->assertSee('bi-map', false)
            ->assertSee('bi-wallet2', false)
            ->assertDontSee('kpi-item', false)
            ->assertDontSee('kpi-strip', false)
            ->assertDontSee('Total tercatat')
            ->assertDontSee('stat-card', false)
            ->assertDontSee('stat-trend', false)
            ->assertDontSee('Baru bulan ini')
            ->assertViewHas('stats', fn (array $stats): bool => $stats === [
                'wilayah' => 2,
                'usaha' => 3,
                'mineral' => 4,
                'energi' => 5,
                'pengawasan' => 6,
                'pad' => 7,
            ])
            ->assertViewHas('monthlyGrowth', fn (array $growth): bool => $growth['pad'] === 7)
            ->assertViewHas('hasRegionalData', true)
            ->assertViewHas('chartData', function (array $data): bool {
                return ! array_key_exists('pad', $data)
                    && count($data['labels']) === 3
                    && $data['usaha'] === [3, 0, 0]
                    && $data['mineral'] === [4, 0, 0]
                    && $data['energi'] === [5, 0, 0]
                    && $data['pengawasan'] === [6, 0, 0];
            });

        $this->actingAs($admin)
            ->get(route('dashboard.analisis'))
            ->assertOk()
            ->assertDontSee('data-reveal', false)
            ->assertViewHas('compositionData', [
                'labels' => ['Data Wilayah', 'Usaha ESDM', 'Mineral', 'Energi', 'Pengawasan', 'Potensi PAD'],
                'values' => [2, 3, 4, 5, 6, 7],
                'colors' => ['#2563EB', '#0891B2', '#1E40AF', '#16A34A', '#64748B', '#475569'],
            ]);
    }

    public function test_dashboard_menampilkan_empty_state_tanpa_data(): void
    {
        $admin = $this->createUser('Admin');

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Belum ada data grafik wilayah.')
            ->assertSee('Belum ada aktivitas terbaru.')
            ->assertDontSee('<canvas id="chartKabupaten"', false)
            ->assertViewHas('stats', fn (array $stats): bool => array_sum($stats) === 0)
            ->assertViewHas('hasRegionalData', false)
            ->assertViewHas('recentActivities', fn ($activities): bool => $activities->isEmpty());
    }

    public function test_admin_dan_operator_dapat_melihat_dashboard(): void
    {
        foreach (['Admin', 'Operator'] as $roleName) {
            $this->actingAs($this->createUser($roleName))
                ->get(route('dashboard'))
                ->assertOk()
                ->assertSee('Ringkasan Data Wilayah IV')
                ->assertSee('Lihat Analisis');
        }
    }

    private function seedDashboardData(): void
    {
        $kabupaten = Kabupaten::create(['nama' => 'Kab. Kepulauan Sangihe']);
        $kecamatan = Kecamatan::create([
            'kabupaten_id' => $kabupaten->id,
            'nama' => 'Kecamatan Tahuna',
        ]);
        $desa = Desa::create([
            'kecamatan_id' => $kecamatan->id,
            'nama' => 'Desa Santiago',
        ]);

        DataWilayah::create(['desa_id' => $desa->id]);
        DataWilayah::create(['desa_id' => $desa->id]);

        for ($i = 1; $i <= 3; $i++) {
            UsahaEsdm::create([
                'nama_pelaku_usaha' => "Usaha {$i}",
                'jenis_usaha' => 'Perdagangan',
                'lokasi' => 'Sangihe',
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {
            Mineral::create([
                'lokasi' => 'Sangihe',
                'jenis_komoditas' => "Mineral {$i}",
                'pemegang_izin' => 'PT Contoh',
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Energi::create([
                'desa' => 'Sangihe',
                'sumber_energi' => "Energi {$i}",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            Pengawasan::create([
                'tanggal' => now()->toDateString(),
                'petugas' => 'Petugas',
                'objek' => "Objek {$i}",
                'lokasi' => 'Sangihe',
            ]);
        }

        for ($i = 1; $i <= 7; $i++) {
            PotensiPad::create([
                'jenis_kegiatan' => "Kegiatan {$i}",
                'lokasi' => 'Sangihe',
            ]);
        }

        $deletedPad = PotensiPad::create([
            'jenis_kegiatan' => 'Kegiatan terhapus',
            'lokasi' => 'Sangihe',
        ]);
        $deletedPad->delete();
    }

    private function createUser(string $roleName): User
    {
        $role = Role::firstOrCreate(['nama_role' => $roleName]);

        return User::create([
            'name' => "User {$roleName}",
            'email' => strtolower($roleName).'-'.Str::lower(Str::random(8)).'@example.test',
            'password' => Hash::make('password'),
            'role_id' => $role->id,
            'status' => 'aktif',
        ]);
    }
}
