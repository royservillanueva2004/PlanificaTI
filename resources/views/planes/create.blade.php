@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Crear Plan Estratégico</h1>
    <form method="POST" action="{{ route('planes.store') }}" class="space-y-4">
        @csrf

        <input type="text" name="nombre_plan" placeholder="Nombre del Plan" class="w-full border px-3 py-2 rounded" required>
        <textarea name="mision" placeholder="Misión" class="w-full border px-3 py-2 rounded"></textarea>
        <textarea name="vision" placeholder="Visión" class="w-full border px-3 py-2 rounded"></textarea>

        <div>
            <label class="block font-semibold mb-2">Valores</label>
            <div id="valores-container" class="space-y-2">
                <input type="text" name="valores[]" class="w-full border px-3 py-2 rounded" placeholder="Valor #1">
            </div>
            <button type="button" onclick="agregarCampoValor()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded text-sm">+ Agregar Valor</button>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
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