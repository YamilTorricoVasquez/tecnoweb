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
        Gate::authorize('inventory_access');

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
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {
        Gate::authorize('inventory_create');

        return inertia('Inventory/Create');
    }

    public function store(StoreInventoryRequest $request)
    {
        Gate::authorize('inventory_create');

        $validated = $request->validated();

        Inventory::create($validated);

        return redirect()->route('inventories.index');
    }
    public function edit(Inventory $inventory)
    {
        Gate::authorize('inventory_edit');

        return inertia('Inventory/Edit', [
            'inventorie' => InventoryResource::make($inventory),
        ]);
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        Gate::authorize('inventory_edit');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $inventory->update($validated);

        return redirect()->route('inventories.index');
    }
    public function destroy(Inventory $inventory)
    {
        Gate::authorize('inventory_delete');

        $inventory->delete();

        return redirect()->route('inventories.index');
    }
}
