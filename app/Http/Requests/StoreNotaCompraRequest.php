<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaCompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          //  'fecha' => ['required', 'date'],
          //  'total' => ['required', 'decimal'],
            'id_proveedor' => ['required', 'exists:suppliers,id'],
            //  'product_id' => ['required', 'exists:products,id'],
            //  'user_id' => ['required', 'exists:users,id'],
            'id_metodo_pago' => ['required', 'exists:payment_method,id'],
        ];
    }

    public function attributes()
    {
        return [
         //   'fecha' => 'fecha',
         //   'total' => 'total',
            'id_proveedor' => 'cliente',
            // 'product_id' => 'product',
            // 'user_id' => 'user',

            'id_metodo_pago' => 'paymentmethod',
        ];
    }
}
