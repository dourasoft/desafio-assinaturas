<?php

namespace App\Library;

use Illuminate\Support\Facades\Validator;

class Validation
{

    /**
     * Função padrão para validação de dados
     *
     * @param array $data
     * @param array $valid_fields
     * @return void
     */
    public static function validate(array $data, array $valid_fields): bool | Response
    {
        $validator = Validator::make($data, $valid_fields);

        if ($validator->fails()) {
            Response::json(['warning' => $validator->errors()], 422);
        }

        return true;
    }
}
