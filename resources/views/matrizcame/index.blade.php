@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📊 Matriz CAME</h1>
        <a href="{{ route('matrizcame.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
            + Nueva Acción
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach(['C' => 'Corregir', 'A' => 'Afrontar', 'M' => 'Mantener', 'E' => 'Explotar'] as $tipo => $nombre)
            <div class="bg-white border border-gray-200 rounded shadow">
                <div class="bg-gray-100 px-4 py-2 font-semibold text-lg text-gray-700 border-b">
                    {{ $nombre }}
                </div>
                <div class="p-4">
                    @php
                        $accionesFiltradas = $acciones->where('tipo', $tipo);
                    @endphp

                    @if($accionesFiltradas->isEmpty())
                        <p class="text-sm text-gray-500">No hay acciones registradas.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($accionesFiltradas as $accion)
                                <li class="flex justify-between items-center bg-gray-50 p-3 rounded border border-gray-200">
                                    <span class="text-gray-800 text-sm">{{ $accion->accion }}</span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('matrizcame.edit', $accion->id) }}"
                                           class="text-blue-600 hover:underline text-sm">Editar</a>
                                        <form action="{{ route('matrizcame.destroy', $accion->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta acción?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:underline text-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
