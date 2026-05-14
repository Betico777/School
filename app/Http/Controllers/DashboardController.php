<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $totalUsuarios   = User::count();
            $totalEstudiantes = User::role('estudiante')->count();
            $totalProfesores  = User::role('profesor')->count();
            $totalCursos      = Curso::where('activo', true)->count();
            $ultimosUsuarios  = User::with('roles')->latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'totalUsuarios', 'totalEstudiantes', 'totalProfesores', 'totalCursos', 'ultimosUsuarios'
            ));
        }

        if ($user->hasRole('profesor')) {
            $cursos = $user->cursosComoProfesor()
                ->withCount(['estudiantes', 'tareas'])
                ->orderBy('nombre')
                ->get();

            $totalEstudiantes = $cursos->sum('estudiantes_count');
            $totalTareas      = $cursos->sum('tareas_count');

            return view('dashboard.profesor', compact('cursos', 'totalEstudiantes', 'totalTareas'));
        }

        // Estudiante
        $curso = $user->curso;
        $totalTareas    = $curso ? $curso->tareas()->count() : 0;
        $totalEntregas  = $user->entregas()->count();

        $tareasPendientes = $curso ? $curso->tareas()
            ->whereDoesntHave('entregas', fn($q) => $q->where('user_id', $user->id))
            ->where(fn($q) => $q->whereNull('fecha_limite')->orWhere('fecha_limite', '>=', now()))
            ->with('materia')
            ->get() : collect();

        return view('dashboard.estudiante', compact('user', 'curso', 'totalTareas', 'totalEntregas', 'tareasPendientes'));
    }
}
