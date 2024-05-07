<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Registration;
use Tests\TestCase;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class SubscriptionsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $subscriptionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->subscriptionService = $this->mock(SubscriptionService::class);
    }

    #[Test]
    public function it_can_get_all_subscriptions()
    {
        Subscription::factory()->count(3)->create();

        $this->subscriptionService->shouldReceive('getAll')->once()->andReturn(['data' => [], 'success' => true]);

        $response = $this->get('/api/subscriptions');

        $response->assertStatus(200);
    }

    #[Test]
    public function test_it_can_create_a_subscription()
    {
        $registration = Registration::factory()->create();

        $requestData = [
            'registration_id' => $registration->id,
            'description' => 'Example Subscription',
            'value' => 100,
            'due_day' => 11,
        ];

        $this->subscriptionService->shouldReceive('create')->once()->with($requestData)->andReturn(['success' => true]);

        $response = $this->post('/api/subscriptions', $requestData);

        $response->assertStatus(201);
    }

    #[Test]
    public function it_can_show_a_subscription()
    {
        $subscription = Subscription::factory()->create();

        $this->subscriptionService->shouldReceive('getById')->once()->with($subscription->id)->andReturn(['data' => $subscription, 'success' => true]);

        $response = $this->get("/api/subscriptions/{$subscription->id}");

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_get_subscriptions_by_registration_id()
    {
        $registration = Registration::factory()->create();

        $subscriptions = Subscription::factory()->count(3)->create(['registration_id' => $registration->id]);

        $this->subscriptionService
            ->shouldReceive('getByRegistrationId')
            ->once()
            ->with($registration->id)
            ->andReturn(['data' => $subscriptions, 'success' => true]);

        $response = $this->get("/api/subscriptions/registration/{$registration->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    #[Test]
    public function it_can_update_a_subscription()
    {
        $subscription = Subscription::factory()->create();
        $requestData = ['description' => 'Updated Subscription', 'value' => 200];

        $this->subscriptionService->shouldReceive('getById')->once()->with($subscription->id)->andReturn(['data' => $subscription, 'success' => true]);
        $this->subscriptionService->shouldReceive('update')->once()->with($subscription->id, $requestData)->andReturn(['success' => true]);

        $response = $this->put("/api/subscriptions/{$subscription->id}", $requestData);

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_delete_a_subscription()
    {
        $subscription = Subscription::factory()->create();

        $this->subscriptionService->shouldReceive('getById')->once()->with($subscription->id)->andReturn(['data' => $subscription, 'success' => true]);
        $this->subscriptionService->shouldReceive('delete')->once()->with($subscription->id)->andReturn(['success' => true]);

        $response = $this->delete("/api/subscriptions/{$subscription->id}");

        $response->assertStatus(200);
    }

    #[Test]
    public function it_will_fail()
    {
        $this->assertTrue(false);
    }
}
