<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class SubscriptionsStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'registration_id' => 'required|exists:registrations,id',
            'description' => 'required|string',
            'value' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'registration_id.required' => 'O campo registration_id é obrigatório.',
            'registration_id.exists' => 'O registration_id fornecido não é válido.',
            'description.required' => 'O campo description é obrigatório.',
            'value.required' => 'O campo value é obrigatório.',
            'value.integer' => 'O campo value deve ser um número inteiro.',
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
