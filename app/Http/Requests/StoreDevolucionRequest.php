<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevolucionRequest extends FormRequest
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
            'cantidad' => ['nullable', 'integer'],
            'reason_id' => ['required', 'exists:reason,id'],
            'product_id' => ['required', 'exists:products,id'],
            //  'user_id' => ['required', 'exists:users,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
        ];
    }

    public function attributes()
    {
        return [
            'fecha_caducidad' => 'fecha_caducidad',
            'cantidad' => 'cantidad',
            'reason_id' => 'reason',
            'product_id' => 'product',
            // 'user_id' => 'user',

            'supplier_id' => 'supplier',
        ];
    }
}
