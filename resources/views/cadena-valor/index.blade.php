@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            📊 Autoevaluación - Cadena de Valor
        </h1>
        <p class="text-gray-600 mt-1">Responde según el nivel de cumplimiento en tu organización.</p>
    </div>

    <form id="form-evaluacion" action="{{ route('cadena-valor.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Potencial de mejora (si ya hay registro previo) --}}
        @if(isset($registro))
            @php
                $total = array_sum($registro->respuestas ?? []);
                $potencial = 1 - ($total / (count($preguntas) * 4));
                $porcentaje = round($potencial * 100);
            @endphp
            <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                <p class="text-lg font-medium text-gray-700 flex items-center gap-2">
                    🛠️ Potencial de Mejora: 
                    <span class="text-blue-600 font-bold">{{ $porcentaje }}%</span>
                </p>
                <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                    <div class="bg-green-500 h-3 rounded-full transition-all" style="width: {{ 100 - $porcentaje }}%"></div>
                </div>
            </div>
        @endif

        {{-- Reflexión --}}
        <div id="contenedor-reflexion" class="mt-6 {{ isset($registro) && $registro->reflexion ? '' : 'hidden' }}">
            <label for="reflexion" class="block font-medium text-gray-700 mb-1">📝 Reflexión</label>
            <textarea id="reflexion" name="reflexion" rows="15" placeholder="Escribe tu reflexión..."
                class="w-full border rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('reflexion', $registro->reflexion ?? '') }}</textarea>
        </div>

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
                                class="text-blue-600 focus:ring-blue-500" required>
                            {{ $i }}
                        </label>
                    @endfor
                </div>
            </div>
        @endforeach

        {{-- Botones --}}
        <div class="mt-4 flex gap-4">
            <button id="btn-generar-reflexion" type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 font-semibold rounded shadow">
                ✨ Generar Reflexión y Guardar
            </button>
            <button id="btn-submit" type="submit" class="hidden"></button>
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

        const contenedor = document.getElementById('contenedor-reflexion');
        const textarea = document.getElementById('reflexion');

        contenedor.classList.remove('hidden');
        textarea.value = 'Generando reflexión...';

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
            textarea.value = data.reflexion;

            // Enviar el formulario después de mostrar la reflexión
            setTimeout(() => {
                document.getElementById('btn-submit').click();
            }, 1500); // puedes ajustar el tiempo

        } catch (error) {
            console.error('Error:', error);
            textarea.value = 'No se pudo generar la reflexión automáticamente.';
        }
    });
</script>
@endsection
