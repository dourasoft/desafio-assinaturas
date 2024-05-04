<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="InvoiceRequest",
 *      description="Request schema for Invoice",
 *      type="object",
 *      required={"cadastre_id", "signature_id", "describe", "value", "expiration"}
 * )
 */
class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
     *          property="signature_id",
     *          description="ID of the related signature",
     *          type="integer",
     *          example=1
     *      ),
     *      @OA\Property(
     *          property="describe",
     *          description="Description of the invoice",
     *          type="string",
     *          example="Invoice description"
     *      ),
     *      @OA\Property(
     *          property="value",
     *          description="Value of the signature",
     *          type="string",
     *          example="Signature value"
     *      ),
     *      @OA\Property(
     *          property="expiration",
     *          description="Expiration of the signature",
     *          type="date",
     *          example="2024-01-01"
     *      )
     */
    public function rules(): array
    {
        return [
            'cadastre_id' => 'required|integer',
            'signature_id'=> 'required|integer',
            'describe' => 'required',
            'value' => 'required',
            'expiration'=> 'required|date'
        ];
    }
}
