@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        🎯 Nuevo Objetivo Estratégico
    </h2>

    <form action="{{ route('objetivos.store') }}" method="POST" x-data="{ count: 1 }" class="space-y-5 text-sm">
        @csrf

        {{-- Plan estratégico oculto --}}
        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">

        {{-- Objetivo General --}}
        <div>
            <label class="block font-medium text-gray-600 mb-1">Objetivo General</label>
            <textarea name="descripcion_general" required rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Describe el objetivo general..."></textarea>
        </div>

        {{-- Objetivos Específicos dinámicos --}}
        <div>
            <label class="block font-medium text-gray-600 mb-1">Objetivos Específicos</label>

            <template x-for="i in count" :key="i">
                <textarea :name="'especificos[]'" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm mb-2 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                    :placeholder="'Objetivo específico #' + i"></textarea>
            </template>

            <button type="button"
                @click="count++"
                class="bg-green-600 hover:bg-green-700 text-white font-medium px-3 py-1 rounded-lg shadow transition">
                + Agregar Específico
            </button>
        </div>

        {{-- Botón de guardar --}}
        <div class="pt-4">
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                💾 Guardar Objetivos
            </button>
        </div>
    </form>
</div>
@endsection
