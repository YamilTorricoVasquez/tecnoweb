<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class CaducidadResource extends JsonResource
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
            'producto' => ProductResource::make($this->whenLoaded('producto')),
            'notacompra' => NotaCompraResource::make($this->whenLoaded('notacompra')),
            'detallecompra' => DetalleCompraResource::make($this->whenLoaded('detallecompra')),
        ];
    }
}
