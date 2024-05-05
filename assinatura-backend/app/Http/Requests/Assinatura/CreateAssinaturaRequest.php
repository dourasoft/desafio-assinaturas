<?php

namespace App\Http\Requests\Assinatura;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAssinaturaRequest extends FormRequest
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
            'cadastro_id' => [
                'required',
                'int',
                Rule::exists('cadastros', 'id'),
                Rule::unique('assinaturas')->where('ativo', 1)
            ],
            'descricao' => [
                'required',
                'string',
                'min:1',
                'max:255'
            ],
            'valor'                 => 'required|string|min:1|max:255',
            'dia_fechamento_fatura' => 'required|integer|min:1|max:31',
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
            'unique'    => 'O :attribute já está sendo utilizado em outra assinatura ativa.',
            'email'     => 'O campo :attribute precisa ser um email válido.',
            'exists'    => 'O :attribute não existe na base de dados.',
            'min'       => 'O campo :attribute não antingiu o valor minimo de :min',
            'max'       => 'O campo :attribute ultrapassou o valor maximo de :max'
        ];
    }
}
