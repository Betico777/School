<x-layouts::app :title="'Cursos'">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Mis Cursos</flux:heading>
                <flux:text class="mt-1">Cursos asignados para gestionar.</flux:text>
            </div>
            @if ($cursos->isNotEmpty())
                <flux:badge color="zinc" size="sm">{{ $cursos->count() }} curso(s)</flux:badge>
            @endif
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif

        @if ($cursos->isEmpty())
            <flux:card class="p-10 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700">
                    <svg class="h-7 w-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <flux:heading size="base">Sin cursos asignados</flux:heading>
                <flux:text class="mt-1 text-sm">Contacta al administrador para que te asigne cursos.</flux:text>
            </flux:card>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
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
</x-layouts::app>
