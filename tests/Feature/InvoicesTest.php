<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Register;
use App\Models\Subscription;
use Database\Seeders\InvoiceSeeder;
use Database\Seeders\SubscriptionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class InvoicesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function test_seed_10_invoices()
    {
        $this->seed(SubscriptionSeeder::class);
        $this->seed(InvoiceSeeder::class);
        $this->assertDatabaseCount('invoices', 10);
    }

    public function test_index_invoices()
    {

        $subscription = Subscription::factory()->forRegister()->create();
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();

        $response = $this->get("/api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}/invoices");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $invoice->id]);
    }

    public function test_store_invoice()
    {
        $subscription = Subscription::factory()->forRegister()->create();

        $data = [
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => 'Test Invoice',
            'due_date' => now()->addDays(10),
            'value' => 100.00,
        ];

        $response = $this->post("/api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}/invoices", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('invoices', $data);
    }

    public function test_show_invoice()
    {
        $subscription = Subscription::factory()->forRegister()->create();
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();

        $response = $this->get("/api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $invoice->id,
                    'register_id' => $subscription->register_id,
                    'subscription_id' => $subscription->id,
                    'description' => $subscription->description,
                    'due_date' => $subscription->due_date,
                    'value' => $subscription->value
                ]
            ]);
    }

    public function test_update_invoice()
    {
        $subscription = Subscription::factory()->forRegister()->create();
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();

        $data = [
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => 'Updated Invoice',
            'due_date' => $invoice->due_date,
            'value' => $invoice->value,
        ];

        $response = $this->put("/api/v1/registers/{$invoice->register_id}/subscriptions/{$invoice->register_id}/invoices/{$invoice->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', $data);
    }

    public function test_delete_invoice()
    {
        $subscription = Subscription::factory()->forRegister()->create();
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();


        $response = $this->delete("/api/v1/registers/{$invoice->register_id}/subscriptions/{$invoice->register_id}/invoices/{$invoice->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted($invoice);
    }
}
