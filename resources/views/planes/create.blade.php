@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Crear Plan Estratégico</h1>
    <form method="POST" action="{{ route('planes.store') }}" class="space-y-4">
        @csrf
        <input type="text" name="nombre_plan" placeholder="Nombre del Plan" class="w-full border px-3 py-2 rounded" required>
        <textarea name="mision" placeholder="Misión" class="w-full border px-3 py-2 rounded"></textarea>
        <textarea name="vision" placeholder="Visión" class="w-full border px-3 py-2 rounded"></textarea>
        <textarea name="valores" placeholder="Valores" class="w-full border px-3 py-2 rounded"></textarea>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
</div>
@endsection
