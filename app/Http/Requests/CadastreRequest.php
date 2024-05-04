<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="CadastreRequest",
 *      description="Request schema for Cadastre",
 *      type="object",
 *      required={"name", "email", "phone"}
 * )
 */
class CadastreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @OA\Property(
     *      property="name",
     *      type="string",
     *      example="John Doe",
     *      description="Name of the user"
     * )
     * @OA\Property(
     *      property="email",
     *      type="string",
     *      format="email",
     *      example="john@example.com",
     *      description="Email of the user"
     * )
     * @OA\Property(
     *      property="phone",
     *      type="string",
     *      example="1234567890",
     *      description="Phone number of the user"
     * )
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:cadastres',
            'phone' => 'required|min:11'
        ];
    }
}
