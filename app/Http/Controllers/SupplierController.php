<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\SupplierResource;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
class SupplierController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('supplier_access');

        $suppliersQuery = Supplier::query();

        $this->applySearch($suppliersQuery, $request->search);

        $suppliers = SupplierResource::collection($suppliersQuery->paginate(5));
        return inertia('Supplier/Index', [
            'suppliers' => $suppliers,
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
        Gate::authorize('supplier_create');

        return inertia('Supplier/Create');
    }

    public function store(StoreSupplierRequest $request)
    {
        Gate::authorize('supplier_create');

        $validated = $request->validated();
        $proveedorExistente = Supplier::where('name', $validated['name'])
            ->where('nombre_empresa', $validated['nombre_empresa'])
            ->first();

        if ($proveedorExistente) {
            // Si el cliente ya existe, verificamos si ya tiene una nota de venta
            //  $notaVentaExistente = NotaVenta::where('cliente_id', $clienteExistente->id)->latest()->first();

            return inertia('DetalleCompra/Create', [
                'supplier' => $proveedorExistente,
                // 'notaventa' => $notaVentaExistente ? $notaVentaExistente : null,  // Devuelve la nota de venta si existe
            ]);
        }
        $supplier = Supplier::create($validated);


        return inertia('DetalleCompra/Create', [
            'supplier' => $supplier,
            //  'notaventa' => null,  // No hay nota de venta aún
        ]);


    }
    public function edit(Supplier $supplier)
    {
        Gate::authorize('supplier_edit');

        return inertia('Supplier/Edit', [
            'supplier' => SupplierResource::make($supplier),
        ]);
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        Gate::authorize('supplier_edit');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $supplier->update($validated);

        return redirect()->route('suppliers.index');
    }


    public function destroy(Supplier $supplier)
    {
        Gate::authorize('supplier_delete');

        $supplier->delete();

        return redirect()->route('suppliers.index');
    }
}
