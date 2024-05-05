<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssinaturaTest extends TestCase
{
    /**
     * Assinatura feature test
     */

    public function test_donnot_creating_a_new_assinatura_without_a_required_field(): void
    {
        $data = [
            // "cadastro" => "XYYYTT", // sending without code
            "descricao" => "mercado livre",
            "valor" => "20",
            "status_fatura" => "aguardando",
            "vencimento" => "2024-05-05 11:59:49"
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/fatura/insert', $data);

        $response->assertStatus(400);
    }

    public function test_the_assinatura_returns_valid_data_in_getall_route_in_getaal_route(): void
    {
        $response = $this->get('api/assinatura/getall');

        $response->assertStatus(200);
    }

    public function test_returns_one_specific_assinatura_in_get_route(): void
    {
        $response = $this->get('api/assinatura/get/1');

        $response->assertStatus(200);
    }

    public function test_donnot_bring_assinatura_with_an_invalid_id(): void
    {
        $response = $this->get('api/fatura/get/xpto');

        $response->assertStatus(400);
    }

    public function test_donnot_bring_assinatura_with_nonexistent_id(): void
    {
        $response = $this->get('api/fatura/get/10000000');

        $response->assertStatus(406);
    }

    public function test_sending_a_nonexistent_id_need_to_be_warned_in_delete_route(): void
    {
        $response = $this->get('api/fatura/get/10000000');

        $response->assertStatus(406);
    }

    public function test_refuse_deletation_with_an_invalid_id(): void
    {
        $response = $this->get('api/fatura/get/xpto');

        $response->assertStatus(400);
    }
}
