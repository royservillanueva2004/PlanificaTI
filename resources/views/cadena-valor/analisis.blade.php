@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- BOTÓN EXTERNO QUE ENVÍA EL FORMULARIO Y REDIRIGE --}}
    <div class="pt-4 flex justify-end">
        <button 
            type="button" 
            onclick="enviarYRedirigir()"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Guardar Fortalezas y Debilidades
        </button>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">📈 Resultado de Evaluación - Cadena de Valor</h1>

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Columna izquierda: Porcentaje y Reflexión --}}
        <div class="lg:basis-1/2 flex flex-col gap-6">
            {{-- Potencial de Mejora --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    🛠️ Potencial de Mejora: <span class="text-blue-600 font-bold ml-auto">{{ 100 - $resultado }}%</span>
                </h2>
                <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ 100 - $resultado }}%"></div>
                </div>
            </div>

            {{-- Reflexión Generada --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">📝 Reflexión Generada</h2>
                <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $reflexion }}</p>
            </div>
        </div>

        {{-- Columna derecha: Formulario FODA --}}
        <div class="lg:basis-1/2 flex flex-col gap-6">
            <form id="form-foda" action="{{ route('foda.guardar') }}" method="POST" class="bg-white p-6 rounded-lg shadow border space-y-6">
                @csrf

                {{-- Fortalezas --}}
                <div>
                    <h3 class="text-green-700 font-semibold mb-2">💪 Fortalezas</h3>
                    <div id="fortalezas-container" class="space-y-2">
                        @if(isset($foda) && is_array($foda->fortalezas))
                            @foreach($foda->fortalezas as $fortaleza)
                                <input type="text" name="fortalezas[]" value="{{ $fortaleza }}" class="w-full border px-4 py-2 rounded">
                            @endforeach
                        @endif
                        <input type="text" name="fortalezas[]" placeholder="Fortaleza nueva" class="w-full border px-4 py-2 rounded">
                    </div>
                    <button type="button" onclick="agregarCampo('fortalezas-container', 'fortalezas[]')" class="text-sm text-blue-600 mt-2 hover:underline">+ Agregar fortaleza</button>
                </div>

                {{-- Debilidades --}}
                <div>
                    <h3 class="text-red-700 font-semibold mb-2">⚠️ Debilidades</h3>
                    <div id="debilidades-container" class="space-y-2">
                        @if(isset($foda) && is_array($foda->debilidades))
                            @foreach($foda->debilidades as $debilidad)
                                <input type="text" name="debilidades[]" value="{{ $debilidad }}" class="w-full border px-4 py-2 rounded">
                            @endforeach
                        @endif
                        <input type="text" name="debilidades[]" placeholder="Debilidad nueva" class="w-full border px-4 py-2 rounded">
                    </div>
                    <button type="button" onclick="agregarCampo('debilidades-container', 'debilidades[]')" class="text-sm text-blue-600 mt-2 hover:underline">+ Agregar debilidad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function agregarCampo(contenedorId, inputName) {
    const container = document.getElementById(contenedorId);
    const input = document.createElement('input');
    input.type = 'text';
    input.name = inputName;
    input.placeholder = inputName.includes('fortalezas') ? 'Fortaleza nueva' : 'Debilidad nueva';
    input.className = 'w-full border px-4 py-2 rounded';
    container.appendChild(input);
}
function enviarYRedirigir() {
    const form = document.getElementById('form-foda');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.href = "{{ route('matriz-bcg.index') }}";
        } else {
            alert('Ocurrió un error al guardar los datos.');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Error al enviar el formulario.');
    });
}
</script>
@endsection
