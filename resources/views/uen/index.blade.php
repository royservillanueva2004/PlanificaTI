@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">🏢 Unidades Estratégicas de Negocio (UEN)</h1>

    {{-- Errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tarjeta de registro --}}
    <div class="bg-white border border-gray-200 rounded shadow">
        <div class="bg-blue-100 px-4 py-2 font-semibold text-lg text-blue-800 border-b">
            Registrar nueva UEN
        </div>

        <div class="p-4 space-y-3">
            {{-- Formulario de registro --}}
            <form action="{{ route('uen.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="descripcion" placeholder="Describa una UEN..." required
                       class="flex-1 border rounded px-3 py-2 text-sm">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                    +
                </button>
            </form>

            {{-- Listado --}}
            @php
                $editarId = request()->query('editar');
            @endphp

            @forelse($uens as $uen)
                @if($editarId == $uen->id)
                    {{-- Formulario de edición --}}
                    <form action="{{ route('uen.update', $uen->id) }}" method="POST" class="flex gap-2 items-center border px-3 py-2 rounded bg-yellow-50">
                        @csrf
                        @method('PUT')
                        <input type="text" name="descripcion" value="{{ old('descripcion', $uen->descripcion) }}" class="flex-1 border rounded px-3 py-1 text-sm" required>
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm px-3 py-1 rounded">Guardar</button>
                        <a href="{{ route('uen.index') }}" class="text-sm text-gray-500 hover:underline">Cancelar</a>
                    </form>
                @else
                    {{-- Modo lectura --}}
                    <div class="flex justify-between items-center border px-3 py-2 rounded bg-gray-50">
                        <span class="text-sm text-gray-800">{{ $uen->descripcion }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('uen.index', ['editar' => $uen->id]) }}" class="text-blue-600 text-sm hover:underline">Editar</a>
                            <form action="{{ route('uen.destroy', $uen->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta UEN?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-sm text-gray-500">Aún no hay UEN registradas.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Alerta tipo toast (éxito) --}}
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
@endsection
