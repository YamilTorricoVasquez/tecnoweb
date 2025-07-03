<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetalleCantidadVentaResource;
use App\Models\DetalleCantidadVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DetalleCantidadVentaController extends Controller
{
    public function index(Request $request)
    {//ver_detalle_cantidad_venta
        Gate::authorize('ver_detalle_cantidad_venta');

        // Cargar relación con product y inventory
        //    $DetalleVentasQuery = DetalleVenta::query();
        $DetalleCantidadVentasQuery = DetalleCantidadVenta::with('detalleventa', 'notaventa', 'caducidad');
        // Aplicar filtro de búsqueda
        $this->applySearch($DetalleCantidadVentasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $detallecantidadventas = DetalleCantidadVentaResource::collection($DetalleCantidadVentasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('DetalleCantidadVenta/Index', [
            'detallecantidadventas' => $detallecantidadventas,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
