@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 pb-24">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <span>📊</span> Visualización de Matriz BCG
    </h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

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

    const maxVenta = Math.ceil(Math.max(...ventas, 1000) * 1.1);
    const tcmPromedios = tcm[0].map((_, i) => {
        return tcm.reduce((sum, fila) => sum + parseFloat(fila[i] || 0), 0) / tcm.length;
    });

    const mediaVentas = ventas.reduce((a, b) => a + b, 0) / ventas.length;
    const mediaTCM = tcmPromedios.reduce((a, b) => a + b, 0) / tcmPromedios.length;

    const colors = ['#e74c3c', '#f1c40f', '#2ecc71', '#1abc9c', '#3498db', '#8e44ad', '#e67e22'];

    const data = {
        datasets: productos.map((producto, i) => ({
            label: producto,
            data: [{
                x: ventas[i],
                y: tcmPromedios[i],
                r: Math.max(10, (ventas[i] / maxVenta) * 40)
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
                        label: ctx => `${ctx.dataset.label}: TCM ${ctx.raw.y.toFixed(2)}%, Ventas ${ctx.raw.x}`
                    }
                },
                annotation: {
                    annotations: {
                        cuadranteEstrella: {
                            type: 'box',
                            xMin: mediaVentas,
                            xMax: maxVenta,
                            yMin: mediaTCM,
                            yMax: 5,
                            backgroundColor: 'rgba(52, 152, 219, 0.1)'
                        },
                        cuadranteIncognita: {
                            type: 'box',
                            xMin: 0,
                            xMax: mediaVentas,
                            yMin: mediaTCM,
                            yMax: 5,
                            backgroundColor: 'rgba(241, 196, 15, 0.1)'
                        },
                        cuadranteVaca: {
                            type: 'box',
                            xMin: mediaVentas,
                            xMax: maxVenta,
                            yMin: 0,
                            yMax: mediaTCM,
                            backgroundColor: 'rgba(46, 204, 113, 0.1)'
                        },
                        cuadrantePerro: {
                            type: 'box',
                            xMin: 0,
                            xMax: mediaVentas,
                            yMin: 0,
                            yMax: mediaTCM,
                            backgroundColor: 'rgba(231, 76, 60, 0.1)'
                        },
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
                                position: 'end',
                                color: 'gray'
                            }
                        },
                        lineaVertical: {
                            type: 'line',
                            xMin: mediaVentas,
                            xMax: mediaVentas,
                            borderColor: 'gray',
                            borderDash: [5, 5],
                            borderWidth: 1,
                            label: {
                                display: true,
                                content: 'Media Ventas',
                                position: 'start',
                                color: 'gray'
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    min: 0,
                    max: maxVenta,
                    title: {
                        display: true,
                        text: 'Participación de Mercado (Ventas)',
                        font: { size: 14 }
                    }
                },
                y: {
                    min: 0,
                    max: 5,
                    title: {
                        display: true,
                        text: 'Tasa de Crecimiento del Mercado (%)',
                        font: { size: 14 }
                    },
                    ticks: {
                        callback: value => value + '%'
                    }
                }
            }
        }
    });
</script>
@endsection
