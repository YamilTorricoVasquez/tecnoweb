<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInventoryDetailRequest;
use App\Models\InventoryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\InventoryDetailResource;
class InventoryDetailController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('inventorydetail_access');

        // Cargar relación con product y inventory
        $inventorydetailsQuery = InventoryDetail::with('product', 'inventory');

        // Aplicar filtro de búsqueda
        $this->applySearch($inventorydetailsQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $inventorydetails = InventoryDetailResource::collection($inventorydetailsQuery->paginate(5));

        return inertia('InventoryDetail/Index', [
            'inventorydetails' => $inventorydetails,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function edit(InventoryDetail $inventorydetail)
    {
        Gate::authorize('inventorydetail_edit');
      //  dd($inventorydeail);
        return inertia('InventoryDetail/Edit', [
            'inventorydetail' => InventoryDetailResource::make($inventorydetail),
        ]);
    }

    public function update(UpdateInventoryDetailRequest $request, InventoryDetail $inventorydetail)
    {
        Gate::authorize('inventorydetail_edit');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //    dd($validated);

        $inventorydetail->update($validated);

        return redirect()->route('inventorydetails.index');
    }
}
