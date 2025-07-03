<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CaducidadResource;
use App\Models\Caducidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CaducidadController extends Controller
{
    public function index(Request $request)
    {//ver_caducidades
        Gate::authorize('ver_caducidades');

        // Cargar relación con product y inventory
        //    $DetalleVentasQuery = DetalleVenta::query();
        $CaducidadQuery = Caducidad::with('producto', 'notacompra', 'detallecompra');
        // Aplicar filtro de búsqueda
        $this->applySearch($CaducidadQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $caducidades = CaducidadResource::collection($CaducidadQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('Caducidad/Index', [
            'caducidades' => $caducidades,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
{
    return $query->when($search, function ($query, $search) {
        $query->whereHas('producto', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
        ->orWhere('fecha_caducidad', 'like', '%' . $search . '%')
         ->orWhere('cantidad', 'like', '%' . $search . '%');
    });
}
}
