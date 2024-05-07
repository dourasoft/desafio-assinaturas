<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Registration;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class RegistrationsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $registrationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->registrationService = $this->mock(RegistrationService::class);
    }

    #[Test]
    public function it_can_get_all_registrations()
    {
        Registration::factory()->count(3)->create();

        $this->registrationService->shouldReceive('getAll')->once()->andReturn(['data' => [], 'success' => true]);

        $response = $this->get('/api/registrations');

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_create_a_registration()
    {
        $requestData = ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '88997866761'];

        $this->registrationService->shouldReceive('create')->once()->with($requestData)->andReturn(['success' => true]);

        $response = $this->post('/api/registrations', $requestData);

        $response->assertStatus(201);
    }

    #[Test]
    public function it_can_show_a_registration()
    {
        $registration = Registration::factory()->create();

        $this->registrationService->shouldReceive('getById')->once()->with($registration->id)->andReturn(['data' => $registration, 'success' => true]);

        $response = $this->get("/api/registrations/{$registration->id}");

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_update_a_registration()
    {
        $registration = Registration::factory()->create();
        $requestData = ['name' => 'Updated Name'];

        $this->registrationService->shouldReceive('getById')->once()->with($registration->id)->andReturn(['data' => $registration, 'success' => true]);
        $this->registrationService->shouldReceive('update')->once()->with($registration->id, $requestData)->andReturn(['success' => true]);

        $response = $this->put("/api/registrations/{$registration->id}", $requestData);

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_delete_a_registration()
    {
        $registration = Registration::factory()->create();

        $this->registrationService->shouldReceive('getById')->once()->with($registration->id)->andReturn(['data' => $registration, 'success' => true]);
        $this->registrationService->shouldReceive('delete')->once()->with($registration->id)->andReturn(['success' => true]);

        $response = $this->delete("/api/registrations/{$registration->id}");

        $response->assertStatus(200);
    }
}
