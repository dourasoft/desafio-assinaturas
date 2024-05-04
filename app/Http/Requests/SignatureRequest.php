<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="SignatureRequest",
 *      description="Request schema for Signature",
 *      type="object",
 *      required={"cadastre_id", "describe", "value"}
 * )
 */
class SignatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     *      @OA\Property(
     *          property="cadastre_id",
     *          description="ID of the related cadastre",
     *          type="integer",
     *          example=1
     *      ),
     *      @OA\Property(
     *          property="describe",
     *          description="Description of the signature",
     *          type="string",
     *          example="Signature description"
     *      ),
     *      @OA\Property(
     *          property="value",
     *          description="Value of the signature",
     *          type="string",
     *          example="Signature value"
     *      )
     */
    public function rules(): array
    {
        return [
            'cadastre_id' => 'required|integer',
            'describe' => 'required',
            'value' => 'required'
        ];
    }
}
