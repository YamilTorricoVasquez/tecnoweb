<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class DetalleVentaResource extends JsonResource
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
            'cantidad' => $this->cantidad,
            'precio_venta' => $this->precio_venta,
            'total' => $this->total,
            'producto' => ProductResource::make($this->whenLoaded('producto')),
            'notaventa' => NotaVentaResource::make($this->whenLoaded('notaventa')),
            // 'reason' => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
