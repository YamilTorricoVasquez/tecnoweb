<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;
class UserResource extends JsonResource
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
            'name' => $this->name,  // Incluye explícitamente el campo name
            'email' => $this->email,
            'password' => $this->password,
            'roles' => $this->roles->pluck('id'), // IDs de los roles asignados
           // 'roles1' => RoleResource::collection($this->whenLoaded('roles')), // Usa RoleResource si lo tienes
        ];
    }
}
