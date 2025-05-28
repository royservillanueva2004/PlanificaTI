@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">📌 Resultado del Análisis - 5 Fuerzas de Porter</h2>

    <div class="bg-blue-100 border border-blue-300 text-blue-900 p-4 rounded mb-6">
        <strong>Conclusión automática:</strong>
        <p class="mt-2">{{ $registro->conclusion }}</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-100 border border-gray-300 text-gray-800 p-4 rounded mb-6">
        <strong>Puntaje total del Análisis:</strong>
        <span class="text-lg font-semibold">{{ $total }}</span>
    </div>

    <form method="POST" action="{{ route('fuerza_porter.guardar_foda', $registro->id) }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block font-semibold mb-2">Oportunidades</label>
                <div id="oportunidades-container">
                    @if(isset($foda) && $foda->oportunidades)
                        @foreach($foda->oportunidades as $index => $item)
                            <div class="flex gap-3 mb-2">
                                <input type="text" name="oportunidades[]" value="{{ $item }}" class="w-full p-2 border border-gray-300 rounded" placeholder="Oportunidad {{ $index + 1 }}">
                                <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex gap-3 mb-2">
                            <input type="text" name="oportunidades[]" class="w-full p-2 border border-gray-300 rounded" placeholder="Oportunidad 1">
                            <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addItem('oportunidades')" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">+ Añadir</button>
            </div>

            <div>
                <label class="block font-semibold mb-2">Amenazas</label>
                <div id="amenazas-container">
                    @if(isset($foda) && $foda->amenazas)
                        @foreach($foda->amenazas as $index => $item)
                            <div class="flex gap-3 mb-2">
                                <input type="text" name="amenazas[]" value="{{ $item }}" class="w-full p-2 border border-gray-300 rounded" placeholder="Amenaza {{ $index + 1 }}">
                                <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex gap-3 mb-2">
                            <input type="text" name="amenazas[]" class="w-full p-2 border border-gray-300 rounded" placeholder="Amenaza 1">
                            <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addItem('amenazas')" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">+ Añadir</button>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('fuerza_porter.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg">
                ✏️ Editar análisis
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                Guardar y Continuar
            </button>
        </div>
    </form>
</div>

<script>
function addItem(type) {
    const container = document.getElementById(`${type}-container`);
    const index = container.children.length + 1;

    const placeholderText = type === 'oportunidades'
        ? `Oportunidad ${index}`
        : `Amenaza ${index}`;

    const newItem = document.createElement('div');
    newItem.classList.add('flex', 'gap-3', 'mb-2');
    newItem.innerHTML = `
        <input type="text" name="${type}[]" class="w-full p-2 border border-gray-300 rounded" placeholder="${placeholderText}">
        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
    `;
    container.appendChild(newItem);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>
@endsection
