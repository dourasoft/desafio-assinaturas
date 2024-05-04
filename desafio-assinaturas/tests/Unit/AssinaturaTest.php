<?php

namespace Tests\Unit;

use App\Models\Assinatura;
use App\Models\Cadastro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class AssinaturaTest extends TestCase
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
    public function test_checa_assinatura_colunas_corretas()
    {

        $assinatura = new Assinatura();

        $expected = [
            'cadastro_id',
            'descricao',
            'valor',
            'flag_assinado',
            'data_vencimento'
        ];

        $arrayCompared = array_diff($expected, $assinatura->getFillable());

        return $this->assertEquals(0, count($arrayCompared));
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_listar_assinaturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $assinaturas = Assinatura::factory()->count(5)->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get('/api/assinaturas/index', $headers);

        $response->assertStatus(200);

        foreach ($assinaturas as $row) {
            $response->assertJson([
                'id' => $row->id,
                'cadastro_id' => $row->cadastro_id,
                'descricao' => $row->descricao,
                'data_vencimento' => $row->data_vencimento,
                'valor' => $row->valor,
                'flag_assinado' => $row->flag_assinado
            ]); 
        }
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_cadastrar_assinaturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        //$this->actingAs($user);

        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $data = [
            'id' => $this->faker->randomNumber(3),
            'cadastro_id' => $cadastro->id,
            'descricao' => $this->faker->sentence(3),
            'data_vencimento' => $this->faker->date(),
            'valor' => $this->faker->randomNumber(4),
            'flag_assinado' => $this->faker->randomElement(['PENDENTE', 'ASSINADO', 'CANCELADO']),
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->post('/api/assinaturas/store', $data, $headers);

        $response->assertStatus(200);

        // Verificar se o corpo da resposta não está vazio
        $this->assertNotEmpty($response->getContent());

        $this->assertDatabaseHas('assinaturas', [
            'descricao' => $data['descricao'],
        ]);

        $this->assertNotNull($user->currentAccessToken());
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_detalhes_assinaturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $assinatura = Assinatura::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get("/api/assinaturas/show/" . $assinatura->id, $headers);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_editar_assinaturas()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $assinatura = Assinatura::factory()->create();
        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $data = [
            'cadastro_id' => $cadastro->id,
            'descricao' => $this->faker->sentence(3),
            'data_vencimento' => $this->faker->date(),
            'valor' => $this->faker->randomNumber(4),
            'flag_assinado' => $this->faker->randomElement(['PENDENTE', 'ASSINADO', 'CANCELADO']),
        ];

        $response = $this->put('/api/assinaturas/update/' . $assinatura->id, $data, $headers);

        $response->assertStatus(200);

        $this->assertDatabaseHas('assinaturas', $data);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_excluir_assinaturas()
    {

        $user = User::factory()->create();
        $assinatura = Assinatura::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->delete('/api/assinaturas/destroy/' . $assinatura->id, [], $headers);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('assinaturas', [
            'id' => $assinatura->id,
        ]);
    }
}
