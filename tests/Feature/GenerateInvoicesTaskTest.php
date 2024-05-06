<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Register;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GenerateInvoicesTaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function test_generate_invoices_command()
    {
        // Criar algumas assinaturas que expiram em 10 dias
        Subscription::factory()->create([
            'due_date' => now()->addDays(8), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);
        Subscription::factory()->forRegister()->create([
            'due_date' => now()->addDays(9), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);

        // Criar uma assinatura que não expira em 10 dias
        Subscription::factory()->create([
            'due_date' => now()->addDays(10), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);

        // Criar uma assinatura com uma fatura existente
        $subscription = Subscription::factory()->create([
            'due_date' => now()->addDays(10), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();

        $subscription = Subscription::factory()->create([
            'due_date' => now()->addDays(12), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);
        $invoice = Invoice::factory()->state([
            'register_id' => $subscription->register_id,
            'subscription_id' => $subscription->id,
            'description' => $subscription->description,
            'due_date' => $subscription->due_date,
            'value' => $subscription->value
        ])->create();

        Subscription::factory()->create([
            'due_date' => now()->addDays(11), 'description' => fake()->sentence(5), 'value' => fake()->randomFloat(2, 20, 160), 'register_id' => Register::factory()->create()
        ]);

        // Executar o comando
        Artisan::call('invoices:generate');

        // Verificar se as faturas foram geradas para assinaturas que expiram em 10 dias
        $this->assertEquals(5, Invoice::count());

        // Verificar se as faturas foram geradas corretamente
        $this->assertDatabaseHas('invoices', [
            'subscription_id' => Subscription::whereDate('due_date', '<=', now()->addDays(10))->first()->id
        ]);

        // Verificar se a mensagem de sucesso é exibida
        $this->expectsOutput('Invoices generated successfully.', Artisan::output());
    }
}
