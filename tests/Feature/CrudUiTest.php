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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class CrudUiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $operator;

    private Kabupaten $kabupaten;

    private Kecamatan $kecamatan;

    private Desa $desa;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['nama_role' => 'Admin']);
        Role::firstOrCreate(['nama_role' => 'Operator']);

        $this->admin = $this->createUser('Admin');
        $this->operator = $this->createUser('Operator');

        $this->kabupaten = Kabupaten::create(['nama' => 'Kabupaten Prasyarat']);
        $this->kecamatan = Kecamatan::create([
            'kabupaten_id' => $this->kabupaten->id,
            'nama' => 'Kecamatan Prasyarat',
        ]);
        $this->desa = Desa::create([
            'kecamatan_id' => $this->kecamatan->id,
            'nama' => 'Desa Prasyarat',
        ]);
    }

    public function test_index_views_use_shared_filter_and_create_components_for_all_modules(): void
    {
        foreach ([$this->admin, $this->operator] as $user) {
            foreach ($this->modules() as $module) {
                $response = $this->actingAs($user)->get(route("{$module}.index"));

                $response->assertOk()
                    ->assertSee('<form method="GET"', false)
                    ->assertSee('filter-', false)
                    ->assertSee('Terapkan')
                    ->assertSee('Reset filter', false)
                    ->assertSee('create-button', false)
                    ->assertSee('searching: false', false)
                    ->assertDontSee('onchange="this.form.submit()"', false)
                    ->assertDontSee('btn-xs py-0 px-2', false);
            }
        }
    }

    public function test_filter_values_persist_and_reset_uses_index_route(): void
    {
        $this->actingAs($this->admin)
            ->get(route('kabupaten.index', ['nama' => 'Sangihe']))
            ->assertOk()
            ->assertSee('Sangihe')
            ->assertSee('Reset filter', false)
            ->assertSee(route('kabupaten.index'), false);

        $this->actingAs($this->admin)
            ->get(route('desa.index', ['kecamatan_id' => $this->kecamatan->id]))
            ->assertOk()
            ->assertSee('value="'.$this->kecamatan->id.'" selected', false);
    }

    public function test_empty_state_distinguishes_no_data_from_no_filter_results(): void
    {
        $this->actingAs($this->admin)
            ->get(route('pad.index'))
            ->assertOk()
            ->assertSee('Belum ada potensi PAD yang tersimpan.', false)
            ->assertSee(route('pad.create'), false);

        foreach ($this->modules() as $module) {
            $this->actingAs($this->admin)
                ->get(route("{$module}.index", $this->emptyFilter($module)))
                ->assertOk()
                ->assertSee('yang cocok dengan filter saat ini.', false)
                ->assertSee('Hapus filter', false)
                ->assertDontSee('Belum ada', false);
        }
    }

    public function test_form_views_use_shared_error_summary_and_action_partials(): void
    {
        foreach ($this->modules() as $module) {
            $this->actingAs($this->admin)
                ->get(route("{$module}.create"))
                ->assertOk()
                ->assertSee('form-actions', false)
                ->assertSee('Simpan', false)
                ->assertSee('Batal', false);
        }

        $errors = new ViewErrorBag;
        $errors->put('default', new MessageBag(['nama' => ['Kolom ini wajib diisi.']]));

        $this->actingAs($this->admin)
            ->blade('@include("partials.form-errors")', ['errors' => $errors])
            ->assertSee('id="form-error-summary"', false)
            ->assertSee('role="alert"', false)
            ->assertSee('aria-live="polite"', false)
            ->assertSee('Kolom ini wajib diisi.');

        $pad = PotensiPad::create($this->payload('pad', 'Edit'));

        $this->actingAs($this->admin)
            ->get(route('pad.edit', $pad))
            ->assertOk()
            ->assertSee('form-actions', false)
            ->assertSee('Perbarui', false)
            ->assertSee("querySelector('.is-invalid')", false);
    }

    public function test_admin_can_create_in_all_modules_and_update_delete_bound_modules(): void
    {
        foreach ($this->modules() as $module) {
            $marker = 'Admin '.ucfirst($module);
            $record = $this->createRecord($module, $marker);
            $updated = $this->updatedPayload($module, $this->payload($module, $marker));

            $this->actingAs($this->admin)
                ->get(route("{$module}.index"))
                ->assertOk()
                ->assertSee('data-delete-label=', false)
                ->assertSee('Hapus ', false);

            if ($module === 'ketenagalistrikan') {
                continue;
            }

            $this->actingAs($this->admin)
                ->put(route("{$module}.update", $record), $updated)
                ->assertRedirect(route("{$module}.index"));

            $this->assertUpdated($module, $record, $updated);

            $this->actingAs($this->admin)
                ->delete(route("{$module}.destroy", $record))
                ->assertRedirect(route("{$module}.index"));

            $this->assertDeleted($record);
        }
    }

    public function test_operator_can_create_in_all_modules_and_update_delete_bound_modules(): void
    {
        foreach ($this->modules() as $module) {
            $marker = 'Operator '.ucfirst($module);
            $record = $this->createRecord($module, $marker, $this->operator);
            $updated = $this->updatedPayload($module, $this->payload($module, $marker));

            $this->actingAs($this->operator)
                ->get(route("{$module}.index"))
                ->assertOk()
                ->assertDontSee('data-delete-label=', false)
                ->assertSee('aria-label="Edit ', false);

            if ($module === 'ketenagalistrikan') {
                continue;
            }

            $this->actingAs($this->operator)
                ->put(route("{$module}.update", $record), $updated)
                ->assertRedirect(route("{$module}.index"));

            $this->assertUpdated($module, $record, $updated);

            $this->actingAs($this->operator)
                ->delete(route("{$module}.destroy", $record))
                ->assertRedirect(route('dashboard'))
                ->assertSessionHas('error', 'Hanya Admin yang dapat menghapus data.');

            $this->assertDatabaseHas($record->getTable(), ['id' => $record->id]);
        }
    }

    private function modules(): array
    {
        return [
            'kabupaten',
            'kecamatan',
            'desa',
            'wilayah',
            'usaha',
            'mineral',
            'energi',
            'ketenagalistrikan',
            'pengawasan',
            'pad',
        ];
    }

    private function createUser(string $roleName): User
    {
        return User::create([
            'name' => "User {$roleName}",
            'email' => strtolower($roleName).'-'.Str::lower(Str::random(8)).'@example.test',
            'password' => Hash::make('password'),
            'role_id' => Role::where('nama_role', $roleName)->firstOrFail()->id,
            'status' => 'aktif',
        ]);
    }

    private function payload(string $module, string $marker): array
    {
        return match ($module) {
            'kabupaten' => ['nama' => "Kab {$marker}"],
            'kecamatan' => [
                'kabupaten_id' => $this->kabupaten->id,
                'nama' => "Kec {$marker}",
            ],
            'desa' => [
                'kecamatan_id' => $this->kecamatan->id,
                'nama' => "Desa {$marker}",
            ],
            'wilayah' => [
                'desa_id' => $this->desa->id,
                'status_berlistrik' => 'berlistrik',
            ],
            'usaha' => [
                'nama_pelaku_usaha' => "PT {$marker}",
                'jenis_usaha' => 'Pertambangan',
                'lokasi' => 'Sangihe',
                'status' => 'aktif',
            ],
            'mineral' => [
                'lokasi' => "Lokasi {$marker}",
                'jenis_komoditas' => 'Pasir',
                'pemegang_izin' => 'PT Contoh',
            ],
            'energi' => [
                'jenis_usaha' => 'Lainnya',
                'desa' => "Desa {$marker}",
                'sumber_energi' => 'Sumber Contoh',
            ],
            'ketenagalistrikan' => [
                'jenis_usaha' => 'UPTL',
                'desa' => "Desa {$marker}",
                'nama_badan_usaha' => "PLN {$marker}",
                'sumber_energi' => 'Listrik PLN',
            ],
            'pengawasan' => [
                'tanggal' => '2026-11-21',
                'petugas' => "Petugas {$marker}",
                'objek' => "Objek {$marker}",
                'lokasi' => 'Sangihe',
                'status' => 'selesai',
            ],
            'pad' => [
                'jenis_kegiatan' => "Kegiatan {$marker}",
                'lokasi' => 'Sangihe',
            ],
        };
    }

    private function findColumn(string $module): string
    {
        return match ($module) {
            'kabupaten', 'kecamatan', 'desa' => 'nama',
            'wilayah' => 'desa_id',
            'usaha' => 'nama_pelaku_usaha',
            'mineral' => 'lokasi',
            'energi' => 'desa',
            'ketenagalistrikan' => 'nama_badan_usaha',
            'pengawasan' => 'petugas',
            'pad' => 'jenis_kegiatan',
        };
    }

    private function modelClass(string $module): string
    {
        return match ($module) {
            'kabupaten' => Kabupaten::class,
            'kecamatan' => Kecamatan::class,
            'desa' => Desa::class,
            'wilayah' => DataWilayah::class,
            'usaha' => UsahaEsdm::class,
            'mineral' => Mineral::class,
            'energi', 'ketenagalistrikan' => Energi::class,
            'pengawasan' => Pengawasan::class,
            'pad' => PotensiPad::class,
        };
    }

    private function emptyFilter(string $module): array
    {
        return match ($module) {
            'kabupaten' => ['nama' => '__tidak_ada__'],
            'kecamatan' => ['kabupaten_id' => 999999],
            'desa' => ['kecamatan_id' => 999999],
            'wilayah' => ['kabupaten_id' => 999999],
            'usaha' => ['status' => '__tidak_ada__'],
            'mineral' => ['jenis_komoditas' => '__tidak_ada__'],
            'energi' => ['sumber_energi' => '__tidak_ada__'],
            'ketenagalistrikan' => ['status' => '__tidak_ada__'],
            'pengawasan' => ['status' => '__tidak_ada__'],
            'pad' => ['jenis_kegiatan' => '__tidak_ada__'],
        };
    }

    private function createRecord(string $module, string $marker, ?User $user = null): Model
    {
        $payload = $this->payload($module, $marker);

        $this->actingAs($user ?? $this->admin)
            ->post(route("{$module}.store"), $payload)
            ->assertRedirect(route("{$module}.index"));

        $modelClass = $this->modelClass($module);
        $column = $this->findColumn($module);

        return $modelClass::where($column, $payload[$column])->firstOrFail();
    }

    private function updatedPayload(string $module, array $payload): array
    {
        if ($module === 'wilayah') {
            return array_merge($payload, ['status_berlistrik' => 'sebagian']);
        }

        $column = $this->findColumn($module);
        $payload[$column] .= ' ubah';

        return $payload;
    }

    private function assertUpdated(string $module, Model $record, array $payload): void
    {
        $column = $module === 'wilayah' ? 'status_berlistrik' : $this->findColumn($module);
        $value = $module === 'wilayah' ? 'sebagian' : $payload[$column];

        $this->assertDatabaseHas($record->getTable(), [
            'id' => $record->id,
            $column => $value,
        ]);
    }

    private function assertDeleted(Model $record): void
    {
        if (in_array($record->getTable(), ['usaha_esdm', 'mineral', 'energi', 'pengawasan', 'potensi_pad'], true)) {
            $this->assertSoftDeleted($record->getTable(), ['id' => $record->id]);

            return;
        }

        $this->assertDatabaseMissing($record->getTable(), ['id' => $record->id]);
    }
}
