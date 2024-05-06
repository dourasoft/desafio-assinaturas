<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
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
}
