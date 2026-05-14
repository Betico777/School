<x-layouts::app :title="__('Cursos')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Cursos / Grados') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Administra los cursos disponibles para los estudiantes.') }}</flux:text>
            </div>
            <flux:button href="{{ route('admin.cursos.create') }}" icon="plus" variant="primary" wire:navigate>
                {{ __('Nuevo Curso') }}
            </flux:button>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">{{ session('success') }}</flux:callout>
        @endif

        <flux:card class="p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Nombre') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Descripción') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Estudiantes') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Estado') }}</th>
                            <th class="px-4 py-3 text-end font-medium text-zinc-600 dark:text-zinc-400">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($cursos as $curso)
                            <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                                <td class="px-4 py-3 font-medium">{{ $curso->nombre }}</td>
                                <td class="px-4 py-3 text-zinc-500">{{ $curso->descripcion ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" color="blue" variant="outline">{{ $curso->estudiantes_count }}</flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($curso->activo)
                                        <flux:badge size="sm" color="green">{{ __('Activo') }}</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="red">{{ __('Inactivo') }}</flux:badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <flux:button href="{{ route('admin.cursos.edit', $curso) }}" size="sm" variant="ghost" icon="pencil" wire:navigate>
                                            {{ __('Editar') }}
                                        </flux:button>
                                        <form method="POST" action="{{ route('admin.cursos.destroy', $curso) }}"
                                              onsubmit="return confirm('¿Eliminar el curso {{ addslashes($curso->nombre) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500 hover:text-red-600">
                                                {{ __('Eliminar') }}
                                            </flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-zinc-400">
                                    {{ __('No hay cursos registrados.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($cursos->hasPages())
                <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                    {{ $cursos->links() }}
                </div>
            @endif
        </flux:card>

    </div>
</x-layouts::app>
