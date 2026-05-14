<x-layouts::app :title="__('Dashboard Profesor')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Welcome --}}
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-600 text-white shadow">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <flux:heading size="xl">Panel del Profesor</flux:heading>
                <flux:text class="mt-0.5">Bienvenido, <strong>{{ auth()->user()->name }}</strong>.</flux:text>
            </div>
        </div>

        {{-- Mini stats --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-purple-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Cursos asignados</p>
                        <p class="mt-1 text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $cursos->count() }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
            </flux:card>
            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-blue-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Total estudiantes</p>
                        <p class="mt-1 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalEstudiantes }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                </div>
            </flux:card>
            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-amber-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Tareas creadas</p>
                        <p class="mt-1 text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $totalTareas }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/30">
                        <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                </div>
            </flux:card>
        </div>

        {{-- Cursos --}}
        <div>
            <div class="mb-3 flex items-center justify-between">
                <flux:heading size="base" class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Mis cursos</flux:heading>
                <flux:button href="{{ route('profesor.cursos') }}" variant="ghost" size="sm" wire:navigate>Ver todos →</flux:button>
            </div>

            @if ($cursos->isEmpty())
                <flux:card class="p-8 text-center">
                    <flux:text>No tienes cursos asignados todavía. Contacta al administrador.</flux:text>
                </flux:card>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($cursos as $curso)
                        <flux:card class="flex flex-col gap-4 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-base">{{ $curso->nombre }}</p>
                                <flux:badge color="green" size="sm">Activo</flux:badge>
                            </div>

                            <div class="flex flex-col gap-2 text-sm text-zinc-400">
                                <span class="flex items-center gap-1.5">
                                    <svg class="h-3.5 w-3.5 shrink-0 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $curso->estudiantes_count }} estudiante(s)
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="h-3.5 w-3.5 shrink-0 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    {{ $curso->tareas_count }} tarea(s)
                                </span>
                            </div>

                            <flux:separator />

                            <flux:button href="{{ route('profesor.curso.show', $curso) }}" variant="ghost" size="sm" wire:navigate class="w-full justify-center">
                                Abrir curso →
                            </flux:button>
                        </flux:card>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-layouts::app>
