<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $rol    = $request->input('rol');

        $users = User::with(['roles', 'materiasComoProfesor'])
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%");
            }))
            ->when($rol, fn($q) => $q->whereHas('roles', fn($q) => $q->where('name', $rol)))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'search', 'rol'));
    }

    public function create()
    {
        $roles    = Role::orderBy('name')->get();
        $cursos   = Curso::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();

        return view('admin.users.create', compact('roles', 'cursos', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'confirmed', Password::defaults()],
            'roles'     => ['nullable', 'array'],
            'roles.*'   => ['exists:roles,id'],
            'cursos'    => ['nullable', 'array'],
            'cursos.*'  => ['exists:cursos,id'],
            'materias'  => ['nullable', 'array'],
            'materias.*'=> ['exists:materias,id'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->filled('roles')) {
            $user->syncRoles(Role::whereIn('id', $request->roles)->get());
        }

        // Si es profesor, asignar cursos y materias
        if ($request->filled('cursos')) {
            $user->cursosComoProfesor()->sync($request->cursos);
        }
        if ($request->filled('materias')) {
            $user->materiasComoProfesor()->sync($request->materias);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles        = Role::orderBy('name')->get();
        $cursos       = Curso::where('activo', true)->orderBy('nombre')->get();
        $materias     = Materia::orderBy('nombre')->get();
        $userRoles    = $user->roles->pluck('id')->toArray();
        $userCursos   = $user->cursosComoProfesor->pluck('id')->toArray();
        $userMaterias = $user->materiasComoProfesor->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'cursos', 'materias', 'userRoles', 'userCursos', 'userMaterias'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'  => ['nullable', 'confirmed', Password::defaults()],
            'roles'     => ['nullable', 'array'],
            'roles.*'   => ['exists:roles,id'],
            'cursos'    => ['nullable', 'array'],
            'cursos.*'  => ['exists:cursos,id'],
            'materias'  => ['nullable', 'array'],
            'materias.*'=> ['exists:materias,id'],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles(Role::whereIn('id', $request->roles ?? [])->get());
        $user->cursosComoProfesor()->sync($request->cursos ?? []);
        $user->materiasComoProfesor()->sync($request->materias ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
