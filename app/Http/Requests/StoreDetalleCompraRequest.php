<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetalleCompraRequest extends FormRequest
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
            'fecha_caducidad' => ['required', 'date'],
            'cantidad' => ['required', 'integer'],
            'precio_compra' => ['required', 'regex:/^\d+(\.\d{2})?$/'],  // Enforces 2 decimal places
           // 'total' => ['required', 'regex:/^\d+(\.\d{2})?$/'],
            'id_nota_compra' => ['required', 'exists:nota_compra,id'],
            //  'product_id' => ['required', 'exists:products,id'],
            //  'user_id' => ['required', 'exists:users,id'],
            'id_producto' => ['required', 'exists:products,id'],
        ];
    }

    public function attributes()
    {
        return [
            'cantidad' => 'cantidad',
            'precio_venta' => 'precio_venta',
            'id_nota_venta' => 'notaventa',
            // 'product_id' => 'product',
            // 'user_id' => 'user',

            'id_producto' => 'products',
        ];
    }
}
