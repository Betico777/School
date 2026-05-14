<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\TareaEntrega;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    public function store(Tarea $tarea)
    {
        $user = auth()->user();

        // Solo estudiantes pueden entregar
        if (! $user->hasRole('estudiante')) {
            abort(403);
        }

        // Solo si el estudiante pertenece al curso de la tarea
        if ($user->curso_id !== $tarea->curso_id) {
            abort(403, 'Esta tarea no pertenece a tu curso.');
        }

        // Verificar plazo de entrega
        if ($tarea->vencida()) {
            return back()->with('error', 'El plazo de entrega ha vencido.');
        }

        TareaEntrega::firstOrCreate(
            ['tarea_id' => $tarea->id, 'user_id' => $user->id],
            ['entregado_at' => now()]
        );

        return back()->with('success', 'Tarea marcada como entregada.');
    }
}
