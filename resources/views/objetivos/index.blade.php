@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">🎯 Objetivos Estratégicos</h1>
        <a href="{{ route('objetivos.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
            + Nuevo Objetivo
        </a>
    </div>

    @if ($generales->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
            No hay objetivos estratégicos registrados aún.
        </div>
    @endif

    @foreach($generales as $general)
        <div class="bg-white shadow rounded-lg mb-4 p-4 border border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-semibold text-lg text-gray-900">🧭 {{ $general->descripcion }}</h2>
                <a href="{{ route('objetivos.edit', $general->id) }}"
                   class="text-blue-600 hover:underline text-sm">
                    ✏️ Editar
                </a>
            </div>

            @if ($general->especificos->isNotEmpty())
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($general->especificos as $especifico)
                        <li>{{ $especifico->descripcion }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">Sin objetivos específicos registrados.</p>
            @endif
        </div>
    @endforeach
</div>
@endsection