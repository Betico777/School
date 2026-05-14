<x-layouts::app :title="__('Usuarios')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Usuarios') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Administra los usuarios del sistema.') }}</flux:text>
            </div>
            <flux:button href="{{ route('admin.users.create') }}" icon="plus" variant="primary" wire:navigate>
                {{ __('Nuevo Usuario') }}
            </flux:button>
        </div>

        {{-- Búsqueda y filtros --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-48">
                <flux:input name="search" placeholder="Buscar por nombre o correo..." value="{{ $search }}" icon="magnifying-glass" />
            </div>
            <div>
                <select name="rol" class="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-sm px-3 py-2 text-zinc-700 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r->name }}" @selected($rol === $r->name)>{{ ucfirst($r->name) }}</option>
                    @endforeach
                </select>
            </div>
            <flux:button type="submit" variant="primary" size="sm">Filtrar</flux:button>
            @if ($search || $rol)
                <flux:button href="{{ route('admin.users.index') }}" variant="ghost" size="sm" wire:navigate>Limpiar</flux:button>
            @endif
        </form>

        {{-- Flash messages --}}
        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif
        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle">
                <flux:callout.heading>{{ session('error') }}</flux:callout.heading>
            </flux:callout>
        @endif

        {{-- Table --}}
        <flux:card class="p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Nombre') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Correo') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Roles') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Materias') }}</th>
                            <th class="px-4 py-3 text-start font-medium text-zinc-600 dark:text-zinc-400">{{ __('Registrado') }}</th>
                            <th class="px-4 py-3 text-end font-medium text-zinc-600 dark:text-zinc-400">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($users as $user)
                            <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <flux:avatar name="{{ $user->name }}" :initials="$user->initials()" size="sm" />
                                        <span class="font-medium">{{ $user->name }}</span>
                                        @if ($user->id === auth()->id())
                                            <flux:badge size="sm" color="blue">{{ __('Tú') }}</flux:badge>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse ($user->roles as $role)
                                            <flux:badge size="sm" variant="outline" color="zinc">{{ $role->name }}</flux:badge>
                                        @empty
                                            <span class="text-zinc-400">{{ __('Sin roles') }}</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($user->hasRole('profesor') && $user->materiasComoProfesor->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->materiasComoProfesor as $materia)
                                                <flux:badge size="sm" color="purple">{{ $materia->nombre }}</flux:badge>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-zinc-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <flux:button href="{{ route('admin.users.edit', $user) }}" size="sm" variant="ghost" icon="pencil" wire:navigate>
                                            {{ __('Editar') }}
                                        </flux:button>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar a {{ addslashes($user->name) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500 hover:text-red-600">
                                                    {{ __('Eliminar') }}
                                                </flux:button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-zinc-400">
                                    {{ __('No hay usuarios registrados.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                    {{ $users->links() }}
                </div>
            @endif
        </flux:card>

    </div>
</x-layouts::app>
