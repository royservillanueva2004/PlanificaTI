@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 pb-24">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📊 Resultado del Análisis PEST</h1>

    {{-- Gráfico --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <canvas id="graficoPEST" height="200"></canvas>
    </div>

    {{-- Reflexión Estratégica (desde backend) --}}
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
        <h2 class="text-lg font-semibold text-blue-800 mb-2">🧠 Reflexión Estratégica</h2>
        <pre id="reflexion-generada" class="text-sm text-gray-800 whitespace-pre-wrap">Cargando reflexión...</pre>
    </div>

    {{-- Oportunidades y Amenazas --}}
    <form id="form-foda" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- 🌱 Oportunidades --}}
            <div>
                <h3 class="text-lg font-semibold text-green-700 flex justify-between items-center">
                    🌱 Oportunidades
                    <button type="button" onclick="agregarCampo('oportunidades')" class="text-sm bg-green-600 text-white px-2 py-1 rounded">➕ Agregar</button>
                </h3>
                <div id="contenedor-oportunidades" class="space-y-2 mt-2">
                    @if(isset($foda) && !empty($foda->oportunidades))
                        @foreach($foda->oportunidades as $oportunidad)
                            <div class="flex gap-2">
                                <input type="text" name="oportunidades[]" value="{{ $oportunidad }}" class="w-full border rounded p-2" />
                                <button type="button" onclick="this.parentNode.remove()" class="text-red-600">🗑️</button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex gap-2">
                            <input type="text" name="oportunidades[]" class="w-full border rounded p-2" placeholder="Escribe una oportunidad..." />
                            <button type="button" onclick="this.parentNode.remove()" class="text-red-600">🗑️</button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ⚠️ Amenazas --}}
            <div>
                <h3 class="text-lg font-semibold text-red-700 flex justify-between items-center">
                    ⚠️ Amenazas
                    <button type="button" onclick="agregarCampo('amenazas')" class="text-sm bg-red-600 text-white px-2 py-1 rounded">➕ Agregar</button>
                </h3>
                <div id="contenedor-amenazas" class="space-y-2 mt-2">
                    @if(isset($foda) && !empty($foda->amenazas))
                        @foreach($foda->amenazas as $amenaza)
                            <div class="flex gap-2">
                                <input type="text" name="amenazas[]" value="{{ $amenaza }}" class="w-full border rounded p-2" />
                                <button type="button" onclick="this.parentNode.remove()" class="text-red-600">🗑️</button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex gap-2">
                            <input type="text" name="amenazas[]" class="w-full border rounded p-2" placeholder="Escribe una amenaza..." />
                            <button type="button" onclick="this.parentNode.remove()" class="text-red-600">🗑️</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Alerta flotante --}}
        <div id="alerta-guardado" class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow hidden z-50">
            ✅ Información actualizada correctamente
        </div>

        <button type="button" onclick="guardarFoda()" class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 font-semibold rounded shadow">
            💾 Guardar Oportunidades y Amenazas
        </button>
    </form>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoPEST').getContext('2d');
    const grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Social', 'Ambiental', 'Político', 'Económico', 'Tecnológico'],
            datasets: [{
                label: 'Nivel de Impacto (%)',
                data: [
                    {{ $valores['social'] }},
                    {{ $valores['ambiental'] }},
                    {{ $valores['politico'] }},
                    {{ $valores['economico'] }},
                    {{ $valores['tecnologico'] }}
                ],
                backgroundColor: ['#60a5fa', '#34d399', '#facc15', '#fb923c', '#a78bfa'],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Impacto por Factor', font: { size: 18 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        callback: value => value + '%'
                    }
                }
            }
        }
    });

    // Reflexión desde base de datos
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('{{ route("pest.reflexion.bd") }}');
            const data = await response.json();
            document.getElementById('reflexion-generada').innerText = data.reflexion ?? 'No se pudo generar la reflexión.';
        } catch (error) {
            document.getElementById('reflexion-generada').innerText = 'Error al cargar la reflexión.';
            console.error(error);
        }
    });

    // Agregar campo dinámico
    function agregarCampo(tipo) {
        const contenedor = document.getElementById(`contenedor-${tipo}`);
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="${tipo}[]" class="w-full border rounded p-2" placeholder="Nueva ${tipo.slice(0, -1)}..." />
            <button type="button" onclick="this.parentNode.remove()" class="text-red-600">🗑️</button>
        `;
        contenedor.appendChild(div);
    }

    // Guardar FODA con AJAX
    function guardarFoda() {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        let camposLlenos = 0;

        document.querySelectorAll('input[name="oportunidades[]"]').forEach(input => {
            const valor = input.value.trim();
            if (valor !== '') {
                formData.append('oportunidades[]', valor);
                camposLlenos++;
            }
        });

        document.querySelectorAll('input[name="amenazas[]"]').forEach(input => {
            const valor = input.value.trim();
            if (valor !== '') {
                formData.append('amenazas[]', valor);
                camposLlenos++;
            }
        });

        if (camposLlenos === 0) {
            alert('Debe ingresar al menos una oportunidad o amenaza.');
            return;
        }

        fetch('{{ route("pest.foda.guardar") }}', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error('Error al guardar');
            return res.json();
        })
        .then(() => {
            const alerta = document.getElementById('alerta-guardado');
            alerta.classList.remove('hidden');
            setTimeout(() => alerta.classList.add('hidden'), 3000);
        })
        .catch(err => {
            alert('Error al guardar. Intente nuevamente.');
            console.error(err);
        });
    }
</script>
@endsection
