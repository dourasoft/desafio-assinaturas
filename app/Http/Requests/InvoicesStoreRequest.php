<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class InvoicesStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'registration_id' => 'required|exists:registrations,id',
            'subscription_id' => 'required|exists:subscriptions,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'registration_id.required' => 'O campo registration_id é obrigatório.',
            'registration_id.exists' => 'O registration_id fornecido não é válido.',
            'subscription_id.required' => 'O campo subscription_id é obrigatório.',
            'subscription_id.exists' => 'O subscription_id fornecido não é válido.',
            'description.required' => 'O campo description é obrigatório.',
            'due_date.required' => 'O campo due_date é obrigatório.',
            'due_date.date' => 'O campo due_date deve ser uma data válida.',
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
