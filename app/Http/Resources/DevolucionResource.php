<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class DevolucionResource extends JsonResource
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
            'fecha_caducidad' => $this->fecha_caducidad,
            'cantidad' => $this->cantidad,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'supplier' => SupplierResource::make($this->whenLoaded('supplier')),
            'reason' => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
