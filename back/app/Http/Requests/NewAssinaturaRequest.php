<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewAssinaturaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => 'required|string',
            'valor' => 'required|numeric',
            'dia_vencimento' => 'required|integer|between:1,28',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.numeric' => 'O campo valor deve ser um número',
            'dia_vencimento.required' => 'O campo dia de vencimento é obrigatório',
            'dia_vencimento.integer' => 'O campo dia de vencimento deve ser um número inteiro',
            'dia_vencimento.between' => 'O campo dia de vencimento deve estar entre 1 e 28',
            'user_id.required' => 'O campo usuário é obrigatório',
            'user_id.integer' => 'O campo usuário deve ser um número inteiro',
            'user_id.exists' => 'O usuário informado não existe',
        ];
    }
}
