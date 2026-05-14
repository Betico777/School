<?php

use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\ProfesorCursoController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // Admin only
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
        Route::resource('cursos', CursoController::class)->except(['show']);            Route::resource('materias', MateriaController::class)->except(['show']);    });

    // Tareas — admin o profesor
    Route::middleware('role:admin|profesor')->group(function () {
        Route::get('cursos/{curso}/tareas', [TareaController::class, 'index'])->name('tareas.index');
        Route::get('cursos/{curso}/tareas/crear', [TareaController::class, 'create'])->name('tareas.create');
        Route::post('cursos/{curso}/tareas', [TareaController::class, 'store'])->name('tareas.store');
        Route::delete('cursos/{curso}/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
    });

    // Vista de curso para profesor: ver estudiantes + tareas
    Route::middleware('role:admin|profesor')->get('mis-cursos/{curso}/estudiantes', [ProfesorCursoController::class, 'estudiantes'])->name('profesor.curso.estudiantes');
    Route::middleware('role:admin|profesor')->get('mis-cursos/{curso}', [ProfesorCursoController::class, 'show'])->name('profesor.curso.show');
    Route::middleware('role:admin|profesor')->get('mis-cursos', [ProfesorCursoController::class, 'index'])->name('profesor.cursos');

    // Entregas — estudiante
    Route::middleware('role:estudiante')->post('tareas/{tarea}/entregar', [EntregaController::class, 'store'])->name('tareas.entregar');

    // Estudiante: ver tareas de su curso
    Route::middleware('role:estudiante')->get('mis-tareas', [App\Http\Controllers\EstudianteTareasController::class, 'index'])->name('estudiante.tareas');
});

require __DIR__.'/settings.php';
