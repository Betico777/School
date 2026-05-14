<x-layouts::app :title="__('Crear Curso')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.cursos.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">{{ __('Crear Curso') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Agrega un nuevo curso o grado al sistema.') }}</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.cursos.store') }}" class="max-w-lg">
            @csrf

            <flux:card class="flex flex-col gap-6">

                <flux:field>
                    <flux:label for="nombre">{{ __('Nombre del Curso') }}</flux:label>
                    <flux:input id="nombre" name="nombre" type="text" placeholder="ej. 3er Grado" value="{{ old('nombre') }}" autofocus />
                    @error('nombre') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label for="descripcion">{{ __('Descripción') }} <span class="text-zinc-400">(opcional)</span></flux:label>
                    <flux:input id="descripcion" name="descripcion" type="text" placeholder="ej. Turno matutino" value="{{ old('descripcion') }}" />
                    @error('descripcion') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <div class="flex items-center gap-3">
                        <flux:checkbox id="activo" name="activo" value="1" :checked="old('activo', true)" />
                        <flux:label for="activo">{{ __('Curso activo') }}</flux:label>
                    </div>
                </flux:field>

                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.cursos.index') }}" variant="ghost" wire:navigate>{{ __('Cancelar') }}</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">{{ __('Guardar Curso') }}</flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
