<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaVentaRequest extends FormRequest
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
            'cliente_id' => ['required', 'exists:cliente,id'],
            //  'product_id' => ['required', 'exists:products,id'],
            //  'user_id' => ['required', 'exists:users,id'],
            'paymentmethod_id' => ['required', 'exists:payment_method,id'],
        ];
    }

    public function attributes()
    {
        return [
         //   'fecha' => 'fecha',
         //   'total' => 'total',
            'cliente_id' => 'cliente',
            // 'product_id' => 'product',
            // 'user_id' => 'user',

            'paymentmethod_id' => 'paymentmethod',
        ];
    }
}
