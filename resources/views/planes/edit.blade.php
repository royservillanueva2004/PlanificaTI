@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Editar Plan Estratégico</h1>

    <form method="POST" action="{{ route('planes.update', $plane) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="nombre_plan" value="{{ old('nombre_plan', $plane->nombre_plan) }}"
            placeholder="Nombre del Plan" class="w-full border px-3 py-2 rounded" required>

        <textarea name="mision" placeholder="Misión" class="w-full border px-3 py-2 rounded">{{ old('mision', $plane->mision) }}</textarea>

        <textarea name="vision" placeholder="Visión" class="w-full border px-3 py-2 rounded">{{ old('vision', $plane->vision) }}</textarea>

        <div>
            <label class="block font-semibold mb-2">Valores</label>
            <div id="valores-container" class="space-y-2">
                @php
                    $valores = explode(',', old('valores', $plane->valores));
                @endphp
                @foreach($valores as $valor)
                    <input type="text" name="valores[]" class="w-full border px-3 py-2 rounded" value="{{ trim($valor) }}" placeholder="Valor">
                @endforeach
            </div>
            <button type="button" onclick="agregarCampoValor()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded text-sm">+ Agregar Valor</button>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('planes.index') }}" class="text-gray-600 ml-4">Cancelar</a>
    </form>
</div>

<script>
    function agregarCampoValor() {
        const container = document.getElementById('valores-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'valores[]';
        input.className = 'w-full border px-3 py-2 rounded';
        input.placeholder = `Valor #${container.children.length + 1}`;
        container.appendChild(input);
    }
</script>
@endsection