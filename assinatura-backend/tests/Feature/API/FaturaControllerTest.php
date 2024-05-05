<?php

namespace Tests\Feature\API;

use App\Models\Assinaturas;
use App\Models\Cadastro;
use App\Models\Faturas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as TestingTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isFalse;

class FaturaControllerTest extends TestingTestCase
{
    use RefreshDatabase;

    public function test_buscar_faturas(): void
    {
        Cadastro::factory(20)->create();
        Assinaturas::factory(20)->create();
        Faturas::factory(20)->create();

        $response = $this->getJson('/api/fatura');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(20, count($response->json(['data'])));
    }

    public function test_buscar_unica_fatura(): void
    {
        Cadastro::factory()->createOne();
        Assinaturas::factory()->createOne();
        $fatura = Faturas::factory()->createOne();

        $response = $this->json('GET', '/api/fatura/id', ['id' => $fatura->id]);

        $response->assertStatus(200);
    }

    public function test_inativar_assinatura(): void
    {
        Cadastro::factory()->createOne();
        Assinaturas::factory()->createOne();
        $fatura = Faturas::factory()->createOne();

        $response = $this->json('delete', '/api/fatura/destroy', ['id' => $fatura->id]);

        $response->assertStatus(200);

        $assinatura = Assinaturas::find($fatura->id);

        isFalse($assinatura->ativo);
    }
}
