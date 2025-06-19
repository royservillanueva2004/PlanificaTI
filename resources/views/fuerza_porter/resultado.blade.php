@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 pb-24">
    <h2 class="text-2xl font-bold mb-6">📌 Resultado del Análisis - 5 Fuerzas de Porter</h2>

    <div class="bg-blue-100 border border-blue-300 text-blue-900 p-4 rounded mb-6">
        <strong>Conclusión:</strong>
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

        <div class="flex flex-col gap-10 mb-6">
            {{-- Oportunidades --}}
            <div>
                <label class="block font-semibold mb-2">💡 Oportunidades</label>
                <div id="oportunidades-container" class="space-y-3">
                    @foreach($foda->oportunidades ?? [''] as $item)
                        <div class="flex gap-3">
                            <textarea name="oportunidades[]" rows="2" class="w-full p-2 border border-gray-300 rounded resize-y text-sm" placeholder="Oportunidad...">{{ $item }}</textarea>
                            <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addItem('oportunidades')" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">+ Añadir</button>
            </div>

            {{-- Amenazas --}}
            <div>
                <label class="block font-semibold mb-2">⚠️ Amenazas</label>
                <div id="amenazas-container" class="space-y-3">
                    @foreach($foda->amenazas ?? [''] as $item)
                        <div class="flex gap-3">
                            <textarea name="amenazas[]" rows="2" class="w-full p-2 border border-gray-300 rounded resize-y text-sm" placeholder="Amenaza...">{{ $item }}</textarea>
                            <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </div>
                    @endforeach
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
    const textarea = document.createElement('textarea');
    textarea.name = `${type}[]`;
    textarea.rows = 2;
    textarea.placeholder = type === 'oportunidades' ? 'Oportunidad...' : 'Amenaza...';
    textarea.className = 'w-full p-2 border border-gray-300 rounded resize-y text-sm';

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'bg-red-500 text-white px-3 py-1 rounded text-sm';
    btn.textContent = 'Eliminar';
    btn.onclick = () => div.remove();

    const div = document.createElement('div');
    div.className = 'flex gap-3';
    div.appendChild(textarea);
    div.appendChild(btn);

    container.appendChild(div);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>
@endsection
