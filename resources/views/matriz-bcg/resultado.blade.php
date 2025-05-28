@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <span>📊</span> Visualización de Matriz BCG
    </h2>

    <div class="bg-white shadow-md rounded p-4">
        <canvas id="bcgChart" style="height: 500px;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>

<script>
    Chart.register(window['chartjs-plugin-annotation']);
    const productos = @json($matriz->productos);
    const ventas = @json($matriz->ventas);
    const tcm = @json($matriz->tcm);
    const maxVenta = Math.max(...ventas);

    const tcmPromedios = tcm[0].map((_, i) => {
        return tcm.reduce((sum, fila) => sum + parseFloat(fila[i] || 0), 0) / tcm.length;
    });

    const mediaVentas = ventas.reduce((a, b) => a + b, 0) / ventas.length;
    const mediaTCM = tcmPromedios.reduce((a, b) => a + b, 0) / tcmPromedios.length;

    const colors = ['#e74c3c', '#f1c40f', '#2ecc71', '#1abc9c', '#3498db'];

    const data = {
        datasets: productos.map((prod, i) => ({
            label: prod,
            data: [{
                x: ventas[i],
                y: tcmPromedios[i],
                r: 10 + (ventas[i] / maxVenta) * 30
            }],
            backgroundColor: colors[i % colors.length],
            borderColor: '#333',
            borderWidth: 1
        }))
    };

    new Chart(document.getElementById('bcgChart'), {
        type: 'bubble',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 14 } }
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(ctx) {
                            return `${ctx.dataset.label}: TCM ${ctx.raw.y.toFixed(2)}%, Ventas ${ctx.raw.x}`;
                        }
                    }
                },
                
                annotation: {
                    annotations: {
                        // Cuadrante Estrella (↑TCM, ↑Ventas)
                        cuadranteEstrella: {
                            type: 'box',
                            xMin: mediaVentas,
                            xMax: 1000,
                            yMin: mediaTCM,
                            yMax: 5,
                            backgroundColor: 'rgba(52, 152, 219, 0.08)' // azul
                        },
                        // Cuadrante Incógnita (↑TCM, ↓Ventas)
                        cuadranteIncognita: {
                            type: 'box',
                            xMin: 0,
                            xMax: mediaVentas,
                            yMin: mediaTCM,
                            yMax: 5,
                            backgroundColor: 'rgba(241, 196, 15, 0.08)' // amarillo
                        },
                        // Cuadrante Vaca (↓TCM, ↑Ventas)
                        cuadranteVaca: {
                            type: 'box',
                            xMin: mediaVentas,
                            xMax: 1000,
                            yMin: 0,
                            yMax: mediaTCM,
                            backgroundColor: 'rgba(46, 204, 113, 0.08)' // verde
                        },
                        // Cuadrante Perro (↓TCM, ↓Ventas)
                        cuadrantePerro: {
                            type: 'box',
                            xMin: 0,
                            xMax: mediaVentas,
                            yMin: 0,
                            yMax: mediaTCM,
                            backgroundColor: 'rgba(231, 76, 60, 0.08)' // rojo
                        },
                        // Línea media TCM
                        lineaHorizontal: {
                            type: 'line',
                            yMin: mediaTCM,
                            yMax: mediaTCM,
                            borderColor: 'gray',
                            borderDash: [5, 5],
                            borderWidth: 1,
                            label: {
                                display: true,
                                content: 'Media TCM',
                                position: 'end'
                            }
                        },
                        // Línea media Ventas
                        lineaVertical: {
                        type: 'line',
                        xMin: mediaVentas,
                        xMax: mediaVentas,
                        borderColor: 'gray',
                        borderDash: [5, 5],
                        borderWidth: 1,
                        scaleID: 'x',      // Para compatibilidad amplia
                        xScaleID: 'x',     // Para Chart.js moderno
                        label: {
                            display: true,
                            content: 'Media Ventas',
                            position: 'start'  // O usa 'center' si no se ve
                        }
                    }
                    }
                }
            },
            scales: {
                x: {
                    min: 0,
                    max: 1000,
                    title: { display: true, text: 'Participación de Mercado (Ventas)' }
                },
                y: {
                    min: 0,
                    max: 5,
                    title: { display: true, text: 'Tasa de Crecimiento del Mercado (%)' },
                    ticks: {
                        callback: value => value + '%'
                    }
                }
            }
        }
    });
</script>
@endsection
