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
        Gate::authorize('reason_access');

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
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {
        Gate::authorize('reason_create');

        return inertia('Reason/Create');
    }

    public function store(StoreReasonRequest $request)
    {
        Gate::authorize('reason_create');

        $validated = $request->validated();

        Reason::create($validated);

        return redirect()->route('reasons.index');
    }
    public function edit(Reason $reason)
    {
        Gate::authorize('reason_edit');

        return inertia('Reason/Edit', [
            'reason' => ReasonResource::make($reason),
        ]);
    }

    public function update(UpdateReasonRequest $request, reason $reason)
    {
        Gate::authorize('reason_edit');

        $validated = $request->validated();

        // Agregar esto para inspeccionar los datos
        //   dd($validated);

        $reason->update($validated);

        return redirect()->route('reasons.index');
    }
    public function destroy(Reason $reason)
    {
        Gate::authorize('reason_delete');

        $reason->delete();

        return redirect()->route('reasons.index');
    }
}
