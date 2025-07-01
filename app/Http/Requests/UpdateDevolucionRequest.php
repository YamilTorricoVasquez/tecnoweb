<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDevolucionRequest extends FormRequest
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
            'reason_id' => ['required', 'exists:reason,id'],
            'product_id' => ['required', 'exists:products,id'],
           // 'user_id' => ['required', 'exists:users,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'fecha_caducidad' => 'devolucion fecha_caducidad',
            'cantidad' => 'devolucion cantidad',
            'reason_id' => 'devolucion reason',
            'product_id' => 'devolucion product',
            'user_id' => 'devolucion user',
            'supplier_id' => 'devolucion supplier',
        ];
    }
}
