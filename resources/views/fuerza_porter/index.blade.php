@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 min-h-screen">
    <h2 class="text-2xl font-semibold mb-5">Análisis 5 Fuerzas de Porter</h2>

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

    <form method="POST" action="{{ route('fuerza_porter.store') }}" id="porterForm" class="mb-20">
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

        <div class="overflow-x-auto shadow-xl sm:rounded-lg mb-8">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Perfil Competitivo</th>
                        @for ($i = 1; $i <= 5; $i++)
                            <th class="border border-gray-300 px-2 py-2 text-center">{{ $i }}<br>
                                <small>{{ ['Nada', 'Poco', 'Medio', 'Alto', 'Muy Alto'][$i-1] }}</small>
                            </th>
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
                                        <input type="radio" name="{{ $name }}" value="{{ $i }}"
                                            class="mx-auto {{ $categoria }}"
                                            onclick="calcularPuntaje()" @if(isset($registro) && $registro->$name == $i) checked @endif required>
                                    </td>
                                @endfor
                                <td class="border border-gray-300 text-center">
                                    <span id="puntaje_{{ $name }}">@if(isset($registro)) {{ $registro->$name }} @else 0 @endif</span>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border border-gray-300 font-semibold px-4 py-2">Subtotal {{ ucfirst($categoria) }}</td>
                            <td colspan="5" class="border border-gray-300"></td>
                            <td class="border border-gray-300 text-center font-semibold">
                                <span id="subtotal_{{ $categoria }}">0</span>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 font-semibold text-lg">TOTAL GENERAL</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold text-lg">
                            <span id="total_general">0</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Botón mejorado --}}
        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-300">
                <i class="bi bi-check-circle-fill"></i>
                Guardar análisis
            </button>
        </div>
    </form>
</div>

{{-- JS para cálculo en tiempo real --}}
<script>
function calcularPuntaje() {
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
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
}
window.addEventListener('DOMContentLoaded', calcularPuntaje);
</script>
@endsection
