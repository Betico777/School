<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Materia;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Lista tareas de un curso específico.
     */
    public function index(Curso $curso)
    {
        $this->authorizeCurso($curso);

        $query = $curso->tareas()->with(['creadoPor', 'entregas.estudiante', 'materia']);

        // El profesor solo ve las tareas que él mismo creó
        if (auth()->user()->hasRole('profesor')) {
            $query->where('creado_por', auth()->id());
        }

        $tareas = $query->latest()->get();

        return view('tareas.index', compact('curso', 'tareas'));
    }

    public function create(Curso $curso)
    {
        $this->authorizeCurso($curso);

        $user = auth()->user();
        $materias = $user->hasRole('admin')
            ? Materia::orderBy('nombre')->get()
            : $user->materiasComoProfesor()->orderBy('nombre')->get();

        return view('tareas.create', compact('curso', 'materias'));
    }

    public function store(Request $request, Curso $curso)
    {
        $this->authorizeCurso($curso);

        $data = $request->validate([
            'titulo'       => ['required', 'string', 'max:255'],
            'descripcion'  => ['nullable', 'string'],
            'materia_id'   => ['nullable', 'exists:materias,id'],
            'fecha_limite' => ['nullable', 'date', 'after:now'],
        ]);

        $curso->tareas()->create([
            'titulo'       => $data['titulo'],
            'descripcion'  => $data['descripcion'] ?? null,
            'creado_por'   => auth()->id(),
            'materia_id'   => $data['materia_id'] ?? null,
            'fecha_limite' => $data['fecha_limite'] ?? null,
        ]);

        return redirect()->route('tareas.index', $curso)
            ->with('success', 'Tarea creada correctamente.');
    }

    public function destroy(Curso $curso, Tarea $tarea)
    {
        $this->authorizeCurso($curso);

        $tarea->delete();

        return redirect()->route('tareas.index', $curso)
            ->with('success', 'Tarea eliminada.');
    }

    /**
     * Solo admin o profesor asignado al curso puede gestionar tareas.
     */
    private function authorizeCurso(Curso $curso): void
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return;
        }

        if ($user->hasRole('profesor') && $user->cursosComoProfesor->contains($curso->id)) {
            return;
        }

        abort(403, 'No tienes permiso para gestionar las tareas de este curso.');
    }
}
