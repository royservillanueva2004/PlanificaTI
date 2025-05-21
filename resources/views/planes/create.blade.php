@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10zM12 4v16m-4-4h8"/>
        </svg>
        Crear Plan Estratégico
    </h2>

    <form method="POST" action="{{ route('planes.store') }}" class="space-y-5 text-sm">
        @csrf

        <div>
            <label class="block font-medium text-gray-600 mb-1">Nombre del Plan</label>
            <input type="text" name="nombre_plan" placeholder="Ej. Plan Digital 2025"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Misión</label>
            <textarea name="mision" rows="3" placeholder="Describe la misión"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Visión</label>
            <textarea name="vision" rows="3" placeholder="Describe la visión"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Valores</label>
            <div id="valores-container" class="space-y-2">
                <input type="text" name="valores[]" placeholder="Valor #1"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>
            <button type="button" onclick="agregarCampoValor()"
                class="mt-2 text-sm px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                + Agregar otro valor
            </button>
        </div>

        <button type="submit"
                class="w-full mt-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-2 rounded-lg shadow transition">
            💾 Guardar Plan Estratégico
        </button>
    </form>
</div>

<script>
    function agregarCampoValor() {
        const container = document.getElementById('valores-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'valores[]';
        input.placeholder = `Valor #${container.children.length + 1}`;
        input.className = 'w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition';
        container.appendChild(input);
    }
</script>
@endsection
