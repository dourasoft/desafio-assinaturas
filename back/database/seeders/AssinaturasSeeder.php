<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assinaturas;

class AssinaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Assinaturas::count() === 0) {
            Assinaturas::factory()->count(10)->create();
        }
    }
}
