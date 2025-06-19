@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-800 mb-6 flex items-center gap-2">
        ✏️ Editar Objetivo Estratégico
    </h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded mb-5">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('objetivos.update', $objetivo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="plan_id" value="{{ $objetivo->plan_id }}">

        {{-- Objetivo General --}}
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-2">Objetivo General</label>
            <textarea name="descripcion" rows="3" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm text-sm resize-none overflow-hidden focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Descripción general">{{ old('descripcion', $objetivo->descripcion) }}</textarea>
        </div>

        {{-- Objetivos Específicos --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Objetivos Específicos</label>

            <div id="contenedorEspecificos">
                @foreach ($objetivo->especificos as $index => $especifico)
                    <div class="mb-3 flex items-start gap-2">
                        <textarea name="especificos[{{ $index }}]" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm text-sm resize-none overflow-hidden focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                            placeholder="Objetivo específico #{{ $loop->iteration }}">{{ old("especificos.$index", $especifico->descripcion) }}</textarea>

                        <button type="button" class="btnEliminar mt-1 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition" title="Eliminar">
                            <i class="bi bi-x-lg text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="btnAgregarEspecifico"
                class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm">
                ➕ Agregar Específico
            </button>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                💾 Actualizar Objetivo
            </button>
            <a href="{{ route('objetivos.index') }}"
                class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700 transition">
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

    // Función para autoajustar altura de textareas
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Aplicar autoajuste a los existentes
    contenedor.querySelectorAll('textarea').forEach(t => {
        autoResize(t);
        t.addEventListener('input', () => autoResize(t));
    });

    // Eliminar ya existentes
    contenedor.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            const div = this.closest('div');
            div.remove();
        });
    });

    // Agregar nuevo campo
    btnAgregar.addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'mb-3 flex items-start gap-2';

        const textarea = document.createElement('textarea');
        textarea.name = 'especificos[]';
        textarea.rows = 2;
        textarea.className = 'w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm text-sm resize-none overflow-hidden focus:ring-2 focus:ring-blue-500 focus:outline-none transition';
        textarea.placeholder = 'Nuevo objetivo específico...';

        textarea.addEventListener('input', () => autoResize(textarea));
        autoResize(textarea);

        const btnEliminar = document.createElement('button');
        btnEliminar.type = 'button';
        btnEliminar.innerHTML = `<i class="bi bi-x-lg text-xs text-white"></i>`;
        btnEliminar.className = 'mt-1 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition';
        btnEliminar.onclick = () => div.remove();

        div.appendChild(textarea);
        div.appendChild(btnEliminar);
        contenedor.appendChild(div);
    });
});
</script>
@endsection

@if(session('success'))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: '✅ {{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endpush
@endif
