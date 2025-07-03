<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\StoreDetalleVentaRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ProductResource;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\InventoryDetail;
use App\Models\NotaVenta;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ClienteResource;



class ClienteController extends Controller
{
    public function index(Request $request)
    {//ver_clientes
        //crear_clientes
        Gate::authorize('ver_clientes');

        $clienteQuery = Cliente::query();

        $this->applySearch($clienteQuery, $request->search);

        $clientes = ClienteResource::collection($clienteQuery->paginate(5));
        return inertia('Cliente/Index', [
            'clientes' => $clientes,
            'search' => $request->search ?? '',
        ]);
    }

protected function applySearch($query, $search)
{
    return $query->when($search, function ($query, $search) {
        $query->where('nombre', 'like', '%' . $search . '%')
              ->orWhere('apellido', 'like', '%' . $search . '%')
              ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$search}%"]);
    });
}
    /*  public function create()
      {
          Gate::authorize('crear_clientes');
         

          return inertia('Cliente/Create');
      }*/
    public function create()
    {
        // Autorización para crear cliente
        Gate::authorize('Realizar_venta');

        // Obtener todos los métodos de pago
        $paymentmethods = PaymentMethod::all();

        // Obtener todos los productos
        $products = Product::all();

        // Obtener el precio de venta de cada producto desde el inventario
        foreach ($products as $product) {
            $inventoryDetail = InventoryDetail::where('product_id', $product->id)->first();

            // Si no se encuentra el producto en el inventario, asignar null o algún valor predeterminado
            $product->precio_venta = $inventoryDetail ? $inventoryDetail->precio_venta : null;
        }

        // Pasar los métodos de pago, productos y sus precios de venta a la vista con Inertia
        return inertia('Cliente/Create', [
            'paymentmethods' => $paymentmethods, // Pasar los métodos de pago a la vista
            'products' => $products,             // Pasar los productos con sus precios de venta
        ]);
    }


    public function store(StoreClienteRequest $request)
    {
        /*
        clientes
notaventas
detalleventas
        */ 
        Gate::authorize('Realizar_venta');

        $validated = $request->validated();
        $clienteExistente = Cliente::where('nombre', $validated['nombre'])
            ->where('apellido', $validated['apellido'])
            ->first();

        if ($clienteExistente) {
            // Si el cliente ya existe, verificamos si ya tiene una nota de venta
            $notaVentaExistente = NotaVenta::where('cliente_id', $clienteExistente->id)->latest()->first();

            // return inertia('Cliente/Create', [
            //     'cliente' => $clienteExistente,
            //     'notaventa' => $notaVentaExistente ? $notaVentaExistente : null,  // Devuelve la nota de venta si existe
            // ]);
              return response()->json(['cliente' => $clienteExistente]);
        }

        // Si el cliente no existe, creamos el cliente
        $cliente = Cliente::create($validated);

        // Devolvemos el cliente creado para que luego se cree la nota de venta
        // return inertia('Cliente/Create', [
        //     'cliente' => $cliente,
        //     'notaventa' => null,  // No hay nota de venta aún
        // ]);
        return response()->json(['cliente' => $cliente]);
    }






    /*public function store(StoreClienteRequest $request)
    {
        Gate::authorize('crear_clientes');

        $validated = $request->validated();

        Cliente::create($validated);

        return redirect()->route('clientes.index');
    }*/


    /* public function create(Request $request)
     {
         // Autorizar la creación de cliente y detalle de venta
         Gate::authorize('crear_clientes');
         Gate::authorize('crear_detalle_venta');

         // Obtener todos los métodos de pago
         $paymentmethods = PaymentMethod::all();

         // Obtener todos los productos
         $products = Product::all();

         // Obtener solo el id_nota_venta desde los parámetros de la solicitud
         $idNotaVenta = $request->query('id_nota_venta');

         // Filtrar y obtener la nota de venta correspondiente
         $notaventas = NotaVenta::find($idNotaVenta);

         return inertia('Cliente/Create', [
             'paymentmethods' => $paymentmethods, // Métodos de pago para el cliente
             'products' => $products, // Productos para el detalle de venta
             'notaventas' => $notaventas, // Nota de venta asociada (si existe)
         ]);
     }

     public function store(StoreClienteRequest $requestCliente, StoreDetalleVentaRequest $requestDetalle)
     {
         // Autorizar la acción
         Gate::authorize('crear_clientes');
         Gate::authorize('crear_detalle_venta');

         // **1. Crear o obtener Cliente**
         $validatedCliente = $requestCliente->validated();
         dd($validatedCliente);
         $cliente = Cliente::firstOrCreate(
             [
                 'nombre' => $validatedCliente['nombre'],
                 'apellido' => $validatedCliente['apellido'],
             ],
             $validatedCliente
         );

         // **2. Crear Nota de Venta asociada al Cliente**
         $notaVenta = NotaVenta::create([
             'cliente_id' => $cliente->id,
             'fecha' => $validatedCliente['fecha'] ?? now()->toDateString(),
             'total' => 0, // El total será actualizado luego
         ]);

         // **3. Crear Detalle de Venta**
         $validatedDetalle = $requestDetalle->validated();

         // Validar que los campos requeridos existan
         if (!isset($validatedDetalle['id_producto']) || !isset($validatedDetalle['cantidad'])) {
             return redirect()->back()->withErrors([
                 'id_producto' => 'El producto y la cantidad son obligatorios.',
                 'cantidad' => 'La cantidad es obligatoria.',
             ]);
         }

         // Buscar el detalle del inventario relacionado al producto
         $inventoryDetail = InventoryDetail::where('product_id', $validatedDetalle['id_producto'])->first();

         if (!$inventoryDetail) {
             return redirect()->back()->withErrors(['id_producto' => 'El producto no se encuentra en el inventario.']);
         }

         // Obtener el precio de venta del inventario
         $precioVenta = $inventoryDetail->precio_venta;

         // Calcular subtotal y total
         $validatedDetalle['nota_venta_id'] = $notaVenta->id; // Asociar con la nota de venta
         $validatedDetalle['precio_venta'] = $precioVenta;
         // $validatedDetalle['subtotal'] = $validatedDetalle['cantidad'] * $precioVenta;

         // Crear el registro en la tabla detalle_ventas
         DetalleVenta::create($validatedDetalle);

         // **4. Actualizar total de la Nota de Venta**
         //  $notaVenta->total += $validatedDetalle['subtotal'];
         $notaVenta->save();

         // Redirigir al índice con un mensaje de éxito
         return redirect()->route('notaventas.index')->with('success', 'Venta creada correctamente.');
     }*/



    public function edit(Cliente $cliente)
    {
        Gate::authorize('editar_clientes');

        return inertia('Cliente/Edit', [
            'cliente' => ClienteResource::make($cliente),
        ]);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        Gate::authorize('editar_clientes');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $cliente->update($validated);

        return redirect()->route('clientes.index');
    }
    public function destroy(Cliente $cliente)
    {//eliminar_clientes
        Gate::authorize('eliminar_clientes');

        $cliente->delete();

        return redirect()->route('clientes.index');
    }
}
