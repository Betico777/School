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
            ->get()
            ->sortBy(function ($tarea) {
                $entregada = $tarea->entregas->isNotEmpty();
                $vencida   = $tarea->vencida();

                // 0 = pendiente, 1 = entregada, 2 = vencida sin entregar
                $grupo = $entregada ? 1 : ($vencida ? 2 : 0);

                // Dentro de pendientes, ordenar por fecha límite más cercana primero
                $secundario = $tarea->fecha_limite?->timestamp ?? PHP_INT_MAX;

                return [$grupo, $secundario];
            })
            ->values();

        return view('estudiante.tareas', compact('tareas', 'curso'));
    }
}
