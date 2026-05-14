<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::withCount('estudiantes')->orderBy('nombre')->paginate(15);

        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('admin.cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:100', 'unique:cursos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo'      => ['boolean'],
        ]);

        Curso::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo'      => $request->boolean('activo', true),
        ]);

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        return view('admin.cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:100', 'unique:cursos,nombre,' . $curso->id],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo'      => ['boolean'],
        ]);

        $curso->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo'      => $request->boolean('activo', true),
        ]);

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}
