<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetalleVentaRequest extends FormRequest
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
            'cantidad' => ['required', 'integer', 'min:1'],
            'precio_venta' => ['regex:/^\d+(\.\d{2})?$/'],  // Enforces 2 decimal places
            'id_nota_venta' => ['required', 'exists:nota_venta,id'],
            //  'product_id' => ['required', 'exists:products,id'],
            //  'user_id' => ['required', 'exists:users,id'],
            'id_producto' => ['required', 'exists:products,id'],
        ];
    }

    public function attributes()
    {
        return [
            'cantidad' => 'cantidad',
            // 'precio_venta' => 'precio_venta',
            'id_nota_venta' => 'notaventa',
            // 'product_id' => 'product',
            // 'user_id' => 'user',

            'id_producto' => 'producto',
        ];
    }
}
