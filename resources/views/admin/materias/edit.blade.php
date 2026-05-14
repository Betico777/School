<x-layouts::app :title="__('Editar Materia')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.materias.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">Editar Materia</flux:heading>
                <flux:text class="mt-1">Modifica <strong>{{ $materia->nombre }}</strong>.</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.materias.update', $materia) }}" class="max-w-lg">
            @csrf
            @method('PUT')
            <flux:card class="flex flex-col gap-6">

                <flux:field>
                    <flux:label for="nombre">Nombre</flux:label>
                    <flux:input id="nombre" name="nombre" type="text" value="{{ old('nombre', $materia->nombre) }}" autofocus />
                    @error('nombre') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label for="descripcion">Descripción <span class="text-zinc-400">(opcional)</span></flux:label>
                    <flux:input id="descripcion" name="descripcion" type="text" value="{{ old('descripcion', $materia->descripcion) }}" />
                    @error('descripcion') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.materias.index') }}" variant="ghost" wire:navigate>Cancelar</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">Actualizar</flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
