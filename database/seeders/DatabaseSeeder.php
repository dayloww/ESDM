<?php

namespace Database\Seeders;

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
}
