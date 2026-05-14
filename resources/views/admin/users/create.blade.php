<x-layouts::app :title="__('Crear Usuario')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('admin.users.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <div>
                <flux:heading size="xl">{{ __('Crear Usuario') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Registra un nuevo usuario en el sistema.') }}</flux:text>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-2xl">
            @csrf

            <flux:card class="flex flex-col gap-6">

                {{-- Nombre --}}
                <flux:field>
                    <flux:label for="name">{{ __('Nombre completo') }}</flux:label>
                    <flux:input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Juan Pérez"
                        value="{{ old('name') }}"
                        autofocus
                    />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Correo --}}
                <flux:field>
                    <flux:label for="email">{{ __('Correo electrónico') }}</flux:label>
                    <flux:input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="juan@example.com"
                        value="{{ old('email') }}"
                    />
                    @error('email')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Contraseña --}}
                <flux:field>
                    <flux:label for="password">{{ __('Contraseña') }}</flux:label>
                    <flux:input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Confirmar contraseña --}}
                <flux:field>
                    <flux:label for="password_confirmation">{{ __('Confirmar contraseña') }}</flux:label>
                    <flux:input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="••••••••"
                    />
                </flux:field>

                {{-- Roles --}}
                <flux:field>
                    <flux:label>{{ __('Roles') }}</flux:label>
                    <flux:text class="mb-3 text-sm">{{ __('Asigna uno o más roles al usuario.') }}</flux:text>

                    @if ($roles->isNotEmpty())
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($roles as $role)
                                <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-200/60 dark:border-zinc-700 dark:hover:bg-zinc-700">
                                    <flux:checkbox
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        :checked="in_array($role->id, old('roles', []))"
                                    />
                                    <span class="text-sm">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <flux:text class="text-zinc-400">{{ __('No hay roles disponibles.') }}</flux:text>
                    @endif

                    @error('roles')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                {{-- Cursos (solo para profesores) --}}
                @if ($cursos->isNotEmpty())
                <flux:field>
                    <flux:label>{{ __('Cursos asignados') }}</flux:label>
                    <flux:text class="mb-3 text-sm">{{ __('Selecciona los cursos que impartirá este profesor.') }}</flux:text>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($cursos as $curso)
                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-200/60 dark:border-zinc-700 dark:hover:bg-zinc-700">
                                <flux:checkbox
                                    name="cursos[]"
                                    value="{{ $curso->id }}"
                                    :checked="in_array($curso->id, old('cursos', []))"
                                />
                                <span class="text-sm">{{ $curso->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('cursos')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>
                @endif

                {{-- Materias (solo para profesores) --}}
                @if ($materias->isNotEmpty())
                <flux:field>
                    <flux:label>{{ __('Materias asignadas') }}</flux:label>
                    <flux:text class="mb-3 text-sm">{{ __('Selecciona las materias que impartirá este profesor.') }}</flux:text>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($materias as $materia)
                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-200/60 dark:border-zinc-700 dark:hover:bg-zinc-700">
                                <flux:checkbox
                                    name="materias[]"
                                    value="{{ $materia->id }}"
                                    :checked="in_array($materia->id, old('materias', []))"
                                />
                                <span class="text-sm">{{ $materia->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('materias')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>
                @endif

                {{-- Actions --}}
                <div class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.users.index') }}" variant="ghost" wire:navigate>
                        {{ __('Cancelar') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('Guardar Usuario') }}
                    </flux:button>
                </div>

            </flux:card>
        </form>

    </div>
</x-layouts::app>
