@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        ✏️ Editar Objetivo Estratégico
    </h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('objetivos.update', $objetivo->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Campo oculto de plan_id --}}
        <input type="hidden" name="plan_id" value="{{ $objetivo->plan_id }}">

        {{-- Objetivo general --}}
        <div class="mb-4">
            <label class="block font-medium text-gray-600 mb-1">Objetivo General</label>
            <textarea name="descripcion" rows="3" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Descripción general">{{ old('descripcion', $objetivo->descripcion) }}</textarea>
        </div>

        {{-- Objetivos específicos --}}
        <div>
            <label class="block font-medium text-gray-600 mb-2">Objetivos Específicos</label>

            <div id="contenedorEspecificos">
                @foreach ($objetivo->especificos as $index => $especifico)
                    <div class="mb-2 flex items-start gap-2">
                        <textarea name="especificos[{{ $index }}]" rows="2"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Objetivo específico #{{ $loop->iteration }}">{{ old("especificos.$index", $especifico->descripcion) }}</textarea>

                        <button type="button" class="btnEliminar p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition" title="Eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="btnAgregarEspecifico"
                class="mt-2 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow">
                + Agregar Específico
            </button>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                💾 Actualizar Objetivo
            </button>
            <a href="{{ route('objetivos.index') }}"
                class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-gray-700 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const contenedor = document.getElementById('contenedorEspecificos');
    const btnAgregar = document.getElementById('btnAgregarEspecifico');

    // Agregar
    btnAgregar.addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'mb-2 flex items-start gap-2';

        const textarea = document.createElement('textarea');
        textarea.name = `especificos[]`;
        textarea.className = 'w-full border rounded px-3 py-2';
        textarea.rows = 2;

        const btnEliminar = document.createElement('button');
        btnEliminar.type = 'button';
        btnEliminar.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>`;
        btnEliminar.className = 'p-2 bg-red-500 hover:bg-red-600 rounded-full';

        btnEliminar.addEventListener('click', () => {
            contenedor.removeChild(div);
        });

        div.appendChild(textarea);
        div.appendChild(btnEliminar);
        contenedor.appendChild(div);
    });

    // Delegar eventos de eliminación en elementos ya existentes
    contenedor.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            const div = this.closest('div');
            contenedor.removeChild(div);
        });
    });
});
</script>
@endsection
