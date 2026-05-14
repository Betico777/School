<x-layouts::app :title="__('Mi Panel')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-8">

        {{-- Welcome --}}
        <div class="flex items-center gap-4">
            <flux:avatar :name="$user->name" :initials="$user->initials()" size="lg" />
            <div>
                <flux:heading size="xl">Bienvenido, {{ $user->name }}</flux:heading>
                <flux:text class="mt-0.5">
                    @if ($user->curso)
                        Curso: <strong>{{ $user->curso->nombre }}</strong>
                    @else
                        Sin curso asignado
                    @endif
                </flux:text>
            </div>
        </div>

        {{-- Alerta tareas pendientes --}}
        @if ($tareasPendientes->isNotEmpty())
        <flux:callout variant="warning" icon="exclamation-triangle">
            <flux:callout.heading>Tienes {{ $tareasPendientes->count() }} tarea(s) pendiente(s)</flux:callout.heading>
            <flux:callout.text>
                @foreach ($tareasPendientes as $t)
                    <span class="block">• {{ $t->titulo }}@if($t->materia) <span class="text-purple-600 dark:text-purple-400">({{ $t->materia->nombre }})</span>@endif@if($t->fecha_limite) — vence el {{ $t->fecha_limite->format('d/m/Y H:i') }}@endif</span>
                @endforeach
            </flux:callout.text>
        </flux:callout>
        @endif

        {{-- Contenido principal en dos columnas --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Columna izquierda: stats + acciones --}}
            <div class="flex flex-col gap-6 lg:col-span-2">

                {{-- Mini stats --}}
                <div class="grid grid-cols-2 gap-4">
                    <flux:card class="relative overflow-hidden p-6">
                        <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-blue-500"></div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Tareas del curso</p>
                        <p class="mt-2 text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $totalTareas }}</p>
                    </flux:card>
                    <flux:card class="relative overflow-hidden p-6">
                        <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-green-500"></div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Entregadas</p>
                        <p class="mt-2 text-4xl font-bold text-green-600 dark:text-green-400">{{ $totalEntregas }}</p>
                    </flux:card>
                </div>

                {{-- Acciones --}}
                <flux:card class="flex flex-col gap-4 p-6">
                    <flux:heading size="base">Acciones rápidas</flux:heading>
                    <div class="flex flex-wrap gap-3">
                        <flux:button href="{{ route('estudiante.tareas') }}" variant="primary" icon="clipboard-document-list" wire:navigate>
                            Ver mis tareas
                        </flux:button>
                        <flux:button href="{{ route('profile.edit') }}" variant="ghost" icon="pencil" wire:navigate>
                            Editar perfil
                        </flux:button>
                    </div>
                </flux:card>

            </div>

            {{-- Columna derecha: info de cuenta --}}
            <flux:card class="flex flex-col gap-5 p-6">
                <flux:heading size="base">Información de mi cuenta</flux:heading>
                <flux:separator />
                <div class="flex flex-col gap-5 text-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Correo</p>
                        <p class="mt-1 break-all">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Rol</p>
                        <div class="mt-1 flex flex-wrap gap-1">
                            @foreach ($user->roles as $role)
                                <flux:badge size="sm" color="blue">{{ $role->name }}</flux:badge>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Curso</p>
                        <p class="mt-1 font-semibold">{{ $user->curso?->nombre ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Miembro desde</p>
                        <p class="mt-1">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </flux:card>

        </div>

    </div>
</x-layouts::app>

