<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrDeleteCadastroFormRequest extends FormRequest
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
            'id' => 'required|integer|min:1|not_in:0',
            'email' => [
                'email',
                Rule::unique('cadastros')->where('ativo', 1)
            ],
            'codigo' => [
                'string',
                Rule::unique('cadastros')->where('ativo', 1),
                'min:1',
                'max:255'
            ],
            'nome'      => 'string|min:1|max:255',
            'telefone'  => 'string|min:11|max:255',
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
            'email'     => 'O campo :attribute precisa ser um email válido.'
        ];
    }
}
