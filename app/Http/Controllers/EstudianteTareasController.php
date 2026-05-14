<?php

namespace App\Http\Controllers;

class EstudianteTareasController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->curso_id) {
            return view('estudiante.tareas', ['tareas' => collect(), 'curso' => null]);
        }

        $curso = $user->curso;
        $tareas = $curso->tareas()
            ->with(['creadoPor', 'materia', 'entregas' => fn ($q) => $q->where('user_id', $user->id)])
            ->latest()
            ->get();

        return view('estudiante.tareas', compact('tareas', 'curso'));
    }
}
