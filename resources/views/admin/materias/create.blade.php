<x-layouts::app :title="__('Nueva Materia')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.materias.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">Nueva Materia</flux:heading>
                <flux:text class="mt-1">Crea una nueva materia para asignar a profesores y tareas.</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.materias.store') }}" class="max-w-lg">
            @csrf
            <flux:card class="flex flex-col gap-6">

                <flux:field>
                    <flux:label for="nombre">Nombre</flux:label>
                    <flux:input id="nombre" name="nombre" type="text" placeholder="Ej: Matemáticas" value="{{ old('nombre') }}" autofocus />
                    @error('nombre') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label for="descripcion">Descripción <span class="text-zinc-400">(opcional)</span></flux:label>
                    <flux:input id="descripcion" name="descripcion" type="text" placeholder="Breve descripción" value="{{ old('descripcion') }}" />
                    @error('descripcion') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.materias.index') }}" variant="ghost" wire:navigate>Cancelar</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">Guardar</flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
