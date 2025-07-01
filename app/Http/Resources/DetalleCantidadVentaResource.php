<?php

namespace App\Http\Resources;


use App\Models\Caducidad;
use App\Models\DetalleCompra;
use App\Models\NotaVenta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Asegúrate de importar Carbon al principio del archivo

class DetalleCantidadVentaResource extends JsonResource
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
            'cantidad'=> $this->cantidad,
            'notaventa' => NotaVentaResource::make($this->whenLoaded('notaventa')),
            'detallecompra' => DetalleCompraResource::make($this->whenLoaded('detallecompra')),
            'caducidad' => CaducidadResource::make($this->whenLoaded('caducidad')),
        ];
    }
}
