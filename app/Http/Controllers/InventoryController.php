<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\InventoryResource;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
class InventoryController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('ver_inventarios');

        $inventorieQuery = Inventory::query();

        $this->applySearch($inventorieQuery, $request->search);

        $inventories = InventoryResource::collection($inventorieQuery->paginate(5));
        return inertia('Inventory/Index', [
            'inventories' => $inventories,
            'search' => $request->search ?? '',
        ]);
    }
    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('fecha', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {
        Gate::authorize('crear_inventarios');

        return inertia('Inventory/Create');
    }

    public function store(StoreInventoryRequest $request)
    {
        Gate::authorize('crear_inventarios');

        $validated = $request->validated();

        Inventory::create($validated);

        return redirect()->route('inventories.index');
    }
    public function edit(Inventory $inventory)
    {
        Gate::authorize('editar_inventarios');

        return inertia('Inventory/Edit', [
            'inventorie' => InventoryResource::make($inventory),
        ]);
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        Gate::authorize('editar_inventarios');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $inventory->update($validated);

        return redirect()->route('inventories.index');
    }
    public function destroy(Inventory $inventory)
    {
        Gate::authorize('eliminar_inventarios');

        $inventory->delete();

        return redirect()->route('inventories.index');
    }
}
