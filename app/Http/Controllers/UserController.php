<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('ver_usuarios');

        // ID constante del rol "Gerente general"
        $gerenteGeneralRoleId = 1; // Reemplaza con el ID real de tu base de datos

        $usersQuery = User::query()
            ->whereDoesntHave('roles', function ($query) use ($gerenteGeneralRoleId) {
                $query->where('id', $gerenteGeneralRoleId);
            });

        $this->applySearch($usersQuery, $request->search);

        $users = UserResource::collection($usersQuery->paginate(5));

        return inertia('User/Index', [
            'users' => $users,
            'search' => $request->search ?? '',
        ]);
    }
    /*public function index(Request $request)
    {
        Gate::authorize('ver_usuarios');

        $usersQuery = User::query();

        $this->applySearch($usersQuery, $request->search);
        // Obtener todos los roles disponibles

        $users = UserResource::collection($usersQuery->paginate(5));
        return inertia('User/Index', [
            'users' => $users,

            'search' => $request->search ?? '',
        ]);
    }*/

    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    /* public function create()
     {
         Gate::authorize('crear_usuarios'); // Si tienes un Gate para controlar el acceso al registro
 // Obtener todos los roles disponibles
         $roles = Role::all();
         return inertia('User/Create', ['roles' => $roles]); // Renderiza la vista con Inertia

     }*/
    public function create()
    {
        Gate::authorize('crear_usuarios');

        // Obtener todos los roles excepto el rol con ID 1
        $roles = Role::where('id', '!=', 1)->get();

        return inertia('User/Create', ['roles' => $roles]); // Renderiza la vista con Inertia
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(StoreUserRequest $request)
    {
        // Autorizar la acción con el Gate
        Gate::authorize('crear_usuarios');

        // Validar los datos
        $validated = $request->validated();

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar el rol seleccionado al usuario
        $user->roles()->attach($validated['role_id']); // Aquí asignamos el rol al usuario

        // Lanzar el evento de registro del usuario
        event(new Registered($user));

        // Redirigir a la lista de usuarios
        return redirect()->route('users.index');
    }
    public function edit(User $user)
    {
        Gate::authorize('editar_usuarios'); // Verifica que el usuario tenga permisos para editar

        // Obtener todos los roles disponibles
        //  $roles = Role::all();
        // Obtener todos los roles excepto el rol con ID 1
        $roles = Role::where('id', '!=', 1)->get();
        // Cargar los roles del usuario
        $user->load('roles');
        // Verifica que los datos del usuario y roles se están pasando correctamente a Inertia
        return inertia('User/Edit', [
            'user' => $user,      // Pasa el usuario
            'roles' => $roles,    // Pasa los roles
        ]);
    }






    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('editar_usuarios'); // Verifica si el usuario tiene permisos para editar

        // Validar los datos con UpdateUserRequest
        $validated = $request->validated();

        // Actualizar la información del usuario
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Sincronizar el rol del usuario (actualizar el rol)
        $user->roles()->sync([$validated['role_id']]); // El rol del usuario se actualiza con el nuevo rol

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'El usuario fue actualizado correctamente.');
    }



    public function destroy(User $user)
    {
        Gate::authorize('eliminar_usuarios');

        $user->delete();

        return redirect()->route('users.index');
    }
}
