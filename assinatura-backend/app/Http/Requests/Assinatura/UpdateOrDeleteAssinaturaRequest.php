<?php

namespace App\Http\Requests\Assinatura;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrDeleteAssinaturaRequest extends FormRequest
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
            'id' => 'required|integer|min:1',
            'cadastro_id' => [
                'int',
                Rule::exists('cadastros', 'id'),
                Rule::unique('assinaturas')->where('ativo', 1)
            ],
            'descricao' => [
                'string',
                'min:1',
                'max:255'
            ],
            'valor'                 => 'string|min:1|max:255',
            'dia_fechamento_fatura' => 'integer|min:1|max:31',
            'ativo'                 => 'boolean'
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
            'required'  => 'O campo :attribute precisa ser informado.',
            'unique'    => 'O :attribute já está sendo utilizado em uma assinatura ativa.',
            'email'     => 'O campo :attribute precisa ser um email válido.',
            'exists'    => 'O :attribute não existe na base de dados.',
            'min'       => 'O campo :attribute não antingiu o valor minimo de :min',
            'max'       => 'O campo :attribute ultrapassou o valor maximo de :max'
        ];
    }
}
