<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;


class InvoicesUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'value' => 'sometimes|integer',
            'status' => 'sometimes|in:PENDING,PAID,REVOKED',
        ];
    }

    public function messages()
    {
        return [
            'value.integer' => 'O campo value deve ser um número inteiro.',
            'due_date.date' => 'O campo due_date deve ser uma data válida.',
            'status.in' => 'O status fornecido não é válido.',
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
