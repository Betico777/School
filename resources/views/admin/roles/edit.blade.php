<x-layouts::app :title="__('Editar Rol')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.roles.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">{{ __('Editar Rol') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Modifica el rol') }} <strong>{{ $role->name }}</strong>.</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-2xl">
            @csrf
            @method('PUT')

            <flux:card class="flex flex-col gap-6">

                {{-- Nombre --}}
                <flux:field>
                    <flux:label for="name">{{ __('Nombre del Rol') }}</flux:label>
                    <flux:input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="ej. administrador"
                        value="{{ old('name', $role->name) }}"
                        autofocus
                    />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Permisos --}}
                <flux:field>
                    <flux:label>{{ __('Permisos') }}</flux:label>
                    <flux:text class="mb-3 text-sm">{{ __('Selecciona los permisos que tendrá este rol.') }}</flux:text>

                    @if ($permissions->isNotEmpty())
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($permissions as $permission)
                                <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-200/60 dark:border-zinc-700 dark:hover:bg-zinc-700">
                                    <flux:checkbox
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        :checked="in_array($permission->id, old('permissions', $rolePermissions))"
                                    />
                                    <span class="text-sm">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <flux:text class="text-zinc-400">{{ __('No hay permisos disponibles.') }}</flux:text>
                    @endif

                    @error('permissions')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.roles.index') }}" variant="ghost" wire:navigate>
                        {{ __('Cancelar') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('Actualizar Rol') }}
                    </flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
