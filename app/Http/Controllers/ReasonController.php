<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ReasonResource;
use App\Http\Requests\StoreReasonRequest;
use App\Http\Requests\UpdateReasonRequest;
use App\Models\Reason;

class ReasonController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('ver_razones');

        $reasonQuery = Reason::query();

        $this->applySearch($reasonQuery, $request->search);

        $reasons = ReasonResource::collection($reasonQuery->paginate(5));
        return inertia('Reason/Index', [
            'reasons' => $reasons,
            'search' => $request->search ?? '',
        ]);
    }
    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('descripcion', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {
        Gate::authorize('crear_razones');

        return inertia('Reason/Create');
    }

    public function store(StoreReasonRequest $request)
    {
        Gate::authorize('crear_razones');

        $validated = $request->validated();

        Reason::create($validated);

        return redirect()->route('reasons.index');
    }
    public function edit(Reason $reason)
    {
        Gate::authorize('editar_razones');

        return inertia('Reason/Edit', [
            'reason' => ReasonResource::make($reason),
        ]);
    }

    public function update(UpdateReasonRequest $request, reason $reason)
    {
        Gate::authorize('editar_razones');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $reason->update($validated);

        return redirect()->route('reasons.index');
    }
    public function destroy(Reason $reason)
    {
        Gate::authorize('eliminar_razones');

        $reason->delete();

        return redirect()->route('reasons.index');
    }
}
