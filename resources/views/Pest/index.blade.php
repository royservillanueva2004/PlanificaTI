@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        🧠 Análisis PEST
    </h1>

    @if (session('success'))
        <div class="mt-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <p class="text-gray-600 mt-1">Responde según el nivel de impacto de cada factor sobre tu organización.</p>

    <form id="form-pest" class="space-y-6">
        @csrf

        {{-- Preguntas --}}
        @foreach ($preguntas as $key => $texto)
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <h2 class="text-base font-semibold text-gray-800 mb-2">
                    {{ $texto }}
                </h2>
                <div class="flex gap-4 text-sm">
                    @for ($i = 0; $i <= 4; $i++)
                        <label class="flex items-center gap-1">
                            <input type="radio" name="respuestas[{{ $key }}]" value="{{ $i }}"
                                {{ isset($registro) && isset($registro->respuestas[$key]) && $registro->respuestas[$key] == $i ? 'checked' : '' }}
                                class="text-blue-600" required>
                            {{ $i }}
                        </label>
                    @endfor
                </div>
            </div>
        @endforeach

        {{-- Botón --}}
        <div class="mt-4 flex gap-4">
            <button id="btn-analizar" type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 font-semibold rounded shadow">
                📊 Analizar Impacto
            </button>

            @if (isset($registro))
                <a href="{{ route('pest.ver') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 font-semibold rounded shadow">
                    👁️ Ver Resultado
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Script --}}
<script>
    document.getElementById('btn-analizar').addEventListener('click', async () => {
        const radios = document.querySelectorAll('input[type="radio"]:checked');
        const totalPreguntas = {{ count($preguntas) }};

        if (radios.length < totalPreguntas) {
            alert('Por favor responde todas las preguntas antes de continuar.');
            return;
        }

        // 1. Obtener respuestas individuales
        const respuestas = {};
        radios.forEach(radio => {
            const name = radio.name.match(/respuestas\[(.*?)\]/)[1];
            respuestas[name] = parseInt(radio.value.trim(), 10);
        });

        // 2. Definir grupos de factores
        const grupos = {
            social: ['social_composicion_etnica','social_envejecimiento','social_estilos_vida','social_envejecimiento_oferta','social_responsabilidad'],
            ambiental: ['social_medio_ambiente','politico_legislacion_medioambiental','tecnologico_politicas_medioambientales','tecnologico_preocupacion_medioambiental','tecnologico_factor_ecologico'],
            politico: ['politico_legislacion_fiscal','politico_legislacion_laboral','politico_subvenciones','politico_proteccion_consumidor','politico_normativa_autonomica'],
            economico: ['economico_nivel_riqueza','economico_crecimiento','economico_tipos_interes','economico_globalizacion','economico_empleo'],
            tecnologico: ['tecnologico_internet','tecnologico_ntics','tecnologico_pionero','tecnologico_innovacion']
        };

        // 3. Calcular promedio porcentual de impacto (escala 0-100)
        const valores = {};
        for (const [grupo, claves] of Object.entries(grupos)) {
            const suma = claves.reduce((acc, clave) => acc + (respuestas[clave] ?? 0), 0);
            const maximo = claves.length * 4;
            valores[grupo] = Math.round((suma * 100) / maximo);
        }

        // 4. Generar reflexión automática con el backend
        try {
            const response = await fetch('{{ route("pest.reflexion") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ valores })
            });

            const data = await response.json();

            // 5. Crear formulario oculto para enviar a pest.analizar
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("pest.analizar") }}';

            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="reflexion" value="${data.reflexion}">
                ${Object.entries(respuestas).map(([k, v]) => 
                    `<input type="hidden" name="respuestas[${k}]" value="${v}">`).join('')}
            `;

            document.body.appendChild(form);
            form.submit();

        } catch (error) {
            alert('Error al generar reflexión');
            console.error(error);
        }
    });
</script>
@endsection
