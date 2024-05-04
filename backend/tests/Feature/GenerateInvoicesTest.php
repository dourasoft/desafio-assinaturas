<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class GenerateInvoicesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_invoices_for_subscriptions()
    {
        Subscription::factory()->create(['is_active' => true, 'due_day' => 5]);
        Subscription::factory()->create(['is_active' => false, 'due_day' => null]);

        $subscriptionService = $this->mock(SubscriptionService::class);
        $subscriptionService->shouldReceive('getToGenerateInvoices')->once()->andReturn([
            Subscription::where('is_active', true)->whereNotNull('due_day')->first(),
        ]);

        $this->artisan('command:generate-invoices');
    }
}
