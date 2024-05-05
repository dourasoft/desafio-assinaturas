<?php

namespace Tests\Feature\API;

use App\Models\Assinaturas;
use App\Models\Cadastro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as TestingTestCase;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isFalse;

class AssinaturaControllerTest extends TestingTestCase
{

    use RefreshDatabase;

    public function test_buscar_assinaturas(): void
    {
        Cadastro::factory(20)->create();
        Assinaturas::factory(20)->create();

        $response = $this->getJson('/api/assinatura');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(20, count($response->json(['data'])));
    }

    public function test_buscar_unica_assinatura(): void
    {
        Cadastro::factory()->createOne();
        $assinatura = Assinaturas::factory()->createOne();

        $response = $this->json('GET', '/api/assinatura/id', ['id' => $assinatura->id]);

        $response->assertStatus(200);
    }

    public function test_inativar_assinatura(): void
    {
        Cadastro::factory()->createOne();
        $assinatura = Assinaturas::factory()->createOne();

        $response = $this->json('delete', '/api/assinatura/destroy', ['id' => $assinatura->id]);

        $response->assertStatus(200);

        $assinatura = Assinaturas::find($assinatura->id);

        isFalse($assinatura->ativo);
    }
}
