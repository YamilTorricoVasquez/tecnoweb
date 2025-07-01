<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
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
            'nombre' => $this->nombre,  // Incluye explícitamente el campo name
            'apellido' => $this->apellido,  // Incluye explícitamente el campo name
            // Aquí puedes agregar otros campos si es necesario
        ];
    }
}
