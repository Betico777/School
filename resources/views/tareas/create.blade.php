<x-layouts::app :title="'Nueva Tarea - ' . $curso->nombre">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        <div class="flex items-center gap-3">
            <flux:button href="{{ route('tareas.index', $curso) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">Nueva Tarea</flux:heading>
                <flux:text class="mt-1">Curso: <strong>{{ $curso->nombre }}</strong></flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('tareas.store', $curso) }}" class="max-w-2xl">
            @csrf

            <flux:card class="flex flex-col gap-6">

                <flux:field>
                    <flux:label for="titulo">Título</flux:label>
                    <flux:input id="titulo" name="titulo" type="text" placeholder="Ej: Tarea de matemáticas — capítulo 3" value="{{ old('titulo') }}" autofocus />
                    @error('titulo') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label for="descripcion">Descripción</flux:label>
                    <flux:textarea id="descripcion" name="descripcion" placeholder="Instrucciones detalladas de la tarea..." rows="4">{{ old('descripcion') }}</flux:textarea>
                    @error('descripcion') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                @if ($materias->isNotEmpty())
                <flux:field>
                    <flux:label for="materia_id">Materia</flux:label>
                    <select id="materia_id" name="materia_id"
                        class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100">
                        <option value="">— Sin materia —</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}" @selected(old('materia_id') == $materia->id)>{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                    @error('materia_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
                @endif

                <flux:field>
                    <flux:label for="fecha_limite">Fecha y hora límite <span class="text-zinc-400">(opcional)</span></flux:label>
                    <flux:input id="fecha_limite" name="fecha_limite" type="datetime-local"
                        min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}"
                        value="{{ old('fecha_limite') }}" />
                    @error('fecha_limite') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('tareas.index', $curso) }}" variant="ghost" wire:navigate>Cancelar</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">Guardar Tarea</flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
