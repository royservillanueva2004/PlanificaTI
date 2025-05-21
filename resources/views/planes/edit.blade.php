@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        ✏️ Editar Plan Estratégico
    </h2>

    <form method="POST" action="{{ route('planes.update', $plane) }}" class="space-y-5 text-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium text-gray-600 mb-1">Nombre del Plan</label>
            <input type="text" name="nombre_plan" value="{{ old('nombre_plan', $plane->nombre_plan) }}"
                placeholder="Nombre del Plan"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition" required>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Misión</label>
            <textarea name="mision" placeholder="Describe la misión" rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">{{ old('mision', $plane->mision) }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Visión</label>
            <textarea name="vision" placeholder="Describe la visión" rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">{{ old('vision', $plane->vision) }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-600 mb-1">Valores</label>
            <div id="valores-container" class="space-y-2">
                @php
                    $valores = explode(',', old('valores', $plane->valores));
                @endphp
                @foreach($valores as $valor)
                    <input type="text" name="valores[]" value="{{ trim($valor) }}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                        placeholder="Valor">
                @endforeach
            </div>
            <button type="button" onclick="agregarCampoValor()"
                class="mt-2 px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                + Agregar otro valor
            </button>
        </div>

        <div class="flex justify-between items-center mt-6">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                💾 Actualizar
            </button>
            <a href="{{ route('planes.index') }}" class="text-gray-600 hover:underline text-sm">
                Cancelar
            </a>
        </div>
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
