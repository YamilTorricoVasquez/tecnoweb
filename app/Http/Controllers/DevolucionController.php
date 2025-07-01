<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReasonResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\UserResource;
use App\Models\Devolucion;
use App\Models\Product;
use App\Models\Reason;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDevolucionRequest;
use App\Http\Requests\UpdateDevolucionRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\DevolucionResource;

class DevolucionController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('devolucion_access');

        // Cargar relación con product y inventory
        $DevolucionesQuery = Devolucion::with('product', 'user', 'supplier', 'reason');

        // Aplicar filtro de búsqueda
        $this->applySearch($DevolucionesQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $devoluciones = DevolucionResource::collection($DevolucionesQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('Devolucion/Index', [
            'devoluciones' => $devoluciones,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }


    /**/
    /* public function create()
     {
         Gate::authorize('return_create');

         $products = ProductResource::collection(Product::all());
        // $reasons = ReasonResource::collection(Reason::all());
       //  $suppliers = SupplierResource::collection(Supplier::all());
         $users = UserResource::collection(User::all());

         return inertia('Devolucion/Create', [
             'products' => $products,
             'users' => $users,
             //  'suppliers' => $suppliers,
         ]);
     }
         public function store(StoreDevolucionRequest $request)
    {
        Gate::authorize('return_create');

        // Valida los datos enviados desde el formulario
        $validated = $request->validated();
        // dd($validated);
        // Crea un registro en la tabla devolucion
        Devolucion::create($validated);

        // Redirige al índice de devoluciones (o a donde desees)
        return redirect()->route('devoluciones.index')->with('success', 'Devolución creada correctamente.');
    }*/
    public function create()
    {
        Gate::authorize('devolucion_create');

        // Obtener todos los productos
        $products = ProductResource::collection(Product::all());
        $suppliers = SupplierResource::collection(Supplier::all());
        $reasons = ReasonResource::collection(Reason::all());
        // No necesitas pasar el ID del usuario a la vista
        return inertia('Devolucion/Create', [
            'products' => $products,  // Solo pasas los productos a la vista
            'suppliers' => $suppliers,
            'reasons' => $reasons,
        ]);
    }


    public function store(StoreDevolucionRequest $request)
    {
        Gate::authorize('devolucion_create');

        // Valida los datos enviados desde el formulario
        $validated = $request->validated();

        // Verifica si los datos son correctos
        //   dd($validated);  // Aquí verás todos los datos validados que se están recibiendo

        // Asignar el ID del usuario autenticado al campo `user_id` al crear la devolución
        $validated['user_id'] = auth()->id();  // Asignamos el ID del usuario autenticado al campo user_id

        // Crea un registro en la tabla devolucion con el ID del usuario autenticado
        Devolucion::create($validated);

        // Redirige al índice de devoluciones (o a donde desees)
        return redirect()->route('devoluciones.index')->with('success', 'Devolución creada correctamente.');
    }

    /*public function edit(Devolucion $devolucion)
    {
        Gate::authorize('return_edit');

        // Verificar si el objeto devolucion tiene los datos correctos
       // dd($devolucion); // Esto debería mostrar los valores de fecha_caducidad, cantidad, etc.

       // $suppliers = SupplierResource::collection(Supplier::all());
       // $products = ProductResource::collection(Product::all());
       // $reasons = ReasonResource::collection(Reason::all());
       //     dd($devolucion);
        return inertia('Devolucion/Edit', [
          //  'products' => $products,
           // 'reasons' => $reasons,
            //'suppliers' => $suppliers,
            'devolucion' => DevolucionResource::make($devolucion),
        ]);
    }*/
    public function edit(Devolucion $devolucion)
    {
        Gate::authorize('devolucion_edit');
        // $devolucion->load('products'); // Asegúrate de cargar la relación
        $products = ProductResource::collection(Product::all());
        $reasons = ReasonResource::collection(Reason::all());

        $suppliers = SupplierResource::collection(Supplier::all());
        // dd($devolucion);
        return inertia('Devolucion/Edit', [

            'suppliers' => $suppliers,
            'products' => $products,
            'reasons' => $reasons,
            'devolucion' => DevolucionResource::make($devolucion),
        ]);
    }


    public function update(UpdateDevolucionRequest $request, Devolucion $devolucion)
    {
        Gate::authorize('devolucion_edit');

        // Validar y obtener los datos validados
        $validated = $request->validated();

        // Depuración: Ver los datos validados
        //   dd($validated); // Verifica que todos los campos estén presentes

        // Asignar el ID del usuario autenticado al campo `user_id`
        $validated['user_id'] = auth()->id();

        // Actualizar la devolución
        $devolucion->update($validated);

        return redirect()->route('devoluciones.index');
    }


    public function destroy(Devolucion $devolucion)
    {
        Gate::authorize('devolucion_delete');



        $devolucion->delete();

        return redirect()->route('devoluciones.index');
    }

}
