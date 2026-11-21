<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['nama_role' => 'Admin']);
        Role::firstOrCreate(['nama_role' => 'Operator']);
    }

    public function test_admin_layout_uses_phase_two_tokens_and_aria(): void
    {
        $admin = $this->createUser('Admin');

        $this->actingAs($admin)
            ->get(route('pad.index'))
            ->assertOk()
            ->assertSee('aria-controls="sidebar"', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('--sidebar-width:    240px', false)
            ->assertSee('--radius-panel:     14px', false)
            ->assertSee(':focus-visible', false)
            ->assertSee('prefers-reduced-motion: reduce', false)
            ->assertSee('Manajemen Pengguna')
            ->assertDontSee('linear-gradient', false)
            ->assertDontSee('translateY(-2px)', false)
            ->assertDontSee('var(--primary-dark)', false);
    }

    public function test_admin_layout_sidebar_toggle_has_persistent_accessible_state(): void
    {
        $admin = $this->createUser('Admin');

        $this->actingAs($admin)
            ->get(route('pad.index'))
            ->assertOk()
            ->assertSee('id="sidebarToggle"', false)
            ->assertSee('id="sidebarToggleIcon"', false)
            ->assertSee('aria-label="Tutup navigasi"', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('bi bi-chevron-left', false)
            ->assertSee('esdm-sidebar-collapsed', false)
            ->assertSee('--sidebar-duration: 200ms', false)
            ->assertSee('html.sidebar-collapsed #sidebar', false)
            ->assertSee('html.sidebar-collapsed #main-wrapper', false)
            ->assertSee('#sidebarOverlay.show', false)
            ->assertSee('window.syncSidebarControl', false)
            ->assertSee("event.key === 'Escape'", false);
    }

    public function test_operator_layout_hides_user_management_menu(): void
    {
        $operator = $this->createUser('Operator');

        $this->actingAs($operator)
            ->get(route('pad.index'))
            ->assertOk()
            ->assertDontSee('Manajemen Pengguna');
    }

    public function test_login_layout_uses_same_tokens_and_has_skip_link(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Lewati ke formulir login')
            ->assertSee('id="auth-content"', false)
            ->assertSee('--radius-panel: 14px', false)
            ->assertSee('prefers-reduced-motion: reduce', false)
            ->assertDontSee('linear-gradient', false)
            ->assertDontSee('translateY(-2px)', false);
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
