<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\PaymentMethodResource;
use App\Models\NotaVenta;
use App\Models\Cliente;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\NotaVentaResource;
use App\Http\Requests\StoreNotaVentaRequest;
use Inertia\Inertia;

class NotaVentaController extends Controller
{
    public function index(Request $request)
    {//ver_notas_ventas
        Gate::authorize('ver_notas_ventas');

        // Cargar relación con product y inventory
        $NotaVentasQuery = NotaVenta::with('paymentmethod', 'user', 'cliente');

        // Aplicar filtro de búsqueda
        $this->applySearch($NotaVentasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $notaventas = NotaVentaResource::collection($NotaVentasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);

        return inertia('NotaVenta/Index', [
            'notaventas' => $notaventas,
            'search' => $request->search ?? '',
        ]);
    }


    protected function applySearch($query, $search)
{
    return $query->when($search, function ($query, $search) {
        $query->whereHas('cliente', function ($q) use ($search) {
            $q->where('nombre', 'like', '%' . $search . '%')
              ->orWhere('apellido', 'like', '%' . $search . '%')
              ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$search}%"]);
        })
        ->orWhereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
         ->orWhereHas('paymentmethod', function ($q) use ($search) {
            $q->where('metodo', 'like', '%' . $search . '%');
        })
        ->orWhere('fecha', 'like', '%' . $search . '%')
        ->orWhere('total', 'like', '%' . $search . '%');
    });
}

    /* public function create()
     {
         Gate::authorize('crear_notas_ventas');

         // Obtener todos los productos
         $clientes = ClienteResource::collection(Cliente::all());
         $paymentmethods = PaymentMethodResource::collection(PaymentMethod::all());
         // $reasons = ReasonResource::collection(Reason::all());
         // No necesitas pasar el ID del usuario a la vista
         return inertia('NotaVenta/Create', [
             'clientes' => $clientes,  // Solo pasas los productos a la vista
             'paymentmethods' => $paymentmethods,
             //  'reasons' => $reasons,
         ]);
     }*/
    public function create()
    {
        Gate::authorize('Realizar_venta');

        // Obtener todos los clientes y métodos de pago
        $clientes = ClienteResource::collection(Cliente::all());
        $paymentmethods = PaymentMethodResource::collection(PaymentMethod::all());

        return inertia('NotaVenta/Create', [
            'clientes' => $clientes,
            'paymentmethods' => $paymentmethods,
        ]);
    }



    public function store(StoreNotaVentaRequest $request)
    {
        Gate::authorize('Realizar_venta');

        // Valida los datos enviados desde el formulario
        $validated = $request->validated();

        // Asigna el ID del usuario autenticado
        $validated['user_id'] = auth()->id();

        // Asigna valores predeterminados si no se envían
        $validated['fecha'] = $validated['fecha'] ?? now()->toDateString();
        $validated['total'] = $validated['total'] ?? 0;

        // Crea un registro en la tabla notaventas
        $notaventa = NotaVenta::create($validated);
        // Cargar relación con product y inventory
        $NotaVentasQuery = NotaVenta::with('paymentmethod', 'user', 'cliente');

        // Aplicar filtro de búsqueda
        $this->applySearch($NotaVentasQuery, $request->search);

        // Obtener los detalles del inventario con las relaciones cargadas
        $notaventas = NotaVentaResource::collection($NotaVentasQuery->paginate(5));
        // Dump the data to check if it's correctly loaded
        // dd($devoluciones);
        // Redirige a la misma vista con un mensaje de éxito y la notaventa creada
        // return inertia('NotaVenta/Index', [
        //     'success' => 'Nota de venta creada correctamente.',
        //     'notaventas' => $notaventas,
        //     'search' => $request->search ?? '',
        //     'notaventa' => $notaventa
        // ]);
        return response()->json(['notaventa' => $notaventa]);
    }





    public function destroy(NotaVenta $notaventa)
    {
        Gate::authorize('eliminar_notas_ventas');

        $notaventa->delete();

        return redirect()->route('notaventas.index');
    }

}
