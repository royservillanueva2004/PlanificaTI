@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">📊 Resultado de Estrategias</h1>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <table class="w-full text-sm text-center table-fixed border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm">
                    <th class="py-2 px-4">Relaciones</th>
                    <th class="py-2 px-4">Tipología de Estrategia</th>
                    <th class="py-2 px-4">Puntuación</th>
                    <th class="py-2 px-4">Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estrategias as $clave => $datos)
                    <tr class="{{ $clave == array_search($estrategiaDominante, $estrategias) ? 'bg-blue-50 font-semibold' : '' }}">
                        <td class="border py-2 px-4">{{ $clave }}</td>
                        <td class="border py-2 px-4">{{ $datos['tipo'] }}</td>
                        <td class="border py-2 px-4">{{ $datos['puntaje'] }}</td>
                        <td class="border py-2 px-4 text-left">{{ $datos['descripcion'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center mt-8">
        <h2 class="text-xl font-bold text-green-700 mb-2">✅ Estrategia Recomendada</h2>
        <p class="text-gray-800 text-lg">
            <strong>{{ $estrategiaDominante['tipo'] }}</strong>: {{ $estrategiaDominante['descripcion'] }}
        </p>
    </div>
</div>
@endsection
