<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class InventoryDetailResource extends JsonResource
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
            'cantidad_minima' => $this->cantidad_minima,
            'precio_venta' => $this->precio_venta,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'inventory' => InventoryResource::make($this->whenLoaded('inventory')),
            /*  'inventory_date' => $this->whenLoaded('inventory') 
              ? Carbon::parse($this->inventory->fecha)->toFormattedDateString() 
              : null,*/ // Convertir la fecha a un objeto Carbon y luego formatearla

        ];
    }
}
