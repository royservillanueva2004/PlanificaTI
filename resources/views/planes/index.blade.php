@extends('layouts.app')

@section('content')
<div class="p-6">
    <a href="{{ route('planes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Nuevo Plan</a>
    <h1 class="text-3xl font-bold mt-6 mb-4">📋 Mis Planes Estratégicos</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($planes as $plan)
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $plan->nombre_plan }}</h2>
                <p class="text-sm text-gray-600 mb-1"><strong>Misión:</strong> {{ $plan->mision }}</p>
                <p class="text-sm text-gray-600 mb-1"><strong>Visión:</strong> {{ $plan->vision }}</p>
                <p class="text-sm text-gray-600 mb-2"><strong>Valores:</strong>
                    @foreach(explode(',', $plan->valores) as $valor)
                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs mr-1 mb-1">{{ trim($valor) }}</span>
                    @endforeach
                </p>

                <div class="flex flex-wrap gap-2 mt-4">
                    {{-- Seleccionar --}}
                    <form action="{{ route('planes.seleccionar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                            Seleccionar
                        </button>
                    </form>

                    {{-- Editar --}}
                    <a href="{{ route('planes.edit', $plan->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                        Editar
                    </a>

                    {{-- Eliminar --}}
                    <form action="{{ route('planes.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este plan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
