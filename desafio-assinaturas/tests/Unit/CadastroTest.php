<?php

namespace Tests\Unit;

use App\Models\Cadastro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class CadastroTest extends TestCase
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
    public function test_checa_cadastro_colunas_corretas()
    {

        $cadastro = new Cadastro();

        $expected = [
            'nome',
            'email',
            'telefone',
            'codigo'
        ];

        $arrayCompared = array_diff($expected, $cadastro->getFillable());

        return $this->assertEquals(0, count($arrayCompared));
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_listar_cadastros()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $cadastros = Cadastro::factory()->count(5)->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get('/api/cadastros/index', $headers);

        $response->assertStatus(200);

        foreach ($cadastros as $row) {
            $response->assertJson([
                'id' => $row->id,
                'nome' => $row->cadastro_id,
                'email' => $row->assinatura_id,
                'telefone' => $row->descricao,
                'codigo' => $row->codigo,
            ]);
        }
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_cadastrar_cadastros()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        //$this->actingAs($user);

        $token = $user->createToken('dourasoft')->plainTextToken;

        $data = [
            'id' => $this->faker->randomNumber(3),
            'nome' => $this->faker->name(),
            'email' => $this->faker->email(),
            'telefone' => $this->faker->phoneNumber(),
            'codigo' => $this->faker->uuid()
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->post('/api/cadastros/store', $data, $headers);

        $response->assertStatus(200);

        // Verificar se o corpo da resposta não está vazio
        $this->assertNotEmpty($response->getContent());

        $this->assertDatabaseHas('cadastros', [
            'nome' => $data['nome'],
        ]);

        $this->assertNotNull($user->currentAccessToken());
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_detalhes_cadastro()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->get("/api/cadastros/show/" . $cadastro->id, $headers);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_editar_cadastro()
    {
        $this->refreshDatabase();

        $user = User::factory()->create();
        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $data = [
            'id' => $this->faker->randomNumber(3),
            'nome' => $this->faker->name(),
            'email' => $this->faker->email(),
            'telefone' => $this->faker->phoneNumber(),
            'codigo' => $this->faker->uuid()
        ];

        $response = $this->put('/api/cadastros/update/' . $cadastro->id, $data, $headers);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cadastros', $data);
    }

    /**
     * @test
     */
    public function test_checa_usuarios_autenticados_excluir_cadastro()
    {

        $user = User::factory()->create();
        $cadastro = Cadastro::factory()->create();

        $token = $user->createToken('dourasoft')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $response = $this->delete('/api/cadastros/destroy/' . $cadastro->id, [], $headers);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('cadastros', [
            'id' => $cadastro->id,
        ]);
    }
}
