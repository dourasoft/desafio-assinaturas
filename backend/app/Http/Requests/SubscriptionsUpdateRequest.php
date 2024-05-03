<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;


class SubscriptionsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'sometimes|string',
            'value' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'value.integer' => 'O campo value deve ser um número inteiro correspondente aos centavos.',
            'is_active.required' => 'O campo is_active é obrigatório.',
            'is_active.boolean' => 'O campo is_active deve ser um valor booleano.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
