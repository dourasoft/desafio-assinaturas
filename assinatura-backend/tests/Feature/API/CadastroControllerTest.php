<?php

namespace Tests\Feature\API;

use App\Models\Cadastro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CadastroControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_buscar_cadastros_ativos(): void
    {
        Cadastro::factory(20)->create();

        $response = $this->getJson('/api/cadastro');

        $response->assertStatus(200);

        $this->assertEquals(20, count($response->json(['data'])));
    }

    public function test_buscar_cadastros_inativos(): void 
    {
        Cadastro::factory(10)->create(['ativo' => false]);

        $response = $this->getJson('/api/cadastro');

        $response->assertStatus(200);

        $this->assertEquals(0, count($response->json(['data'])));
    }

    public function test_buscar_unico_cadastro(): void
    {
        $cadastro = Cadastro::factory()->createOne();

        $response = $this->getJson("/api/cadastro/$cadastro->codigo");

        $response->assertStatus(200);
    }
}
