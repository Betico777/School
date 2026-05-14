<x-layouts::app :title="__('Materias')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Materias</flux:heading>
                <flux:text class="mt-1">Administra las materias del sistema.</flux:text>
            </div>
            <flux:button href="{{ route('admin.materias.create') }}" icon="plus" variant="primary" wire:navigate>
                Nueva Materia
            </flux:button>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif

        <flux:card class="p-0 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">Nombre</th>
                        <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">Descripción</th>
                        <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">Tareas</th>
                        <th class="px-4 py-3 text-end font-medium text-zinc-600 dark:text-zinc-400">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse ($materias as $materia)
                        <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                            <td class="px-4 py-3 font-medium">{{ $materia->nombre }}</td>
                            <td class="px-4 py-3 text-zinc-500">{{ $materia->descripcion ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <flux:badge size="sm" color="blue" variant="outline">{{ $materia->tareas_count }}</flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('admin.materias.edit', $materia) }}" size="sm" variant="ghost" icon="pencil" wire:navigate>
                                        Editar
                                    </flux:button>
                                    <form method="POST" action="{{ route('admin.materias.destroy', $materia) }}"
                                          onsubmit="return confirm('¿Eliminar la materia {{ addslashes($materia->nombre) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500 hover:text-red-600">
                                            Eliminar
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-zinc-400">
                                No hay materias registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($materias->hasPages())
                <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                    {{ $materias->links() }}
                </div>
            @endif
        </flux:card>

    </div>
</x-layouts::app>
