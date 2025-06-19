@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-800 mb-6 flex items-center gap-2">
        🎯 Crear Nuevo Objetivo Estratégico
    </h2>

    <form action="{{ route('objetivos.store') }}" method="POST" x-data="{ count: 1 }" class="space-y-6 text-sm">
        @csrf

        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">

        {{-- OBJETIVO GENERAL --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Objetivo General</label>
            <textarea name="descripcion_general" required rows="3"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Describe el objetivo general..."></textarea>
        </div>

        {{-- OBJETIVOS ESPECÍFICOS --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Objetivos Específicos</label>

            <template x-for="i in count" :key="i">
                <textarea :name="'especificos[]'" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800 shadow-sm mb-3 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                    :placeholder="'Objetivo específico #' + i"></textarea>
            </template>

            <button type="button"
                @click="count++"
                class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg shadow transition text-sm">
                ➕ Agregar otro objetivo
            </button>
        </div>

        {{-- BOTÓN GUARDAR --}}
        <div class="pt-4">
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                💾 Guardar Objetivos
            </button>
        </div>
    </form>
</div>
@endsection

{{-- TOAST DE ÉXITO --}}
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
