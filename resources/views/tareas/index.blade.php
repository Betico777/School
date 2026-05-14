<x-layouts::app :title="'Tareas - ' . $curso->nombre">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('profesor.curso.show', $curso) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div class="flex-1">
                <flux:heading size="xl">Tareas — {{ $curso->nombre }}</flux:heading>
                <flux:text class="mt-1">Gestiona las tareas asignadas a este curso.</flux:text>
            </div>
            <flux:button href="{{ route('tareas.create', $curso) }}" variant="primary" icon="plus" wire:navigate>
                Nueva Tarea
            </flux:button>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif

        @if ($tareas->isEmpty())
            <flux:card class="p-8 text-center">
                <flux:text>No hay tareas creadas para este curso.</flux:text>
            </flux:card>
        @else
            <div class="flex flex-col gap-4">
                @foreach ($tareas as $tarea)
                    <flux:card x-data="{ open: false }" class="flex flex-col gap-0 p-0 overflow-hidden">

                        {{-- Cabecera de la tarea --}}
                        <div class="flex items-center justify-between px-5 py-6 cursor-pointer select-none hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60" @click="open = !open">
                            <div class="flex items-center gap-3">
                                <svg :class="open ? 'rotate-90' : ''" class="h-3.5 w-3.5 text-zinc-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-sm">{{ $tarea->titulo }}</p>
                                        @if ($tarea->materia)
                                            <flux:badge color="purple" size="sm">{{ $tarea->materia->nombre }}</flux:badge>
                                        @endif
                                        @if ($tarea->fecha_limite)
                                            <flux:badge color="{{ $tarea->vencida() ? 'red' : 'amber' }}" size="sm">
                                                Límite: {{ $tarea->fecha_limite->format('d/m/Y H:i') }}
                                            </flux:badge>
                                        @endif
                                    </div>
                                    <p class="text-xs text-zinc-500 mt-0.5">Creada por {{ $tarea->creadoPor->name }} · {{ $tarea->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3" @click.stop>
                                <flux:badge color="blue" size="sm">{{ $tarea->entregas->count() }} entrega(s)</flux:badge>
                                <form method="POST" action="{{ route('tareas.destroy', [$curso, $tarea]) }}" onsubmit="return confirm('¿Eliminar esta tarea?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="danger" size="xs" icon="trash" />
                                </form>
                            </div>
                        </div>

                        {{-- Detalle expandible --}}
                        <div x-show="open" class="border-t border-zinc-200 dark:border-zinc-700 px-5 py-4 bg-zinc-100 dark:bg-zinc-800" style="display:none">
                            @if ($tarea->descripcion)
                                <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-4 mt-1">{{ $tarea->descripcion }}</p>
                            @endif

                            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 mb-2">Estudiantes que entregaron:</p>
                            @if ($tarea->entregas->isEmpty())
                                <p class="text-sm text-zinc-400">Ningún estudiante ha entregado aún.</p>
                            @else
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-xs text-zinc-500 border-b border-zinc-200 dark:border-zinc-700">
                                            <th class="pb-2 text-left font-medium">Estudiante</th>
                                            <th class="pb-2 text-left font-medium">Hora de entrega</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700/50">
                                        @foreach ($tarea->entregas as $entrega)
                                            <tr>
                                                <td class="py-2 font-medium">{{ $entrega->estudiante->name }}</td>
                                                <td class="py-2 text-zinc-500">{{ $entrega->entregado_at->format('d/m/Y \a \l\a\s H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                    </flux:card>
                @endforeach
            </div>
        @endif

    </div>
</x-layouts::app>
