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

        <textarea name="valores" placeholder="Valores" class="w-full border px-3 py-2 rounded">{{ old('valores', $plane->valores) }}</textarea>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('planes.index') }}" class="text-gray-600 ml-4">Cancelar</a>
    </form>
</div>
@endsection
