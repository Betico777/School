<x-layouts::app :title="$curso->nombre">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('profesor.cursos') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div class="flex-1">
                <flux:heading size="xl">{{ $curso->nombre }}</flux:heading>
                @if ($curso->descripcion)
                    <flux:text class="mt-1">{{ $curso->descripcion }}</flux:text>
                @endif
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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            {{-- Estudiantes --}}
            <flux:card class="p-0 overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <flux:heading size="base">Estudiantes ({{ $estudiantes->count() }})</flux:heading>
                    <flux:button href="{{ route('profesor.curso.estudiantes', $curso) }}" variant="ghost" size="sm" wire:navigate>Ver todos</flux:button>
                </div>
                @if ($estudiantes->isEmpty())
                    <p class="px-5 py-4 text-sm text-zinc-500">No hay estudiantes inscritos en este curso.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Nombre</th>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Entregas</th>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Correo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ($estudiantes as $est)
                                @php
                                    $entregadas = $tareas->filter(fn($t) => $t->entregas->contains('user_id', $est->id))->count();
                                @endphp
                                <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60">
                                    <td class="px-4 py-3 font-medium">{{ $est->name }}</td>
                                    <td class="px-4 py-3">
                                        <flux:badge color="blue" size="sm">{{ $entregadas }} / {{ $tareas->count() }}</flux:badge>
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500">{{ $est->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </flux:card>

            {{-- Tareas --}}
            <flux:card class="p-0 overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <flux:heading size="base">Tareas ({{ $tareas->count() }})</flux:heading>
                    <flux:button href="{{ route('tareas.index', $curso) }}" variant="ghost" size="sm" wire:navigate>Ver todas</flux:button>
                </div>
                @if ($tareas->isEmpty())
                    <p class="px-5 py-4 text-sm text-zinc-500">No hay tareas asignadas aún.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Título</th>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Entregas</th>
                                <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Creada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ($tareas as $tarea)
                                <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60">
                                    <td class="px-4 py-3 font-medium">{{ $tarea->titulo }}</td>
                                    <td class="px-4 py-3">
                                        <flux:badge color="blue" size="sm">{{ $tarea->entregas->count() }} / {{ $estudiantes->count() }}</flux:badge>
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500">{{ $tarea->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </flux:card>

        </div>
    </div>
</x-layouts::app>
