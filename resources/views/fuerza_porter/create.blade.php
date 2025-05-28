@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-5">Análisis 5 Fuerzas de Porter</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3 bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('fuerza_porter.store') }}" id="porterForm">
        @csrf
        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">

        @php
            $fuerzas = [
                'rivalidad' => [
                    'Crecimiento (lento)' => 'crecimiento',
                    'Naturaleza de los competidores (muchos)' => 'naturaleza_competidores',
                    'Exceso de capacidad productiva (Sí)' => 'exceso_capacidad_productiva',
                    'Rentabilidad media del sector (Baja)' => 'rentabilidad_media_sector',
                    'Diferenciación del producto (Escasa)' => 'diferenciacion_producto',
                    'Barreras de salida (Bajas)' => 'barreras_salida'
                ],
                'barreras' => [
                    'Economías de escala (No)' => 'economias_escala',
                    'Necesidad de capital (Bajas)' => 'necesidad_capital',
                    'Acceso a la tecnología (Fácil)' => 'acceso_tecnologia',
                    'Reglamentos o leyes limitativos (No)' => 'reglamentos_leyes',
                    'Trámites burocráticos (Bajos)' => 'tramites_burocraticos'
                ],
                'clientes' => [
                    'Número de clientes (Pocos)' => 'numero_clientes',
                    'Posibilidad de integración ascendente (Pequeña)' => 'integracion_ascendente',
                    'Rentabilidad de los clientes (Baja)' => 'rentabilidad_clientes',
                    'Coste de cambio de proveedor para cliente (Bajo)' => 'coste_cambio'
                ],
                'sustitutos' => [
                    'Disponibilidad de productos sustitutos (Grande)' => 'disponibilidad_sustitutivos'
                ]
            ];
        @endphp

        <div class="overflow-x-auto shadow-xl sm:rounded-lg mb-5">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Perfil Competitivo</th>
                        @for ($i = 1; $i <= 5; $i++)
                            <th class="border border-gray-300 px-2 py-2 text-center">{{ $i }}<br><small>{{ ['Nada', 'Poco', 'Medio', 'Alto', 'Muy Alto'][$i-1] }}</small></th>
                        @endfor
                        <th class="border border-gray-300 px-4 py-2 text-center">Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fuerzas as $categoria => $items)
                        <tr class="bg-gray-50">
                            <td colspan="7" class="border border-gray-300 px-4 py-2 font-semibold bg-blue-100">
                                {{ strtoupper($loop->index + 1) }}. {{ ucfirst($categoria) }}
                            </td>
                        </tr>
                        @foreach ($items as $label => $name)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $label }}</td>
                            @for ($i = 1; $i <= 5; $i++)
                                <td class="border border-gray-300 text-center">
                                    <input type="radio" name="{{ $name }}" value="{{ $i }}" class="mx-auto {{ $categoria }}" onclick="calcularPuntaje()" required>
                                </td>
                            @endfor
                            <td class="border border-gray-300 text-center"><span id="puntaje_{{ $name }}">0</span></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="border border-gray-300 font-semibold px-4 py-2">Subtotal {{ ucfirst($categoria) }}</td>
                            <td colspan="5" class="border border-gray-300"></td>
                            <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_{{ $categoria }}">0</span></td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 font-semibold text-lg">TOTAL GENERAL</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold text-lg"><span id="total_general">0</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-lg font-semibold mb-2">Oportunidades</label>
                <div id="oportunidades-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="oportunidades[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Oportunidad 1">
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('oportunidades')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Oportunidad</button>
            </div>

            <div>
                <label class="block text-lg font-semibold mb-2">Amenazas</label>
                <div id="amenazas-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="amenazas[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Amenaza 1">
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('amenazas')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Amenaza</button>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">Conclusión</label>
            <textarea class="w-full p-3 border border-gray-300 rounded" id="conclusion" name="conclusion" rows="4"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
            Guardar análisis
        </button>
    </form>
</div>

<script>
function calcularPuntaje() {
    document.querySelectorAll('input[type=\"radio\"]:checked').forEach(input => {
        const name = input.name;
        const value = input.value;
        const span = document.getElementById(`puntaje_${name}`);
        if (span) span.textContent = value;
    });

    const categorias = ['rivalidad', 'barreras', 'clientes', 'sustitutos'];
    let total = 0;
    categorias.forEach(cat => {
        let subtotal = 0;
        document.querySelectorAll(`input.${cat}:checked`).forEach(input => {
            subtotal += parseInt(input.value);
        });
        document.getElementById(`subtotal_${cat}`).textContent = subtotal;
        total += subtotal;
    });

    document.getElementById('total_general').textContent = total;
    generarConclusion(total);
}

function generarConclusion(puntajeTotal) {
    let conclusion = '';
    if (puntajeTotal < 30) {
        conclusion = 'Estamos en un mercado altamente competitivo, en el que es muy difícil hacerse un hueco en el mercado.';
    } else if (puntajeTotal < 45) {
        conclusion = 'Competitividad relativamente alta, pero se puede encontrar un nicho de mercado con ajustes.';
    } else if (puntajeTotal < 60) {
        conclusion = 'La situación actual del mercado es favorable a la empresa.';
    } else {
        conclusion = 'Estamos en una situación excelente para la empresa.';
    }
    document.getElementById('conclusion').value = conclusion;
}

function addItem(type) {
    const container = document.getElementById(`${type}-container`);
    const index = container.children.length + 1;
    const newItem = document.createElement('div');
    newItem.classList.add('flex', 'gap-3', 'mb-2');
    newItem.innerHTML = `
        <input type=\"text\" name=\"${type}[]\" class=\"w-full p-3 border border-gray-300 rounded\" placeholder=\"${type.slice(0, -1)} ${index}\" />
        <button type=\"button\" onclick=\"removeItem(this)\" class=\"bg-red-500 text-white px-2 rounded\">Eliminar</button>
    `;
    container.appendChild(newItem);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>
@endsection
