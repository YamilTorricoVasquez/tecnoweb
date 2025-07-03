<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('ver_metodos_pagos');

        $paymentmethodQuery = PaymentMethod::query();

        $this->applySearch($paymentmethodQuery, $request->search);

        $paymentmethods = PaymentMethodResource::collection($paymentmethodQuery->paginate(5));
        return inertia('PaymentMethod/Index', [
            'paymentmethods' => $paymentmethods,
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
        Gate::authorize('crear_metodos_pagos');

        return inertia('PaymentMethod/Create');
    }

    public function store(StorePaymentMethodRequest $request)
    {
        Gate::authorize('crear_metodos_pagos');

        $validated = $request->validated();

        PaymentMethod::create($validated);

        return redirect()->route('paymentmethods.index');
    }
    public function edit(PaymentMethod $paymentmethod)
    {
        Gate::authorize('editar_metodos_pagos');

        return inertia('PaymentMethod/Edit', [
            'paymentmethod' => PaymentMethodResource::make($paymentmethod),
        ]);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentmethod)
    {
        Gate::authorize('editar_metodos_pagos');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $paymentmethod->update($validated);

        return redirect()->route('paymentmethods.index');
    }
    public function destroy(PaymentMethod $paymentmethod)
    {
        Gate::authorize('eliminar_metodos_pagos');

        $paymentmethod->delete();

        return redirect()->route('paymentmethods.index');
    }
}
