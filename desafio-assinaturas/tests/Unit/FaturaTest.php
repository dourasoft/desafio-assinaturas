<?php

namespace Tests\Unit;

use App\Models\Assinatura;
use App\Models\Cadastro;
use App\Models\Fatura;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class FaturaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use HasApiTokens;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function test_checa_fatura_colunas_corretas()
    {

        $fatura = new Fatura();

        $expected = [
            'cadastro_id',
            'assinatura_id',
            'descricao',
            'data_vencimento',
            'valor'
        ];

        $arrayCompared = array_diff($expected, $fatura->getFillable());

        return $this->assertEquals(0, count($arrayCompared));
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_listar_faturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $faturas = Fatura::factory()->count(5)->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get('/api/faturas/index', $headers);

        $response->assertStatus(200);

        foreach ($faturas as $row) {
            $response->assertJson([
                'id' => $row->id,
                'cadastro_id' => $row->cadastro_id,
                'assinatura_id' => $row->assinatura_id,
                'descricao' => $row->descricao,
                'data_vencimento' => $row->data_vencimento,
                'valor' => $row->valor
            ]);
        }
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_cadastrar_faturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        //$this->actingAs($user);

        $cadastro = Cadastro::factory()->create();
        $assinatura = Assinatura::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $data = [
            'id' => $this->faker->randomNumber(3),
            'cadastro_id' => $cadastro->id,
            'assinatura_id' => $assinatura->id,
            'descricao' => $this->faker->sentence(3),
            'data_vencimento' => $this->faker->date(),
            'valor' => $this->faker->randomNumber(4),
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->post('/api/faturas/store', $data, $headers);

        $response->assertStatus(200);

        // Verificar se o corpo da resposta não está vazio
        $this->assertNotEmpty($response->getContent());

        $this->assertDatabaseHas('faturas', [
            'descricao' => $data['descricao'],
        ]);

        $this->assertNotNull($user->currentAccessToken());
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_detalhes_fatura()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $fatura = Fatura::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get("/api/faturas/show/" . $fatura->id, $headers);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_editar_faturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $fatura = Fatura::factory()->create();
        $assinatura = Assinatura::factory()->create();
        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $data = [
            'cadastro_id' => $cadastro->id,
            'assinatura_id' => $assinatura->id,
            'descricao' => $this->faker->sentence(3),
            'data_vencimento' => $this->faker->date(),
            'valor' => $this->faker->randomNumber(4),
        ];

        $response = $this->put('/api/faturas/update/' . $fatura->id, $data, $headers);

        $response->assertStatus(200);

        $this->assertDatabaseHas('faturas', $data);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_excluir_faturas()
    {

        $user = User::factory()->create();
        $fatura = Fatura::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->delete('/api/faturas/destroy/' . $fatura->id, [], $headers);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('faturas', [
            'id' => $fatura->id,
        ]);
    }
}
