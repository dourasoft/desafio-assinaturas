<?php

namespace Tests\Feature\API;

use App\Models\Cadastro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as TestingTestCase;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isFalse;

class CadastroControllerTest extends TestingTestCase
{

    use RefreshDatabase;

    public function test_buscar_cadastros(): void
    {
        Cadastro::factory(20)->create();

        $response = $this->getJson('/api/cadastro');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(20, count($response->json(['data'])));
    }

    public function test_buscar_unico_cadastro(): void
    {
        $cadastro = Cadastro::factory()->createOne();

        $response = $this->json('GET', '/api/cadastro/id', ['id' => $cadastro->id]);

        $response->assertStatus(200);
    }

    public function test_inativar_cadastro(): void
    {
        $cadastro = Cadastro::factory()->createOne();

        $response = $this->json('delete', '/api/cadastro/destroy', ['id' => $cadastro->id]);

        $response->assertStatus(200);

        $cadastro = Cadastro::find($cadastro->id);

        isFalse($cadastro->ativo);
    }
}
