<x-layouts::app title="Mis Tareas">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <flux:heading size="xl">Mis Tareas</flux:heading>
                @if ($curso)
                    <flux:text class="mt-0.5">Curso: <strong>{{ $curso->nombre }}</strong></flux:text>
                @endif
            </div>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif

        @if (! $curso)
            <flux:card class="p-10 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700">
                    <svg class="h-7 w-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <flux:heading size="base">Sin curso asignado</flux:heading>
                <flux:text class="mt-1 text-sm">No tienes un curso asignado todavía.</flux:text>
            </flux:card>
        @elseif ($tareas->isEmpty())
            <flux:card class="p-10 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700">
                    <svg class="h-7 w-7 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                </div>
                <flux:heading size="base">Sin tareas aún</flux:heading>
                <flux:text class="mt-1 text-sm">Tu profesor no ha asignado tareas todavía.</flux:text>
            </flux:card>
        @else
            {{-- Progress bar --}}
            @php
                $entregadas = $tareas->filter(fn($t) => $t->entregas->isNotEmpty())->count();
                $total = $tareas->count();
                $pct = $total > 0 ? round(($entregadas / $total) * 100) : 0;
            @endphp
            <flux:card class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium">Progreso de entrega</p>
                    <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-300">{{ $entregadas }} / {{ $total }}</p>
                </div>
                <div class="h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-700">
                    <div class="h-2 rounded-full bg-green-500 transition-all" style="width: {{ $pct }}%"></div>
                </div>
                <p class="mt-1 text-xs text-zinc-400">{{ $pct }}% completado</p>
            </flux:card>

            <div class="flex flex-col gap-4">
                @foreach ($tareas as $tarea)
                    @php $entrega = $tarea->entregas->first(); @endphp
                    <flux:card class="flex flex-col gap-0 p-0 overflow-hidden {{ $entrega ? 'border-l-4 border-l-green-500' : ($tarea->vencida() ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-amber-400') }}">
                        <div class="flex items-start justify-between gap-6 px-8 py-6 ml-1">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-3">
                                    @if ($entrega)
                                        <flux:badge color="green" size="sm" icon="check">Entregada</flux:badge>
                                    @elseif ($tarea->vencida())
                                        <flux:badge color="red" size="sm">Vencida</flux:badge>
                                    @else
                                        <flux:badge color="yellow" size="sm">Pendiente</flux:badge>
                                    @endif
                                    @if ($tarea->materia)
                                        <flux:badge color="purple" size="sm">{{ $tarea->materia->nombre }}</flux:badge>
                                    @endif
                                </div>
                                <p class="font-semibold text-lg">{{ $tarea->titulo }}</p>
                                @if ($tarea->descripcion)
                                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ $tarea->descripcion }}</p>
                                @endif
                                <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-zinc-400">
                                    <span>Asignada el {{ $tarea->created_at->format('d/m/Y') }}</span>
                                    @if ($tarea->fecha_limite)
                                        <span class="{{ $tarea->vencida() ? 'text-red-500 font-medium' : 'text-amber-600' }}">
                                            Límite: {{ $tarea->fecha_limite->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="shrink-0 flex flex-col items-end justify-between gap-4 self-stretch py-1">
                                @if ($entrega)
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <p class="text-xs text-zinc-400">{{ $entrega->entregado_at->format('d/m H:i') }}</p>
                                @else
                                    @if ($tarea->vencida())
                                        <flux:button type="button" variant="ghost" size="sm" disabled class="opacity-50 cursor-not-allowed">
                                            Plazo vencido
                                        </flux:button>
                                    @else
                                        <form method="POST" action="{{ route('tareas.entregar', $tarea) }}">
                                            @csrf
                                            <flux:button type="submit" variant="primary" size="sm">
                                                Marcar entregada
                                            </flux:button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </flux:card>
                @endforeach
            </div>
        @endif

    </div>
</x-layouts::app>
