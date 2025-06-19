@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 pb-24">
    <h2 class="text-2xl font-bold mb-6">📊 Matriz de Crecimiento - Participación BCG</h2>

    {{-- Configuración dinámica --}}
    <div class="mb-6 bg-gray-50 p-4 rounded border">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="font-semibold">Número de productos</label>
                <input type="number" id="numProductos" class="w-full border p-2 rounded" value="5" min="1">
            </div>
            <div>
                <label class="font-semibold">Año inicio</label>
                <input type="number" id="anioInicio" class="w-full border p-2 rounded" value="2020">
            </div>
            <div>
                <label class="font-semibold">Año fin</label>
                <input type="number" id="anioFin" class="w-full border p-2 rounded" value="2024">
            </div>
            <div>
                <label class="font-semibold">N° Competidores</label>
                <input type="number" id="numCompetidores" class="w-full border p-2 rounded" value="5" min="1">
            </div>
        </div>

        <div class="mt-4 text-right">
            <button type="button" onclick="generarFormulario()" class="bg-blue-600 text-white px-4 py-2 rounded">
                Generar formulario dinámico
            </button>
        </div>
    </div>

    {{-- Formulario generado --}}
    <form method="POST" action="{{ route('matriz-bcg.store') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ session('plan_id') }}">
        
        <div id="formulario-dinamico"></div>

        <div class="text-center mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-semibold">
                💾 Guardar Matriz BCG
            </button>
        </div>

        {{-- Resumen BCG --}}
        <div class="mb-6 mt-8">
            <h3 class="font-semibold mb-2">📌 Resultados Resumen BCG</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border text-center text-sm" id="tabla-resumen-bcg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">BCG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="p-2 border">TCM</td></tr>
                        <tr><td class="p-2 border">PRM</td></tr>
                        <tr><td class="p-2 border">% S/ VTAS</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function generarFormulario() {
    const productos = parseInt(document.getElementById('numProductos').value);
    const anioInicio = parseInt(document.getElementById('anioInicio').value);
    const anioFin = parseInt(document.getElementById('anioFin').value);
    const competidores = parseInt(document.getElementById('numCompetidores').value);

    if (anioFin < anioInicio || productos <= 0 || competidores <= 0) {
        alert("Verifica que los datos ingresados sean válidos.");
        return;
    }

    const anios = [];
    for (let a = anioInicio; a <= anioFin; a++) anios.push(a);

    const container = document.getElementById('formulario-dinamico');
    let html = '';

    // Productos
    html += `<div class="mb-6"><h3 class="font-semibold mb-2">📦 Productos</h3><div class="grid grid-cols-1 md:grid-cols-${Math.min(productos, 5)} gap-3">`;
    for (let i = 0; i < productos; i++) {
        html += `<input type="text" name="productos[]" id="producto_${i}" value="Producto ${i+1}" class="border p-2 rounded" oninput="actualizarEncabezados()">`;
    }
    html += `</div></div>`;

    // Ventas
    html += `<div class="mb-6"><h3 class="font-semibold mb-2">📊 Ventas</h3><div class="grid grid-cols-1 md:grid-cols-${Math.min(productos, 5)} gap-3">`;
    for (let i = 0; i < productos; i++) {
        html += `<input type="number" name="ventas[]" step="0.01" value="0" class="border p-2 rounded">`;
    }
    html += `</div></div>`;

    // TCM
    html += `<div class="mb-6"><h3 class="font-semibold mb-2">📈 Tasa de Crecimiento del Mercado (TCM)</h3>`;
    html += `<div class="overflow-x-auto"><table class="table-auto w-full border"><thead><tr><th class="border p-2">Año</th>`;
    for (let i = 0; i < productos; i++) {
        html += `<th class="border p-2 encabezado_producto" id="enc_tcm_${i}">Producto ${i+1}</th>`;
    }
    html += `</tr></thead><tbody>`;
    anios.forEach((anio, ai) => {
        html += `<tr><td class="border p-2">${anio}</td>`;
        for (let j = 0; j < productos; j++) {
            html += `<td class="border p-2"><input type="number" name="tcm[${ai}][${j}]" class="w-full border p-1" step="0.01" value="0"></td>`;
        }
        html += `</tr>`;
    });
    html += `</tbody></table></div></div>`;

    // Demanda Global
    html += `<div class="mb-6"><h3 class="font-semibold mb-2">🌐 Demanda Global del Sector</h3>`;
    html += `<div class="overflow-x-auto"><table class="table-auto w-full border"><thead><tr><th class="border p-2">Año</th>`;
    for (let i = 0; i < productos; i++) {
        html += `<th class="border p-2 encabezado_producto" id="enc_dem_${i}">Producto ${i+1}</th>`;
    }
    html += `</tr></thead><tbody>`;
    anios.forEach((anio, ai) => {
        html += `<tr><td class="border p-2">${anio}</td>`;
        for (let j = 0; j < productos; j++) {
            html += `<td class="border p-2"><input type="number" name="demanda_global[${ai}][${j}]" class="w-full border p-1" step="0.01" value="0"></td>`;
        }
        html += `</tr>`;
    });
    html += `</tbody></table></div></div>`;

    // Competidores
    html += `<div class="mb-6"><h3 class="font-semibold mb-2">🏢 Ventas de Competidores</h3>`;
    html += `<div class="overflow-x-auto"><table class="table-auto w-full border"><thead><tr><th class="border p-2">Competidor</th>`;
    for (let i = 0; i < productos; i++) {
        html += `<th class="border p-2 encabezado_producto" id="enc_comp_${i}">Producto ${i+1}</th>`;
    }
    html += `</tr></thead><tbody>`;
    for (let c = 0; c < competidores; c++) {
        html += `<tr><td class="border p-2">Competidor ${c+1}</td>`;
        for (let j = 0; j < productos; j++) {
            html += `<td class="border p-2"><input type="number" name="competidores[${c}][${j}]" class="w-full border p-1" step="0.01" value="0"></td>`;
        }
        html += `</tr>`;
    }
    html += `</tbody></table></div></div>`;

    container.innerHTML = html;
    generarResumenBCG(productos);

    setTimeout(() => {
        document.querySelectorAll('#formulario-dinamico input').forEach(input => {
            input.addEventListener('input', actualizarResumen);
        });
    }, 100);
}

function generarResumenBCG(productos) {
    const tabla = document.getElementById('tabla-resumen-bcg');
    const thead = tabla.querySelector('thead tr');
    const tcmRow = tabla.querySelectorAll('tbody tr')[0];
    const prmRow = tabla.querySelectorAll('tbody tr')[1];
    const pctRow = tabla.querySelectorAll('tbody tr')[2];

    while (thead.children.length > 1) thead.removeChild(thead.lastChild);
    [tcmRow, prmRow, pctRow].forEach(row => {
        while (row.children.length > 1) row.removeChild(row.lastChild);
    });

    for (let i = 0; i < productos; i++) {
        const th = document.createElement('th');
        th.className = 'p-2 border encabezado_producto';
        th.id = `enc_res_${i}`;
        th.textContent = `Producto ${i+1}`;
        thead.appendChild(th);

        const td1 = document.createElement('td');
        td1.className = 'p-2 border';
        td1.innerHTML = `<span id="res_tcm_${i}">0.00%</span>`;
        tcmRow.appendChild(td1);

        const td2 = document.createElement('td');
        td2.className = 'p-2 border';
        td2.innerHTML = `<span id="res_prm_${i}">0.00</span>`;
        prmRow.appendChild(td2);

        const td3 = document.createElement('td');
        td3.className = 'p-2 border';
        td3.innerHTML = `<span id="res_pct_${i}">0%</span>`;
        pctRow.appendChild(td3);
    }
}

function actualizarResumen() {
    const productos = document.querySelectorAll('input[name="productos[]"]');
    const ventasInputs = document.querySelectorAll('input[name="ventas[]"]');
    const tcmInputs = document.querySelectorAll('input[name^="tcm["]');
    const compInputs = document.querySelectorAll('input[name^="competidores["]');

    const numProductos = productos.length;
    const anios = tcmInputs.length / numProductos;
    const competidores = compInputs.length / numProductos;

    const ventas = [];
    let totalVentas = 0;

    ventasInputs.forEach((v, i) => {
        const val = parseFloat(v.value) || 0;
        ventas[i] = val;
        totalVentas += val;
    });

    ventas.forEach((v, i) => {
        const pct = totalVentas > 0 ? Math.round((v / totalVentas) * 100) : 0;
        document.getElementById(`res_pct_${i}`).textContent = pct + "%";
    });

    for (let i = 0; i < numProductos; i++) {
        let suma = 0;
        for (let a = 0; a < anios; a++) {
            const tcm = document.querySelector(`input[name="tcm[${a}][${i}]"]`);
            suma += parseFloat(tcm?.value || 0);
        }
        const prom = suma / anios;
        document.getElementById(`res_tcm_${i}`).textContent = prom.toFixed(2) + "%";
    }

    for (let i = 0; i < numProductos; i++) {
        let max = 0;
        for (let c = 0; c < competidores; c++) {
            const comp = document.querySelector(`input[name="competidores[${c}][${i}]"]`);
            const val = parseFloat(comp?.value || 0);
            if (val > max) max = val;
        }
        const ratio = max > 0 ? ventas[i] / max : 0;
        const limitado = ratio > 2 ? 2 : ratio;
        document.getElementById(`res_prm_${i}`).textContent = limitado.toFixed(2);
    }

    // Encabezados
    productos.forEach((input, i) => {
        const nombre = input.value || `Producto ${i+1}`;
        document.querySelectorAll(`#enc_tcm_${i}, #enc_dem_${i}, #enc_comp_${i}, #enc_res_${i}`).forEach(el => {
            if (el) el.textContent = nombre;
        });
    });
}

function actualizarEncabezados() {
    actualizarResumen();
}
</script>
@if($matriz)
<script>
    window.addEventListener('DOMContentLoaded', function () {
        // 1. Llenar los inputs iniciales
        document.getElementById('numProductos').value = {{ $productos }};
        document.getElementById('anioInicio').value = {{ $anioInicio }};
        document.getElementById('anioFin').value = {{ $anioFin }};
        document.getElementById('numCompetidores').value = {{ $competidores }};

        // 2. Generar el formulario
        generarFormulario();

        // 3. Esperar a que el DOM termine de generar el formulario y luego llenar los valores
        setTimeout(() => {
            const datos = @json($matriz);

            // Productos
            datos.productos.forEach((p, i) => {
                const input = document.getElementById(`producto_${i}`);
                if (input) input.value = p;
            });

            // Ventas
            datos.ventas.forEach((v, i) => {
                const input = document.getElementsByName('ventas[]')[i];
                if (input) input.value = v;
            });

            // TCM
            datos.tcm.forEach((fila, fi) => {
                fila.forEach((valor, vi) => {
                    const input = document.querySelector(`input[name="tcm[${fi}][${vi}]"]`);
                    if (input) input.value = valor;
                });
            });

            // Demanda Global
            datos.demanda_global.forEach((fila, fi) => {
                fila.forEach((valor, vi) => {
                    const input = document.querySelector(`input[name="demanda_global[${fi}][${vi}]"]`);
                    if (input) input.value = valor;
                });
            });

            // Competidores
            datos.competidores.forEach((fila, fi) => {
                fila.forEach((valor, vi) => {
                    const input = document.querySelector(`input[name="competidores[${fi}][${vi}]"]`);
                    if (input) input.value = valor;
                });
            });

            // Actualiza los encabezados y cálculos del resumen
            actualizarResumen();
        }, 500); // aseguramos que el DOM esté listo
    });
</script>
@endif
@endpush
