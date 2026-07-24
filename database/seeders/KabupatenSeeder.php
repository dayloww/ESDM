<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatens = [
            'Kabupaten Kepulauan Sangihe',
            'Kabupaten Kepulauan Talaud',
            'Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)'
        ];

        foreach ($kabupatens as $kab) {
            Kabupaten::firstOrCreate(['nama' => $kab]);
        }
    }
}
