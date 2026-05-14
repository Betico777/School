<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::withCount('tareas')->orderBy('nombre')->paginate(20);

        return view('admin.materias.index', compact('materias'));
    }

    public function create()
    {
        return view('admin.materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:255', 'unique:materias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        Materia::create($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia)
    {
        return view('admin.materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:255', 'unique:materias,nombre,' . $materia->id],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $materia->update($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia eliminada.');
    }
}
