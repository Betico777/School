<?php

namespace App\Http\Controllers;

use App\Models\Curso;

class ProfesorCursoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $cursos = Curso::withCount(['estudiantes', 'tareas'])->orderBy('nombre')->get();
        } else {
            $cursos = $user->cursosComoProfesor()->withCount(['estudiantes', 'tareas'])->orderBy('nombre')->get();
        }

        return view('profesor.cursos', compact('cursos'));
    }

    public function estudiantes(Curso $curso)
    {
        $user = auth()->user();

        if (! $user->hasRole('admin') && ! $user->cursosComoProfesor->contains($curso->id)) {
            abort(403, 'No tienes acceso a este curso.');
        }

        $estudiantes = $curso->estudiantes()->orderBy('name')->get();
        $totalTareas = $curso->tareas()->count();

        return view('profesor.curso-estudiantes', compact('curso', 'estudiantes', 'totalTareas'));
    }

    public function show(Curso $curso)
    {
        $user = auth()->user();

        if (! $user->hasRole('admin') && ! $user->cursosComoProfesor->contains($curso->id)) {
            abort(403, 'No tienes acceso a este curso.');
        }

        $estudiantes = $curso->estudiantes()->orderBy('name')->get();

        $tareasQuery = $curso->tareas()->with(['creadoPor', 'entregas.estudiante']);
        if ($user->hasRole('profesor')) {
            $tareasQuery->where('creado_por', $user->id);
        }
        $tareas = $tareasQuery->latest()->get();

        return view('profesor.curso-show', compact('curso', 'estudiantes', 'tareas'));
    }
}
