<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Invoice;
use App\Models\Registration;
use App\Models\Subscription;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class InvoicesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $invoiceService;

    public function setUp(): void
    {
        parent::setUp();

        $this->invoiceService = $this->mock(InvoiceService::class);
    }

    #[Test]
    public function it_can_get_all_invoices()
    {
        Invoice::factory()->count(3)->create();

        $this->invoiceService->shouldReceive('getAll')->once()->andReturn(['data' => [], 'success' => true]);

        $response = $this->get('/api/invoices');

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_create_an_invoice()
    {
        $registration = Registration::factory()->create();
        $subscription = Subscription::factory()->create();

        $requestData = [
            'registration_id' => $registration->id,
            'subscription_id' => $subscription->id,
            'description' => 'Nova fatura',
            'due_date' => '2024-05-10',
        ];

        $this->invoiceService->shouldReceive('create')->once()->with($requestData)->andReturn(['success' => true]);

        $response = $this->post('/api/invoices', $requestData);

        $response->assertStatus(201);
    }

    #[Test]
    public function it_can_show_an_invoice()
    {
        $invoice = Invoice::factory()->create();

        $this->invoiceService->shouldReceive('getById')->once()->with($invoice->id)->andReturn(['data' => $invoice, 'success' => true]);

        $response = $this->get("/api/invoices/{$invoice->id}");

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_get_invoices_by_subscription_id()
    {
        $subscription = Subscription::factory()->create();

        $this->invoiceService->shouldReceive('getBySubscriptionId')->once()->with($subscription->id)->andReturn(['data' => [], 'success' => true]);

        $response = $this->get("/api/invoices/subscription/{$subscription->id}");

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_update_an_invoice()
    {
        $invoice = Invoice::factory()->create();
        $requestData = ['description' => 'Nova descrição'];

        $this->invoiceService->shouldReceive('getById')->once()->with($invoice->id)->andReturn(['data' => $invoice, 'success' => true]);
        $this->invoiceService->shouldReceive('update')->once()->with($invoice->id, $requestData)->andReturn(['success' => true]);

        $response = $this->put("/api/invoices/{$invoice->id}", $requestData);

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_delete_an_invoice()
    {
        $invoice = Invoice::factory()->create();

        $this->invoiceService->shouldReceive('getById')->once()->with($invoice->id)->andReturn(['data' => $invoice, 'success' => true]);
        $this->invoiceService->shouldReceive('delete')->once()->with($invoice->id)->andReturn(['success' => true]);

        $response = $this->delete("/api/invoices/{$invoice->id}");

        $response->assertStatus(200);
    }
}
