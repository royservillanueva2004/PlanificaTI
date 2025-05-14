@extends('layouts.app')

@section('content')
<div class="p-6">
    <a href="{{ route('planes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Nuevo Plan</a>
    <h1 class="text-2xl font-bold mt-4 mb-2">Mis Planes Estratégicos</h1>

    @foreach($planes as $plan)
        <div class="bg-white p-4 rounded shadow mb-2">
            <h2 class="text-xl font-semibold">{{ $plan->nombre_plan }}</h2>
            <p><strong>Misión:</strong> {{ $plan->mision }}</p>
            <p><strong>Visión:</strong> {{ $plan->vision }}</p>
            <a href="{{ route('planes.edit', $plan) }}" class="text-blue-600">Editar</a>
            <form action="{{ route('planes.destroy', $plan) }}" method="POST" class="inline-block ml-2">
                @csrf @method('DELETE')
                <button class="text-red-600">Eliminar</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
