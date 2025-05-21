@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        📊 Autoevaluación - Cadena de Valor
    </h1>
    {{-- Botón --}}
        <div class="mt-4 flex gap-4">

            {{-- Ver Reflexión (solo si ya existe registro) --}}
            @if(isset($registro))
                <a href="{{ route('cadena-valor.ver') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 font-semibold rounded shadow">
                    👁️ Ver Reflexión
                </a>
            @endif
        </div>

    <p class="text-gray-600 mt-1">Responde según el nivel de cumplimiento en tu organización.</p>

    <form id="form-evaluacion" class="space-y-6">
        @csrf

        {{-- Preguntas --}}
        @foreach ($preguntas as $index => $pregunta)
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <h2 class="text-base font-semibold text-gray-800 mb-2">
                    {{ $index + 1 }}. {{ $pregunta }}
                </h2>
                <div class="flex gap-4 text-sm">
                    @for ($i = 0; $i <= 4; $i++)
                        <label class="flex items-center gap-1">
                            <input type="radio" name="respuestas[{{ $index }}]" value="{{ $i }}"
    {{ isset($registro) && isset($registro->respuestas[$index]) && $registro->respuestas[$index] == $i ? 'checked' : '' }}
    class="text-blue-600" required>
                            {{ $i }}
                        </label>
                    @endfor
                </div>
            </div>
        @endforeach

        {{-- Botón --}}
        <div class="mt-4 flex gap-4">
            {{-- Generar Reflexión --}}
            <button id="btn-generar-reflexion" type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 font-semibold rounded shadow">
                ✨ Generar Reflexión y Continuar
            </button>

            {{-- Ver Reflexión (solo si ya existe registro) --}}
            @if(isset($registro))
                <a href="{{ route('cadena-valor.ver') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 font-semibold rounded shadow">
                    👁️ Ver Reflexión
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Script --}}
<script>
document.getElementById('btn-generar-reflexion').addEventListener('click', async () => {
    const respuestas = {};
    const radios = document.querySelectorAll('input[type="radio"]:checked');

    if (radios.length < {{ count($preguntas) }}) {
        alert('Por favor responde todas las preguntas antes de continuar.');
        return;
    }

    radios.forEach((radio) => {
        const index = radio.name.match(/\d+/)[0];
        respuestas[index] = parseInt(radio.value);
    });

    const total = Object.values(respuestas).reduce((sum, val) => sum + val, 0);

    try {
        const response = await fetch('{{ route("generar.reflexion") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ resultado: total })
        });

        const data = await response.json();

        // Redirigir al análisis con reflexión y respuestas
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("cadena-valor.analisis") }}';

        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="resultado" value="${total}">
            <input type="hidden" name="reflexion" value="${data.reflexion}">
            ${Object.entries(respuestas).map(([index, val]) =>
                `<input type="hidden" name="respuestas[${index}]" value="${val}">`).join('')}
        `;

        document.body.appendChild(form);
        form.submit();

    } catch (error) {
        alert('Error al generar la reflexión.');
        console.error(error);
    }
});
</script>
@endsection