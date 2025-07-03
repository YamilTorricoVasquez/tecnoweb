<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetalleCompraRequest;
use App\Http\Resources\DetalleCompraResource;
use App\Http\Resources\NotaCompraResource;
use App\Http\Resources\ProductResource;
use App\Models\DetalleCompra;
use App\Models\NotaCompra;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DetalleCompraController extends Controller
{
    public function index(Request $request)
    {//ver_detalle_compra
        Gate::authorize('ver_detalle_compra');

        // Cargar relación con product y inventory
        //    $DetalleVentasQuery = DetalleVenta::query();
        $DetalleComprasQuery = DetalleCompra::with('producto', 'notacompra');
        // Aplicar filtro de búsqueda
        $this->applySearch($DetalleComprasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $detallecompras = DetalleCompraResource::collection($DetalleComprasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('DetalleCompra/Index', [
            'detallecompras' => $detallecompras,
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
    public function create(Request $request)
    {
        Gate::authorize('Realizar_compra');

        // Obtener todos los productos
        //   $products = ProductResource::collection(Product::all());
        $products = Product::all();
        $paymentmethods = PaymentMethod::all();
        //$notacompras = NotaCompraResource::collection(NotaCompra::all());
        // $reasons = ReasonResource::collection(Reason::all());
        //  dd($notaventas);
        // No necesitas pasar el ID del usuario a la vista
        // Obtener solo el id_nota_venta desde los parámetros de la solicitud
        $idNotaCompra = $request->query('id_nota_compra');
        //  dd($idNotaCompra);
        // Filtrar y obtener la nota de venta correspondiente
        $notacompras = NotaCompra::find($idNotaCompra);
        //dd($notacompras);
        return inertia('DetalleCompra/Create', [
            'products' => $products,  // Solo pasas los productos a la vista
            //  'notacompras' => $notacompras,
            'paymentmethods' => $paymentmethods,
            'notacompras' => $notacompras,
        ]);
    }



    public function store(StoreDetalleCompraRequest $request)
    {//crear_detalle_compra
        Gate::authorize('Realizar_compra');

        // Valida los datos enviados desde el formulario
        $validated = $request->validated();

        // Asigna el ID del usuario autenticado
        // $validated['user_id'] = auth()->id();

        // Asigna valores predeterminados si no se envían
        //$validated['fecha'] = $validated['fecha'] ?? now()->toDateString();
        // $validated['total'] = $validated['total'] ?? 0;

        // Crea un registro en la tabla notaventas
        // dd($validated);
        DetalleCompra::create($validated);

        // Redirige al índice de notas de venta
        //return redirect()->route('detallecompras.index')->with('success', 'Nota de venta creada correctamente.');
    }
public function storeMultiple(Request $request)
{
    $data = $request->validate([
        'detalles' => 'required|array',
        'detalles.*.id_nota_compra' => 'required|exists:nota_compra,id',
        'detalles.*.id_producto' => 'required|exists:products,id',
        'detalles.*.fecha_caducidad' => 'required|date',
        'detalles.*.cantidad' => 'required|numeric|min:1',
        'detalles.*.precio_compra' => 'required|numeric|min:0.01',
        'detalles.*.total' => 'required|numeric|min:0',
    ]);

    foreach ($data['detalles'] as $detalle) {
        \App\Models\DetalleCompra::create($detalle);
    }

    //return response()->json(['message' => 'Detalles de compra registrados correctamente']);
}
}
