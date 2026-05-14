<x-layouts::app :title="'Estudiantes — ' . $curso->nombre">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('profesor.curso.show', $curso) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div class="flex-1">
                <flux:heading size="xl">Estudiantes de {{ $curso->nombre }}</flux:heading>
                <flux:text class="mt-1">Lista completa de estudiantes inscritos en este curso.</flux:text>
            </div>
            <flux:badge color="zinc" size="sm">{{ $estudiantes->count() }} estudiante(s)</flux:badge>
        </div>

        @if ($estudiantes->isEmpty())
            <flux:card class="p-10 text-center">
                <flux:heading size="base">Sin estudiantes</flux:heading>
                <flux:text class="mt-1 text-sm">No hay estudiantes inscritos en este curso todavía.</flux:text>
            </flux:card>
        @else
            <flux:card class="p-0 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">#</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Nombre</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Correo</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Registrado</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-300">Entregas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($estudiantes as $i => $est)
                            <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60">
                                <td class="px-4 py-3 text-zinc-400">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium">{{ $est->name }}</td>
                                <td class="px-4 py-3 text-zinc-500">{{ $est->email }}</td>
                                <td class="px-4 py-3 text-zinc-500">{{ $est->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <flux:badge color="blue" size="sm">
                                        {{ $est->entregas()->whereHas('tarea', fn($q) => $q->where('curso_id', $curso->id))->count() }} / {{ $totalTareas }}
                                    </flux:badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </flux:card>
        @endif

    </div>
</x-layouts::app>
