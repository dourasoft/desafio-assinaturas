<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Register;
use App\Models\Subscription;
use Database\Seeders\RegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /**
     * A basic feature test example.
     */
    public function test_root_route_returns_404()
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }

    /**
     * Testa se o acesso à rota /api retorna um status 404.
     *
     * @return void
     */
    public function test_accessing_api_returns_404()
    {
        $response = $this->get('/api');

        $response->assertStatus(404);
    }

    /**
     * Testa se o acesso à rota /api/v1 retorna um status 404.
     *
     * @return void
     */
    public function test_accessing_api_v1_returns_404()
    {
        $response = $this->get('/api/v1');

        $response->assertStatus(404);
    }

    /**
     * Testa se a resposta de erro possui a estrutura correta.
     *
     * @return void
     */
    public function test_error_response_structure()
    {
        $response = $this->get('/rota-inexistente');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'code'
            ]);
    }


    public function test_seed_10_registers()
    {
        $this->seed(RegisterSeeder::class);
        $this->assertDatabaseCount('registers', 10);
    }

    public function test_get_register_by_id()
    {
        $subscription = Subscription::factory()->forRegister()->create();
        $invoice = Invoice::factory()->create([
            'register_id' => $subscription->register->id,
            'subscription_id' => $subscription->id,
            'description' => 'Invoice for ' . $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value,
        ]);

        // Faça a requisição para a rota
        $response = $this->get("api/v1/registers/{$subscription->register_id}");

        // Verifique se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifique se os dados retornados correspondem aos dados esperados do registro
        $this->assertDatabaseHas('registers', $subscription->register->only(['code', 'name', 'email', 'phone']));
        $this->assertDatabaseHas('subscriptions', $subscription->only(['register_id', 'description', 'due_date', 'value']));
        $this->assertDatabaseHas('invoices', $subscription->invoice->only(['register_id', 'subscription_id', 'description', 'due_date', 'value']));
    }

    public function test_register_is_destroyed()
    {

        $registerData =
            [
                'code' => fake()->ean8(),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber()
            ];
        $register = Register::create(
            $registerData
        );

        $this->delete("api/v1/registers/$register->id")
            ->assertStatus(200);
        $this->assertSoftDeleted($register);
    }

    public function test_update_register()
    {
        // Crie um registro para atualizar
        $register = Register::factory()->create();

        // Defina os dados para atualização
        $updatedData = [
            'code' => fake()->ean8(),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber()
        ];

        // Envie uma solicitação PATCH para a rota de atualização
        $response = $this->put("/api/v1/registers/{$register->id}", $updatedData);

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifique se o registro foi atualizado no banco de dados
        $this->assertDatabaseHas('registers', $updatedData);
    }

    public function test_create_register()
    {
        // Crie um registro para atualizar
        $register = Register::factory()->create();

        // Defina os dados para atualização
        $data = [
            'code' => fake()->ean8(),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber()
        ];

        // Envie uma solicitação PATCH para a rota de atualização
        $response = $this->post("/api/v1/registers", $data);

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(201);

        // Verifique se o registro foi atualizado no banco de dados
        $this->assertDatabaseHas('registers', $data);
    }
}
