<?php

namespace Tests\Feature;

use App\Models\Register;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /**
     * Testa se o acesso à rota /api/v1/subscriptions retorna um status 404.
     *
     * @return void
     */
    public function test_accessing_api_v1_subscriptions_returns_404()
    {
        $response = $this->get('/api/v1/subscriptions');

        $response->assertStatus(404);
    }

    public function test_get_subscriptions_of_register()
    {
        // Crie um registro com assinaturas
        $register = Register::factory()->has(Subscription::factory()->count(3))->create();

        // Faça a requisição para a rota
        $response = $this->get("api/v1/registers/{$register->id}/subscriptions");

        // Verifique se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifique se a estrutura JSON da resposta está correta
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'register_id',
                    'description',
                    'due_date',
                    'value',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function test_create_subscription_for_register()
    {
        // Crie um registro para associar a assinatura
        $register = Register::factory()->create();

        // Defina os dados para criação da assinatura
        $data = [
            'register_id' => $register->id,
            'description' => 'Test Subscription',
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'value' => 50.00,
        ];

        // Envie uma solicitação POST para a rota de criação de assinatura
        $response = $this->post("api/v1/registers/{$register->id}/subscriptions", $data);

        // Verifique se a resposta tem status 201 (Created)
        $response->assertStatus(201);

        // Verifique se a assinatura foi criada no banco de dados
        $this->assertDatabaseHas('subscriptions', $data);
    }

    public function test_get_subscription_of_register()
    {
        // Crie um registro com uma assinatura associada
        $subscription = Subscription::factory()->forRegister()->create();

        // Faça a requisição para a rota
        $response = $this->get("api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}");

        // Verifique se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifique se os dados retornados correspondem aos dados esperados da assinatura
        $response->assertJson([
            'data' => $subscription->toArray(),
        ]);
    }

    public function test_update_subscription_of_register()
    {
        // Crie um registro com uma assinatura associada
        $subscription = Subscription::factory()->forRegister()->create();

        // Defina os dados para atualização da assinatura
        $updatedData = [
            'register_id' => $subscription->register_id,
            'description' => 'Updated Subscription',
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'value' => 75.00,
        ];

        // Envie uma solicitação PUT para a rota de atualização de assinatura
        $response = $this->put("api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}", $updatedData);

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifique se a assinatura foi atualizada no banco de dados
        $this->assertDatabaseHas('subscriptions', $updatedData);
    }

    public function test_delete_subscription_of_register()
    {
        // Crie um registro com uma assinatura associada
        $subscription = Subscription::factory()->forRegister()->create();

        // Envie uma solicitação DELETE para a rota de exclusão de assinatura
        $response = $this->delete("api/v1/registers/{$subscription->register_id}/subscriptions/{$subscription->id}");

        // Verifique se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifique se a assinatura foi marcada como excluída suavemente no banco de dados
        $this->assertSoftDeleted($subscription);
    }
}
