<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,  // Asegúrate de incluir el ID
            'descripcion' => $this->descripcion,  // Incluye explícitamente el campo name
            // Aquí puedes agregar otros campos si es necesario
        ];
    }
}
