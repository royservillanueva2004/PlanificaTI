@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">📊 Matriz de Crecimiento - Participación BCG</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('matriz-bcg.store') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">

        {{-- Productos --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Productos</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @for ($i = 0; $i < 5; $i++)
                    <input type="text" id="producto_{{ $i }}" name="productos[]" class="p-2 border border-gray-300 rounded" value="{{ $matriz->productos[$i] ?? 'Producto '.($i+1) }}">
                @endfor
            </div>
        </div>

        {{-- Ventas --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Previsión de Ventas</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @for ($i = 0; $i < 5; $i++)
                    <input type="number" step="0.01" id="venta_{{ $i }}" name="ventas[]" class="p-2 border border-gray-300 rounded" value="{{ $matriz->ventas[$i] ?? 0 }}">
                @endfor
            </div>
        </div>

        {{-- TCM --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Tasa de Crecimiento del Mercado (TCM)</h3>
            <table class="table-auto w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Año</th>
                        @foreach($matriz->productos ?? ['Producto 1','Producto 2','Producto 3','Producto 4','Producto 5'] as $i => $prod)
                            <th class="p-2 border" id="tcm_header_{{ $i }}">{{ $prod }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for ($a = 0; $a < 5; $a++)
                        <tr>
                            <td class="p-2 border">{{ 2020 + $a }}</td>
                            @for ($p = 0; $p < 5; $p++)
                                <td class="p-2 border">
                                    <input type="number" step="0.01" id="tcm_{{ $a }}_{{ $p }}" name="tcm[{{ $a }}][{{ $p }}]" class="w-full border p-1" value="{{ $matriz->tcm[$a][$p] ?? 0 }}">
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        {{-- Demanda Global del Sector --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">📈 Evolución de la Demanda Global del Sector (en miles de soles)</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-300 text-center">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">AÑO</th>
                            @for ($i = 0; $i < 5; $i++)
                                <th class="p-2 border" id="demanda_header_{{ $i }}">{{ $matriz->productos[$i] ?? 'Producto '.($i+1) }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for ($a = 0; $a < 6; $a++)
                            <tr>
                                <td class="p-2 border">{{ 2020 + $a }}</td>
                                @for ($p = 0; $p < 5; $p++)
                                    <td class="p-2 border">
                                        <input type="number" step="0.01" name="demanda_global[{{ $a }}][{{ $p }}]" id="demanda_global{{ $a }}_{{ $p }}"
                                            class="w-full border p-1" value="{{ $matriz->demanda_global[$a][$p] ?? 0 }}">
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Competidores --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Niveles de Venta de los Competidores</h3>
            <table class="table-auto w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Competidor</th>
                        @for ($i = 0; $i < 5; $i++)
                            <th class="p-2 border"><span id="comp_header_{{ $i }}">{{ $matriz->productos[$i] ?? 'Producto '.($i+1) }}</span></th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @for ($r = 0; $r < 10; $r++)
                        <tr>
                            <td class="border p-2">Competidor {{ $r + 1 }}</td>
                            @for ($p = 0; $p < 5; $p++)
                                <td class="border p-2">
                                    <input type="number" step="0.01" id="competidor_{{ $r }}_{{ $p }}" name="competidores[{{ $r }}][{{ $p }}]" class="w-full border p-1" value="{{ $matriz->competidores[$r][$p] ?? 0 }}">
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        {{-- Tabla resumen BCG --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">📌 Resultados Resumen BCG</h3>
            <table class="table-auto w-full border border-gray-300 text-center text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">BCG</th>
                        @for ($i = 0; $i < 5; $i++)
                            <th class="p-2 border"><span id="res_header_{{ $i }}">{{ $matriz->productos[$i] ?? 'Producto '.($i+1) }}</span></th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border">TCM</td>
                        @for ($i = 0; $i < 5; $i++)
                            <td class="p-2 border"><span id="res_tcm_{{ $i }}">0.00%</span></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="p-2 border">PRM</td>
                        @for ($i = 0; $i < 5; $i++)
                            <td class="p-2 border"><span id="res_prm_{{ $i }}">0.00</span></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="p-2 border">% S/ VTAS</td>
                        @for ($i = 0; $i < 5; $i++)
                            <td class="p-2 border"><span id="res_pct_{{ $i }}">0%</span></td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Guardar matriz
            </button>
        </div>
    </form>
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const numProd = 5;
    const numAnios = 5;
    const numComp = 10;

    function updateResumen() {
        const productos = [];
        const ventas = [];

        // Productos → actualizar encabezados en todas las tablas
        for (let i = 0; i < numProd; i++) {
            const nombre = document.getElementById(`producto_${i}`).value || `Producto ${i + 1}`;
            productos[i] = nombre;

            document.getElementById(`res_header_${i}`).innerText = nombre;
            document.getElementById(`comp_header_${i}`).innerText = nombre;

            const thTcm = document.getElementById(`tcm_header_${i}`);
            if (thTcm) thTcm.innerText = nombre;

            const thDemanda = document.getElementById(`demanda_header_${i}`);
            if (thDemanda) thDemanda.innerText = nombre;
        }

        // Ventas
        for (let i = 0; i < numProd; i++) {
            ventas[i] = parseFloat(document.getElementById(`venta_${i}`).value) || 0;
        }

        // TCM Promedio
        for (let i = 0; i < numProd; i++) {
            let suma = 0;
            for (let a = 0; a < numAnios; a++) {
                suma += parseFloat(document.getElementById(`tcm_${a}_${i}`).value) || 0;
            }
            const promedio = suma / numAnios;
            const limitado = promedio > 20 ? 20 : promedio;
            document.getElementById(`res_tcm_${i}`).innerText = limitado.toFixed(2) + '%';
        }

        // PRM
        for (let i = 0; i < numProd; i++) {
            let max = 0;
            for (let r = 0; r < numComp; r++) {
                const val = parseFloat(document.getElementById(`competidor_${r}_${i}`).value) || 0;
                if (val > max) max = val;
            }

            const venta = ventas[i];
            const ratio = max > 0 ? venta / max : 0;
            const prm = ratio > 2 ? 2 : ratio;
            document.getElementById(`res_prm_${i}`).innerText = prm.toFixed(2);
        }

        // % S/VTAS
        const totalVentas = ventas.reduce((a, b) => a + b, 0);
        for (let i = 0; i < numProd; i++) {
            const pct = totalVentas > 0 ? Math.round((ventas[i] / totalVentas) * 100) : 0;
            document.getElementById(`res_pct_${i}`).innerText = pct + '%';
        }
    }

    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', updateResumen);
    });

    updateResumen();
});
</script>
@endsection
