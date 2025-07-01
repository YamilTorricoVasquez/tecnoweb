<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class NotaCompraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'total' => $this->total,
            'proveedor' => SupplierResource::make($this->whenLoaded('proveedor')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'paymentmethod' => PaymentMethodResource::make($this->whenLoaded('paymentmethod')),
            // 'reason' => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
