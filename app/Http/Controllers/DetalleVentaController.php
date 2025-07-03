<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetalleVentaRequest;
use App\Http\Resources\DetalleVentaResource;
use App\Http\Resources\NotaVentaResource;
use App\Http\Resources\ProductResource;
use App\Models\DetalleVenta;
use App\Models\InventoryDetail;
use App\Models\NotaVenta;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DetalleVentaController extends Controller
{
    public function index(Request $request)
    {//ver_detalle_venta
        Gate::authorize('ver_detalle_venta');

        // Cargar relación con product y inventory
        //    $DetalleVentasQuery = DetalleVenta::query();
        $DetalleVentasQuery = DetalleVenta::with('producto', 'notaventa');
        // Aplicar filtro de búsqueda
        $this->applySearch($DetalleVentasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $detalleventas = DetalleVentaResource::collection($DetalleVentasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('DetalleVenta/Index', [
            'detalleventas' => $detalleventas,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            // Filtrar por el nombre del cliente relacionado
            $query->whereHas('products', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }
    /* public function create(Request $request)
     {
         Gate::authorize('crear_detalle_venta');

         // Obtener todos los productos
         $products = ProductResource::collection(Product::all());
         $notaventas = NotaVentaResource::collection(NotaVenta::all());
         // Obtener el id_nota_venta desde los parámetros de la solicitud
         $id_nota_venta = $request->query('id_nota_venta');
        // dd($id_nota_venta);
         return inertia('DetalleVenta/Create', [
             'products' => $products,  // Solo pasas los productos a la vista
             'notaventas' => $notaventas,
             'id_nota_venta' => $id_nota_venta, // Pasar el ID a la vista

         ]);
     }*/

    public function create(Request $request)
    {
        Gate::authorize('crear_detalle_venta');

        // Obtener todos los productos
        $products = ProductResource::collection(Product::all());

        // Obtener solo el id_nota_venta desde los parámetros de la solicitud
        $idNotaVenta = $request->query('id_nota_venta');

        // Filtrar y obtener la nota de venta correspondiente
        $notaventas = NotaVenta::find($idNotaVenta);

        // dd($notaventas);
        return inertia('DetalleVenta/Create', [
            'products' => $products,
            'notaventas' => $notaventas, // Enviar la nota de venta al frontend
        ]);
    }
    public function store(StoreDetalleVentaRequest $request)
    {
        // Autorizar la acción
        Gate::authorize('crear_detalle_venta');

        // Validar los datos enviados desde el formulario
        $validated = $request->validated();

        // Buscar el detalle del inventario relacionado al producto
        $inventoryDetail = InventoryDetail::where('product_id', $validated['id_producto'])->first();

        if (!$inventoryDetail) {
            return redirect()->back()->withErrors(['id_producto' => 'El producto no se encuentra en el inventario.']);
        }
        // dd($inventoryDetail);
        // Obtener el precio de venta del inventario
        $precioVenta = $inventoryDetail->precio_venta;

        // Asignar el precio de venta y calcular el total
        $validated['precio_venta'] = $precioVenta; // Almacena el precio por unidad
        // $validated['total'] = $validated['cantidad'] * $precioVenta; // Calcula el subtotal
        $validated['total'] = $validated['total'] ?? 0;

        // Crear el registro en la tabla detalle_ventas
        DetalleVenta::create($validated);

        // Redirigir al índice de detalle ventas con un mensaje de éxito
       // return redirect()->route('detalleventas.index')->with('success', 'Detalle de venta creado correctamente.');
    }




    /* public function store(StoreDetalleVentaRequest $request)
     {//crear_notas_ventas
         Gate::authorize('crear_detalle_venta');

         // Valida los datos enviados desde el formulario
         $validated = $request->validated();


         $validated['total'] = $validated['total'] ?? 0;

         // Crea un registro en la tabla notaventas
         DetalleVenta::create($validated);

         // Redirige al índice de notas de venta
         return redirect()->route('detalleventas.index')->with('success', 'Nota de venta creada correctamente.');
     }*/





    public function destroy(DetalleVenta $detalleventa)
    {
        Gate::authorize('eliminar_detalle_venta');



        $detalleventa->delete();

        return redirect()->route('detalleventas.index');
    }
}
