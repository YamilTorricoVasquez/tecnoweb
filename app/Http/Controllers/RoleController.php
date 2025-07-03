<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /*  public function index(Request $request)
      {
          Gate::authorize('ver_roles');

          $rolesQuery = Role::query();

          $this->applySearch($rolesQuery, $request->search);

          $roles = RoleResource::collection($rolesQuery->paginate(5));

          return inertia('Roles/Index', [
              'roles' => $roles,
              'search' => $request->search ?? '',
          ]);
      }*/
    public function index(Request $request)
    {
        Gate::authorize('ver_roles');

        // Filtrar los roles para excluir el ID 1
        $rolesQuery = Role::query()->where('id', '!=', 1);

        // Aplicar la búsqueda si existe
        $this->applySearch($rolesQuery, $request->search);

        // Paginación y uso de recursos para los roles
        $roles = RoleResource::collection($rolesQuery->paginate(5));

        // Retornar la vista con los datos
        return inertia('Roles/Index', [
            'roles' => $roles,
            'search' => $request->search ?? '',
        ]);
    }

    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }

    public function create()
    {
        Gate::authorize('crear_roles');

        $permissions = PermissionResource::collection(Permission::all());

        return inertia('Roles/Create', [
            'permissions' => $permissions
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('crear_roles');

        try {
            // Crear el nuevo rol
            $role = Role::create($request->validated());

            // Sincronizar los permisos seleccionados
            $role->permissions()->sync($request->selectedPermissions);

            return redirect()->route('roles.index')->with('success', 'El rol ha sido creado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Verificar si el error es por duplicidad
            if ($e->getCode() == '23505') { // Código de error para violación de unicidad en PostgreSQL
                return redirect()->back()->withErrors([
                    'title' => 'El rol ya existe. Por favor, ingrese un nombre diferente.',
                ]);
            }

            // Si es otro tipo de error, manejarlo genéricamente
            return redirect()->back()->withErrors([
                'error' => 'Ocurrió un problema al crear el rol. Por favor, inténtelo nuevamente.',
            ]);
        }
    }


    public function edit(Role $role)
    {
        Gate::authorize('editar_roles');

        $role->load('permissions');

        return inertia('Roles/Edit', [
            'role' => RoleResource::make($role),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('editar_roles');

        $role->update($request->validated());
        $role->permissions()->sync($request->selectedPermissions);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('eliminar_roles');

        $role->delete();

        return redirect()->route('roles.index');
    }
}
