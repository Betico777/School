<x-layouts::app :title="__('Permisos')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Permisos') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Administra los permisos del sistema.') }}</flux:text>
            </div>
            <flux:button href="{{ route('admin.permissions.create') }}" icon="plus" variant="primary" wire:navigate>
                {{ __('Nuevo Permiso') }}
            </flux:button>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('success') }}
            </flux:callout>
        @endif

        {{-- Table --}}
        <flux:card class="p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Nombre') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Guard') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Creado') }}</th>
                            <th class="px-4 py-3 text-end font-medium text-zinc-600 dark:text-zinc-400">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($permissions as $permission)
                            <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                                <td class="px-4 py-3 font-medium">{{ $permission->name }}</td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" variant="outline" color="zinc">{{ $permission->guard_name }}</flux:badge>
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $permission->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <flux:button href="{{ route('admin.permissions.edit', $permission) }}" size="sm" variant="ghost" icon="pencil" wire:navigate>
                                            {{ __('Editar') }}
                                        </flux:button>
                                        <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este permiso?')">
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
                                <td colspan="4" class="px-4 py-10 text-center text-zinc-400">
                                    {{ __('No hay permisos registrados.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($permissions->hasPages())
                <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                    {{ $permissions->links() }}
                </div>
            @endif
        </flux:card>

    </div>
</x-layouts::app>
