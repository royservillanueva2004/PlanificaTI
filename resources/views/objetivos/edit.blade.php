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

        <div x-data="{ count: {{ count($objetivo->especificos) > 0 ? count($objetivo->especificos) : 1 }} }">
            <label class="block font-medium mb-2">Objetivos Específicos</label>

            <template x-for="i in count" :key="i">
                <div class="mb-2">
                    <textarea :name="'especificos[' + (i - 1) + ']'" class="w-full border rounded px-3 py-2"
                        :placeholder="'Objetivo específico #' + i"
                        rows="2">{{ old('especificos.' . (count($objetivo->especificos) > 0 ? '$loop->index' : '')) }}</textarea>
                </div>
            </template>

            @foreach ($objetivo->especificos as $index => $especifico)
                <input type="hidden" name="especificos[{{ $index }}]" value="{{ $especifico->descripcion }}">
            @endforeach

            <button type="button" class="bg-green-600 text-white px-3 py-1 rounded" @click="count++">+ Agregar Específico</button>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar Objetivo</button>
            <a href="{{ route('objetivos.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection