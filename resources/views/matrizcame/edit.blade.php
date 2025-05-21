@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">✏️ Editar Acción - Matriz CAME</h1>

    <a href="{{ route('matrizcame.index') }}"
       class="inline-block text-sm text-blue-600 hover:underline mb-4">← Volver a la matriz</a>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="block mb-2">⚠️ Corrige los siguientes errores:</strong>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('matrizcame.update', $matrizcame->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Acción --}}
        <div>
            <label for="accion" class="block font-medium text-gray-700 mb-1">Acción</label>
            <textarea name="accion" id="accion" rows="4"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                      required>{{ old('accion', $matrizcame->accion) }}</textarea>
        </div>

        {{-- Tipo --}}
        <div>
            <label for="tipo" class="block font-medium text-gray-700 mb-1">Tipo de Acción</label>
            <select name="tipo" id="tipo"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                    required>
                <option value="">-- Selecciona una opción --</option>
                <option value="C" {{ old('tipo', $matrizcame->tipo) == 'C' ? 'selected' : '' }}>🛠 Corregir</option>
                <option value="A" {{ old('tipo', $matrizcame->tipo) == 'A' ? 'selected' : '' }}>⚔️ Afrontar</option>
                <option value="M" {{ old('tipo', $matrizcame->tipo) == 'M' ? 'selected' : '' }}>🛡 Mantener</option>
                <option value="E" {{ old('tipo', $matrizcame->tipo) == 'E' ? 'selected' : '' }}>🚀 Explotar</option>
            </select>
        </div>

        {{-- Botón --}}
        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                💾 Actualizar Acción
            </button>
        </div>
    </form>
</div>
@endsection
