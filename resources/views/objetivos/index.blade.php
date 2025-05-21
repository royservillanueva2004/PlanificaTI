@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            📌 <span>Mis Objetivos Estratégicos</span>
        </h1>
        <a href="{{ route('objetivos.create') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow transition">
            + Nuevo Objetivo
        </a>
    </div>

    @if ($generales->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg shadow-sm">
            <p>No hay objetivos estratégicos registrados aún.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($generales as $general)
            <div class="bg-white border border-gray-200 shadow-md rounded-lg p-5 hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="font-semibold text-lg text-gray-800">
                        🧭 {{ $general->descripcion }}
                    </h2>
                    <div class="flex gap-2">
                        <a href="{{ route('objetivos.edit', $general->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded">
                             Editar
                        </a>
                        <form action="{{ route('objetivos.destroy', $general->id) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar este objetivo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                @if ($general->especificos->isNotEmpty())
                    <ul class="mt-2 space-y-1">
                        @foreach($general->especificos as $especifico)
                            <li class="bg-gray-100 px-3 py-1 rounded text-sm text-gray-700">
                                📌 {{ $especifico->descripcion }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 italic mt-2">Sin objetivos específicos registrados.</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
