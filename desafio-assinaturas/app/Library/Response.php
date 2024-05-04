<?php

namespace App\Library;

class Response
{

    /**
     * Função genérica para retorno da mensagem de requisições
     *
     * @param array|object $data
     * @param integer $status
     * @return void
     */
    public static function json(array|object $data, int $status): void
    {
        header("Access-Control-Allow-Origin: *");

        response()->json($data, $status)->send();
        exit();
    }

    /**
     * Função padrão para retorno de sucesso
     *
     * @return void
     */
    public static function success(): void
    {
        header("Access-Control-Allow-Origin: *");

        Response()->json(null, 200)->send();
        exit();
    }

    /**
     * Função padrão para retorno de acesso negado
     *
     * @return void
     */
    public static function denied(): void
    {
        header("Access-Control-Allow-Origin: *");

        Response()->json(['error' => 'Acesso negado para esse usuário'], 403)->send();
        exit();
    }

    /**
     * Função padrão para retorno de excessão
     *
     * @param \Exception $e
     * @return void
     */
    public static function exception(\Exception $e): void
    {
        header("Access-Control-Allow-Origin: *");

        response()->json(['error' => $e->getMessage()], 500)->send();
        exit();
    }
}
