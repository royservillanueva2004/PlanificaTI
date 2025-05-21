@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">🎯 Nuevo Objetivo Estratégico</h1>

    <form action="{{ route('objetivos.store') }}" method="POST" x-data="{ count: 1 }">
        @csrf

        {{-- Plan estratégico oculto --}}
        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">

        {{-- Objetivo General --}}
        <div class="mb-4">
            <label class="block font-medium">Objetivo General</label>
            <textarea name="descripcion_general"
                      class="w-full border rounded px-3 py-2"
                      rows="3"
                      required
                      placeholder="Describe el objetivo general..."></textarea>
        </div>

        {{-- Objetivos Específicos dinámicos --}}
        <div class="mb-4">
            <label class="block font-medium mb-2">Objetivos Específicos</label>

            <template x-for="i in count" :key="i">
                <textarea :name="'especificos[]'"
                          class="w-full border rounded px-3 py-2 mb-2"
                          :placeholder="'Objetivo específico #' + i"
                          required></textarea>
            </template>

            <button type="button"
                    @click="count++"
                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                + Agregar Específico
            </button>
        </div>

        {{-- Botón de guardar --}}
        <button type="submit"
                class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar Objetivos
        </button>
    </form>
</div>
@endsection
