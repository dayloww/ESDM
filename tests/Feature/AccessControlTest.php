<?php

namespace Tests\Feature;

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\DataAccess;
use App\Models\PotensiPad;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route as RouteDefinition;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['nama_role' => 'Admin']);
        Role::firstOrCreate(['nama_role' => 'Operator']);
        Role::firstOrCreate(['nama_role' => 'Auditor']);
    }

    public function test_admin_can_access_data_modules_and_user_management(): void
    {
        $admin = $this->createUser('Admin');

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk();

        foreach ($this->dataModules() as $module) {
            $this->actingAs($admin)
                ->get(route("{$module}.index"))
                ->assertOk();

            $this->actingAs($admin)
                ->get(route("{$module}.create"))
                ->assertOk();
        }

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('users.create'))
            ->assertOk();
    }

    public function test_admin_can_delete_data_and_manage_users(): void
    {
        $admin = $this->createUser('Admin');
        $pad = PotensiPad::create($this->padPayload());
        $otherUser = $this->createUser('Operator');

        $this->actingAs($admin)
            ->delete(route('pad.destroy', $pad))
            ->assertRedirect(route('pad.index'));

        $this->assertSoftDeleted('potensi_pad', ['id' => $pad->id]);

        $this->actingAs($admin)
            ->get(route('users.edit', $otherUser))
            ->assertOk();

        $this->actingAs($admin)
            ->delete(route('users.destroy', $otherUser))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $otherUser->id]);
    }

    public function test_operator_can_access_index_create_store_edit_and_update(): void
    {
        $operator = $this->createUser('Operator');

        foreach ($this->dataModules() as $module) {
            $this->actingAs($operator)
                ->get(route("{$module}.index"))
                ->assertOk();

            $this->actingAs($operator)
                ->get(route("{$module}.create"))
                ->assertOk();
        }

        $this->actingAs($operator)
            ->post(route('pad.store'), $this->padPayload())
            ->assertRedirect(route('pad.index'));

        $pad = PotensiPad::where('jenis_kegiatan', 'Pertambangan')->firstOrFail();

        $this->actingAs($operator)
            ->get(route('pad.edit', $pad))
            ->assertOk();

        $this->actingAs($operator)
            ->put(
                route('pad.update', $pad),
                $this->padPayload(['jenis_kegiatan' => 'Pertambangan diperbarui'])
            )
            ->assertRedirect(route('pad.index'));

        $this->assertDatabaseHas('potensi_pad', [
            'id' => $pad->id,
            'jenis_kegiatan' => 'Pertambangan diperbarui',
        ]);
    }

    public function test_operator_is_denied_on_destroy_route(): void
    {
        $operator = $this->createUser('Operator');
        $pad = PotensiPad::create($this->padPayload());

        $this->actingAs($operator)
            ->delete(route('pad.destroy', $pad))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error', 'Hanya Admin yang dapat menghapus data.');

        $this->assertDatabaseHas('potensi_pad', [
            'id' => $pad->id,
            'deleted_at' => null,
        ]);
    }

    public function test_operator_is_denied_on_user_management(): void
    {
        $operator = $this->createUser('Operator');

        foreach (['users.index', 'users.create'] as $routeName) {
            $this->actingAs($operator)
                ->get(route($routeName))
                ->assertRedirect(route('dashboard'))
                ->assertSessionHas('error', 'Akses ini hanya tersedia untuk Admin.');
        }
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('pad.index'))
            ->assertRedirect(route('login'));

        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    public function test_unknown_role_has_no_automatic_access(): void
    {
        $unknown = $this->createUser('Auditor');

        $this->actingAs($unknown)
            ->get(route('pad.index'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error', 'Akses modul data tidak tersedia untuk role Anda.');

        $this->actingAs($unknown)
            ->get(route('users.index'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_data_routes_use_data_access_middleware(): void
    {
        foreach ($this->dataRouteNames() as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route, "Route {$routeName} tidak ditemukan.");
            $this->assertTrue(
                $this->hasMiddleware($route, 'data.access', DataAccess::class),
                "Route {$routeName} tidak menggunakan middleware data.access."
            );
        }
    }

    public function test_user_routes_use_admin_middleware(): void
    {
        $routeNames = [
            'users.index',
            'users.create',
            'users.store',
            'users.edit',
            'users.update',
            'users.destroy',
        ];

        foreach ($routeNames as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route, "Route {$routeName} tidak ditemukan.");
            $this->assertTrue(
                $this->hasMiddleware($route, 'admin', AdminOnly::class),
                "Route {$routeName} tidak menggunakan middleware admin."
            );
        }
    }

    private function dataModules(): array
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

    private function dataRouteNames(): array
    {
        $routeNames = [];

        foreach ($this->dataModules() as $module) {
            foreach (['index', 'create', 'store', 'edit', 'update', 'destroy'] as $action) {
                $routeNames[] = "{$module}.{$action}";
            }
        }

        $routeNames[] = 'energi.show';
        $routeNames[] = 'ketenagalistrikan.show';

        return $routeNames;
    }

    private function hasMiddleware(RouteDefinition $route, string $alias, string $class): bool
    {
        $middleware = $route->gatherMiddleware();

        return in_array($alias, $middleware, true) || in_array($class, $middleware, true);
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

    private function padPayload(array $overrides = []): array
    {
        return array_merge([
            'jenis_kegiatan' => 'Pertambangan',
            'komoditas' => 'Batu bara',
            'volume' => 10,
            'satuan' => 'ton',
            'periode' => '2026',
            'nilai_produksi' => 1000000,
            'pelaku_usaha' => 'PT Contoh',
            'lokasi' => 'Sangihe',
            'estimasi_penerimaan' => 500000,
        ], $overrides);
    }
}
