<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   /* public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }*/

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,  // Asegúrate de incluir el ID
            'name' => $this->name,  // Incluye explícitamente el campo name
            'nombre_empresa' => $this->nombre_empresa,
            'phone' => $this->phone,
            // Aquí puedes agregar otros campos si es necesario
        ];
    }
}
