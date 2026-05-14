<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Welcome --}}
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <flux:heading size="xl">Panel de Administrador</flux:heading>
                <flux:text class="mt-0.5">Bienvenido de vuelta, <strong>{{ auth()->user()->name }}</strong>.</flux:text>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-zinc-400"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Total Usuarios</p>
                        <p class="mt-1 text-3xl font-bold">{{ $totalUsuarios }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-700">
                        <svg class="h-5 w-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    </div>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-blue-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Estudiantes</p>
                        <p class="mt-1 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalEstudiantes }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-green-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Profesores</p>
                        <p class="mt-1 text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalProfesores }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 dark:bg-green-900/30">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden p-5">
                <div class="absolute inset-y-0 left-0 w-1 rounded-l-xl bg-purple-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Cursos Activos</p>
                        <p class="mt-1 text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalCursos }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
            </flux:card>

        </div>

        {{-- Accesos rápidos + Últimos usuarios --}}
        <div class="grid gap-6 lg:grid-cols-4">

            {{-- Accesos rápidos --}}
            <div class="flex flex-col gap-3">
                <flux:heading size="base" class="text-zinc-500 uppercase tracking-wide text-xs font-semibold">Accesos rápidos</flux:heading>
                <flux:card class="flex flex-col divide-y divide-zinc-100 p-0 dark:divide-zinc-700 overflow-hidden">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition" wire:navigate>
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                            <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        Crear usuario
                    </a>
                    <a href="{{ route('admin.cursos.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition" wire:navigate>
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                            <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        Crear curso
                    </a>
                    <a href="{{ route('profesor.cursos') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition" wire:navigate>
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 dark:bg-green-900/30">
                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        Gestionar tareas
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition" wire:navigate>
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/30">
                            <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        Roles y permisos
                    </a>
                </flux:card>
            </div>

            {{-- Últimos usuarios --}}
            <div class="lg:col-span-3 flex flex-col gap-3">
                <flux:heading size="base" class="text-zinc-500 uppercase tracking-wide text-xs font-semibold">Últimos usuarios registrados</flux:heading>
                <flux:card class="p-0 overflow-hidden flex-1">
                    <table class="w-full text-sm">
                        <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-3 text-start font-medium text-zinc-500">Nombre</th>
                                <th class="px-4 py-3 text-start font-medium text-zinc-500">Rol</th>
                                <th class="px-4 py-3 text-start font-medium text-zinc-500">Registro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ($ultimosUsuarios as $u)
                                <tr class="hover:bg-zinc-200/60 dark:hover:bg-zinc-700/60 transition">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <flux:avatar :name="$u->name" :initials="$u->initials()" size="sm" />
                                            <div>
                                                <p class="font-medium leading-tight">{{ $u->name }}</p>
                                                <p class="text-xs text-zinc-400">{{ $u->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @foreach ($u->roles as $role)
                                            @php
                                                $color = match($role->name) {
                                                    'admin' => 'red',
                                                    'profesor' => 'green',
                                                    'estudiante' => 'blue',
                                                    default => 'zinc'
                                                };
                                            @endphp
                                            <flux:badge size="sm" color="{{ $color }}">{{ $role->name }}</flux:badge>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-3 text-zinc-400 text-xs">{{ $u->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="border-t border-zinc-100 dark:border-zinc-700 px-4 py-3">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>
                            Ver todos los usuarios →
                        </a>
                    </div>
                </flux:card>
            </div>

        </div>
    </div>
</x-layouts::app>
