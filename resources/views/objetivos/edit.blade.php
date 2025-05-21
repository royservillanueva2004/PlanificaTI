@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Editar Objetivo Estratégico</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('objetivos.update', $objetivo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Plan Estratégico</label>
            <select name="plan_id" class="w-full border rounded px-3 py-2">
                @foreach ($planes as $plan)
                    <option value="{{ $plan->id }}" {{ $plan->id == $objetivo->plan_id ? 'selected' : '' }}>
                        {{ $plan->nombre_plan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Objetivo General</label>
            <textarea name="descripcion" class="w-full border rounded px-3 py-2" rows="3">{{ old('descripcion', $objetivo->descripcion) }}</textarea>
        </div>

        <div>
    <label class="block font-medium mb-2">Objetivos Específicos</label>

        <div id="contenedorEspecificos">
            @foreach ($objetivo->especificos as $index => $especifico)
                <div class="mb-2" style="display: flex; align-items: center;">
                    <textarea
                        name="especificos[{{ $index }}]"
                        class="w-full border rounded px-3 py-2"
                        rows="2"
                    >{{ old('especificos.' . $index, $especifico->descripcion) }}</textarea>
                    <button type="button" class="btnEliminar bg-red-600 text-white px-2 py-1 rounded ml-2">Eliminar</button>
                </div>
            @endforeach
        </div>
            
            <button type="button" id="btnAgregarEspecifico" class="bg-green-600 text-white px-3 py-1 rounded">
                + Agregar Específico
            </button>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar Objetivo</button>
            <a href="{{ route('objetivos.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnAgregar = document.getElementById('btnAgregarEspecifico');
    const contenedor = document.getElementById('contenedorEspecificos');

    // Función para actualizar los nombres de los textareas al eliminar o agregar
    function actualizarNombres() {
        const divs = contenedor.querySelectorAll('div.mb-2');
        divs.forEach((div, index) => {
            const textarea = div.querySelector('textarea');
            textarea.name = `especificos[${index}]`;
        });
    }

    // Agregar nuevo textarea con botón eliminar
    btnAgregar.addEventListener('click', function () {
        const nuevoIndex = contenedor.querySelectorAll('textarea').length;

        const div = document.createElement('div');
        div.classList.add('mb-2');
        div.style.display = 'flex';
        div.style.alignItems = 'center';

        const textarea = document.createElement('textarea');
        textarea.name = `especificos[${nuevoIndex}]`;
        textarea.className = 'w-full border rounded px-3 py-2';
        textarea.rows = 2;
        textarea.placeholder = `Objetivo específico #${nuevoIndex + 1}`;

        const btnEliminar = document.createElement('button');
        btnEliminar.type = 'button';
        btnEliminar.textContent = 'Eliminar';
        btnEliminar.className = 'bg-red-600 text-white px-2 py-1 rounded ml-2';

        btnEliminar.addEventListener('click', () => {
            contenedor.removeChild(div);
            actualizarNombres();
        });

        div.appendChild(textarea);
        div.appendChild(btnEliminar);

        contenedor.appendChild(div);
    });

    // Delegación para eliminar objetivos específicos existentes
    contenedor.addEventListener('click', function (e) {
        if (e.target.classList.contains('btnEliminar')) {
            const div = e.target.parentElement;
            contenedor.removeChild(div);
            actualizarNombres();
        }
    });
});
</script>
