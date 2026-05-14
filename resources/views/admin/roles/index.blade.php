<x-layouts::app :title="__('Roles')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Roles') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Administra los roles del sistema.') }}</flux:text>
            </div>
            <flux:button href="{{ route('admin.roles.create') }}" icon="plus" variant="primary" wire:navigate>
                {{ __('Nuevo Rol') }}
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
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Permisos') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Creado') }}</th>
                            <th class="px-4 py-3 text-end font-medium text-zinc-600 dark:text-zinc-400">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($roles as $role)
                            <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                                <td class="px-4 py-3 font-medium">{{ $role->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse ($role->permissions->take(5) as $permission)
                                            <flux:badge size="sm" variant="outline" color="zinc">{{ $permission->name }}</flux:badge>
                                        @empty
                                            <span class="text-zinc-400">{{ __('Sin permisos') }}</span>
                                        @endforelse
                                        @if ($role->permissions->count() > 5)
                                            <flux:badge size="sm" color="zinc">+{{ $role->permissions->count() - 5 }}</flux:badge>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $role->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <flux:button href="{{ route('admin.roles.edit', $role) }}" size="sm" variant="ghost" icon="pencil" wire:navigate>
                                            {{ __('Editar') }}
                                        </flux:button>
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este rol?')">
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
                                    {{ __('No hay roles registrados.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($roles->hasPages())
                <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                    {{ $roles->links() }}
                </div>
            @endif
        </flux:card>

    </div>
</x-layouts::app>
