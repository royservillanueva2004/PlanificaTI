@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">📊 Matriz CAME</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 4 COLUMNAS PARA CAME --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ([
            'C' => ['label' => '🛠 Corregir', 'color' => 'yellow'],
            'A' => ['label' => '⚔️ Afrontar', 'color' => 'red'],
            'M' => ['label' => '🛡 Mantener', 'color' => 'blue'],
            'E' => ['label' => '🚀 Explotar', 'color' => 'green'],
        ] as $tipo => $info)
            <div class="bg-white border border-gray-200 rounded shadow">
                <div class="bg-{{ $info['color'] }}-100 px-4 py-2 font-semibold text-lg text-{{ $info['color'] }}-800 border-b">
                    {{ $info['label'] }}
                </div>

                <div class="p-4 space-y-3">
                    {{-- FORMULARIO para cada tipo --}}
                    <form action="{{ route('matrizcame.store') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <input type="text" name="accion" placeholder="Nueva acción..." required
                               class="flex-1 border rounded px-3 py-2 text-sm">
                        <button type="submit"
                                class="bg-{{ $info['color'] }}-600 hover:bg-{{ $info['color'] }}-700 text-white text-sm px-4 py-2 rounded">
                            +
                        </button>
                    </form>

                    {{-- LISTADO de acciones --}}
                    @php
                        $accionesFiltradas = $acciones->where('tipo', $tipo);
                    @endphp

                    @forelse($accionesFiltradas as $accion)
                        @if(isset($editar) && $editar->id === $accion->id)
                            {{-- FORMULARIO DE EDICIÓN EN LÍNEA --}}
                            <form action="{{ route('matrizcame.update', $accion->id) }}" method="POST" class="flex gap-2 items-center border px-3 py-2 rounded bg-yellow-50">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipo" value="{{ $accion->tipo }}">
                                <input type="text" name="accion" value="{{ old('accion', $accion->accion) }}" class="flex-1 border rounded px-3 py-1 text-sm" required>
                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm px-3 py-1 rounded">Guardar</button>
                                <a href="{{ route('matrizcame.index') }}" class="text-sm text-gray-500 hover:underline">Cancelar</a>
                            </form>
                        @else
                            {{-- MODO LECTURA --}}
                            <div class="flex justify-between items-center border px-3 py-2 rounded bg-gray-50">
                                <span class="text-sm text-gray-800">{{ $accion->accion }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('matrizcame.index', ['editar' => $accion->id]) }}" class="text-blue-600 text-sm hover:underline">Editar</a>
                                    <form action="{{ route('matrizcame.destroy', $accion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta acción?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-sm hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-sm text-gray-500">No hay acciones registradas.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
