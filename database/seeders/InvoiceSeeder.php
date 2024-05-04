<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Subscription::with('register')->doesntHave('invoice')->get() as $subscription) {
            Invoice::factory()->create([
                'register_id' => $subscription->register->id,
                'subscription_id' => $subscription->id,
                'description' => 'Invoice for ' . $subscription->description,
                'due_date' => $subscription->due_date,
                'value' => $subscription->value,
            ]);
        }
    }
}
