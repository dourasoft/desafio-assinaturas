<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewFaturaRequest extends FormRequest
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
            'valor' => 'required',
            'descricao' => 'required|string',
            'data_vencimento' => 'required',
            'assinatura_id' => 'required|exists:assinaturas,id',
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
            'valor.required' => 'O campo valor é obrigatório',
            'valor.numeric' => 'O campo valor deve ser um número',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.string' => 'O campo descrição deve ser uma string',
            'data_vencimento.required' => 'O campo data de vencimento é obrigatório',
            'data_vencimento.date' => 'O campo data de vencimento deve ser uma data válida',
            'assinatura_id.required' => 'O campo assinatura é obrigatório',
            'assinatura_id.exists' => 'A assinatura informada não existe',
        ];
    }
}
