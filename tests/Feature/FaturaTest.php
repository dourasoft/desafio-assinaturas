<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FaturaTest extends TestCase
{
    /**
     * Fatura feature test
     */

    public function test_donnot_creating_a_new_fatura_without_a_required_field(): void
    {
        $data = [
            // "cadastro" => "XYYYTT", // sending without code
            "assinatura" => "1",
            "descricao" => "mercado livre",
            "vencimento" => "2024-05-05 11:59:49",
            "valor" => "20",
            "status" => "pendente"

        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/cadastro/insert', $data);

        $response->assertStatus(400);
    }

    public function test_the_fatura_returns_valid_data_in_getall_route_in_getaal_route(): void
    {
        $response = $this->get('api/fatura/getall');

        $response->assertStatus(200);
    }

    public function test_returns_one_specific_fatura_in_get_route(): void
    {
        $response = $this->get('api/fatura/get/1');

        $response->assertStatus(200);
    }

    public function test_donnot_bring_fatura_with_an_invalid_id(): void
    {
        $response = $this->get('api/fatura/get/xpto');

        $response->assertStatus(400);
    }

    public function test_donnot_bring_fatura_with_nonexistent_id(): void
    {
        $response = $this->get('api/fatura/get/10000000');

        $response->assertStatus(406);
    }

    public function test_donnot_bring_fatura_sending_a_nonexistent_id(): void
    {
        $response = $this->get('api/fatura/get/10000000');

        $response->assertStatus(406);
    }

    public function test_refuse_fatura_deletation_with_an_invalid_id(): void
    {
        $response = $this->get('api/fatura/get/xpto');

        $response->assertStatus(400);
    }
}
