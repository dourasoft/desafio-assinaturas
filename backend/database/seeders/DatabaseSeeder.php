<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Registration;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Registration::factory()
            ->has(
                Subscription::factory()
                    ->count(1)
                    ->has(Invoice::factory()->count(1))
            )
            ->count(1000)
            ->create();
    }
}
