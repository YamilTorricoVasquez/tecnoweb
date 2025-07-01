<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class DetalleCompraResource extends JsonResource
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
            'precio_compra' => $this->precio_compra,
            'total' => $this->total,
            'producto' => ProductResource::make($this->whenLoaded('producto')),
            'notacompra' => NotaCompraResource::make($this->whenLoaded('notacompra')),
            // 'reason' => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
