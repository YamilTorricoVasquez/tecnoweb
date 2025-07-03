<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotaCompraRequest;
use App\Http\Resources\NotaCompraResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\SupplierResource;
use App\Models\NotaCompra;
use App\Models\PaymentMethod;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NotaCompraController extends Controller
{
    public function index(Request $request)
    {//ver_notas_compras
        Gate::authorize('ver_notas_compras');

        // Cargar relación con product y inventory
        $NotaComprasQuery = NotaCompra::with('paymentmethod', 'user', 'proveedor');

        // Aplicar filtro de búsqueda
        $this->applySearch($NotaComprasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $notacompras = NotaCompraResource::collection($NotaComprasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('NotaCompra/Index', [
            'notacompras' => $notacompras,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
{
    return $query->when($search, function ($query, $search) {
        $query->whereHas('proveedor', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('nombre_empresa', 'like', '%' . $search . '%');
        })
        ->orWhereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
        ->orWhereHas('paymentmethod', function ($q) use ($search) {
            $q->where('metodo', 'like', '%' . $search . '%');
        })
        ->orWhere('fecha', 'like', '%' . $search . '%');
    });
}
    public function create()
    {
        Gate::authorize('Realizar_compra');

        // Obtener todos los productos
        $suppliers = SupplierResource::collection(Supplier::all());
        $paymentmethods = PaymentMethodResource::collection(PaymentMethod::all());
        // $reasons = ReasonResource::collection(Reason::all());
        // No necesitas pasar el ID del usuario a la vista
        return inertia('NotaCompra/Create', [
            'suppliers' => $suppliers,  // Solo pasas los productos a la vista
            'paymentmethods' => $paymentmethods,
            //  'reasons' => $reasons,
        ]);
    }



    public function store(StoreNotaCompraRequest $request)
    {//crear_notas_ventas
        Gate::authorize('Realizar_compra');

        // Valida los datos enviados desde el formulario
        $validated = $request->validated();

        // Asigna el ID del usuario autenticado
        $validated['id_usuario'] = auth()->id();

        // Asigna valores predeterminados si no se envían
        $validated['fecha'] = $validated['fecha'] ?? now()->toDateString();
        $validated['total'] = $validated['total'] ?? 0;

        // Crea un registro en la tabla notaventas
        $notacompra = NotaCompra::create($validated);

        // Redirige al índice de notas de venta
        //return redirect()->route('notacompras.index')->with('success', 'Nota de venta creada correctamente.');
        // return inertia('DetalleCompra/Create', [
        //     'notacompra' => $notacompra,
        //     //  'notaventa' => null,  // No hay nota de venta aún
        // ]);
        return response()->json(['notacompra' => $notacompra]);
    }
    
}
