<x-layouts::app :title="__('Editar Permiso')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.permissions.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">{{ __('Editar Permiso') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Modifica el permiso') }} <strong>{{ $permission->name }}</strong>.</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="max-w-lg">
            @csrf
            @method('PUT')

            <flux:card class="flex flex-col gap-6">

                <flux:field>
                    <flux:label for="name">{{ __('Nombre del Permiso') }}</flux:label>
                    <flux:text class="mb-1 text-sm">{{ __('Usa una convención clara, ej:') }} <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">posts.crear</code>, <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">usuarios.eliminar</code></flux:text>
                    <flux:input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="ej. posts.crear"
                        value="{{ old('name', $permission->name) }}"
                        autofocus
                    />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.permissions.index') }}" variant="ghost" wire:navigate>
                        {{ __('Cancelar') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('Actualizar Permiso') }}
                    </flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
