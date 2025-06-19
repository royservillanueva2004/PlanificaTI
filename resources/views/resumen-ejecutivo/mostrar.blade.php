@extends('layouts.app')

@section('content')
<div class="container py-5 pb-40">
    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <div class="card-body">
            <h2 class="text-center text-primary mb-4">
                <i class="bi bi-clipboard2-check-fill"></i> Resumen Ejecutivo del Plan Estratégico
            </h2>

            <p><strong><i class="bi bi-building"></i> Nombre del proyecto:</strong> {{ $plan->nombre_plan }}</p>
            <p><strong><i class="bi bi-calendar-event"></i> Fecha de elaboración:</strong> {{ $plan->created_at->format('d/m/Y') }}</p>
            <p><strong><i class="bi bi-person-badge"></i> Emprendedores / Promotores:</strong> {{ $resumen->promotores }}</p>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('resumen-ejecutivo.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="bi bi-pencil-square"></i> Editar Promotores
            </a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-bold">MISIÓN</div>
                <div class="card-body">
                    <p class="mb-0">{{ $plan->mision }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-bold">VISIÓN</div>
                <div class="card-body">
                    <p class="mb-0">{{ $plan->vision }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-secondary text-white fw-bold">VALORES</div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $valores = is_array($plan->valores) ? $plan->valores : explode(',', $plan->valores);
                    @endphp

                    @forelse($valores as $valor)
                        <span class="badge bg-primary fs-6">{{ trim($valor) }}</span>
                    @empty
                        <p>No se han registrado valores.</p>
                    @endforelse
                </div>
            </div>

    </div>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-dark text-white fw-bold">UNIDADES ESTRATÉGICAS DE NEGOCIO</div>
        <div class="card-body">
            @forelse($uens as $uen)
                <p class="mb-1">🔹 {{ $uen->descripcion }}</p>
            @empty
                <p class="text-muted">No se han definido unidades estratégicas aún.</p>
            @endforelse
        </div>
    </div>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-success text-white fw-bold">OBJETIVOS ESTRATÉGICOS</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-success text-center">
                        <tr>
                            <th class="align-middle" style="width: 30%">MISIÓN</th>
                            <th class="align-middle" style="width: 35%">OBJETIVOS GENERALES O ESTRATÉGICOS</th>
                            <th class="align-middle" style="width: 35%">OBJETIVOS ESPECÍFICOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $primeraFila = true; @endphp
                        @forelse($objetivosGenerales as $general)
                            <tr>
                                @if ($primeraFila)
                                    <td class="align-middle text-center" rowspan="{{ $objetivosGenerales->count() }}">
                                        <div class="d-flex align-items-center justify-content-center h-100 px-3" style="text-align: justify;">
                                            {{ $plan->mision }}
                                        </div>
                                    </td>
                                    @php $primeraFila = false; @endphp
                                @endif

                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center h-100 px-3" style="text-align: justify;">
                                        {{ $general->descripcion }}
                                    </div>
                                </td>

                                <td class="align-middle text-center">
                                    <div class="px-3">
                                        @if ($general->especificos->isNotEmpty())
                                            <ul class="mb-0 ps-3">
                                                @foreach($general->especificos as $especifico)
                                                    <li class="text-start" style="text-align: justify;">
                                                        {{ $especifico->descripcion }}
                                                    </li>
                                                    @if (!$loop->last)
                                                        <hr class="my-2">
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <em class="text-muted">Sin objetivos específicos</em>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No se han registrado objetivos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-dark text-white fw-bold">ANÁLISIS FODA</div>
        <div class="card-body row g-4">
            <div class="col-md-6">
                <h6 class="text-success">Fortalezas</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['fortaleza'] ?? [] as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Oportunidades</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['oportunidad'] ?? [] as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-danger">Debilidades</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['debilidad'] ?? [] as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-warning">Amenazas</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['amenaza'] ?? [] as $item)
                        <li class="list-group-item">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-info text-white fw-bold">IDENTIFICACIÓN DE ESTRATEGIA</div>
        <div class="card-body">
        
            <div class="mb-3">
                <textarea id="estrategia-generada" class="form-control border border-primary" rows="6" readonly style="resize: none;">
                {{ $resumen->identificacion_estrategica ?? 'Estrategia aún no generada.' }}
                </textarea>
            </div>

            <div class="text-center">
                <button id="btn-generar-estrategia" class="btn btn-outline-info">
                    <i class="bi bi-stars"></i> Generar Estrategia
                </button>

                @push('scripts')
                <script>
                const textarea = document.getElementById('estrategia-generada');
                const btn = document.getElementById('btn-generar-estrategia');

                function autoResizeTextarea() {
                    textarea.style.height = 'auto';
                    textarea.style.height = textarea.scrollHeight + 'px';
                }

                btn.addEventListener('click', async function () {
                    btn.disabled = true;
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Generando...`;

                    try {
                        const response = await fetch("{{ route('resumen-ejecutivo.estrategia') }}");

                        if (!response.ok) throw new Error("Respuesta no válida del servidor");

                        const data = await response.json();

                        if (data.estrategia) {
                            textarea.value = data.estrategia;
                            autoResizeTextarea();
                        } else if (data.error) {
                            alert("Error: " + data.error);
                        } else {
                            alert("No se pudo generar la estrategia.");
                        }
                    } catch (error) {
                        alert("Error al generar la estrategia: " + error.message);
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = `<i class="bi bi-stars"></i> Generar Estrategia`;
                    }
                });
                </script>
                @endpush
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-primary text-white fw-bold">ACCIONES COMPETITIVAS - MATRIZ CAME</div>
        <div class="card-body p-0">
            @php
                $grupos = ['C' => 'Corregir', 'A' => 'Afrontar', 'M' => 'Mantener', 'E' => 'Explotar'];
                $accionesAgrupadas = [];

                foreach ($grupos as $clave => $nombre) {
                    $accionesAgrupadas[$clave] = $matrizCame->where('tipo', $clave)->values()->all();
                }

                $filas = max(array_map(fn($a) => count($a), $accionesAgrupadas));
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            @foreach($grupos as $nombre)
                                <th>{{ $nombre }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < $filas; $i++)
                            <tr>
                                @foreach($grupos as $clave => $nombre)
                                    <td class="text-start">
                                        {{ $accionesAgrupadas[$clave][$i]->accion ?? '' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-primary text-white fw-bold">CONCLUSIONES</div>
        <div class="card-body">
            <p id="texto-conclusion" style="text-align: justify;">
                {{ $resumen->conclusiones ?? 'No se han registrado conclusiones.' }}
            </p>
        </div>
        <div class="text-center mt-3">
            <button id="btn-generar-conclusion" class="btn btn-outline-info">
                <i class="bi bi-robot"></i> Generar Conclusión
            </button>
        </div>
    </div>
    
   
    <div class="text-center mt-5 mb-5">
        <a href="{{ route('resumen-ejecutivo.pdf') }}" class="btn btn-outline-danger btn-lg">
            <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
        </a>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const btnConclusion = document.getElementById('btn-generar-conclusion');
    const pConclusion = document.getElementById('texto-conclusion');

    btnConclusion.addEventListener('click', async function () {
        btnConclusion.disabled = true;
        btnConclusion.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Generando...`;

        try {
            const response = await fetch("{{ route('resumen-ejecutivo.conclusiones') }}");

            if (!response.ok) throw new Error("Respuesta inválida del servidor");

            const data = await response.json();

            if (data.conclusion) {
                pConclusion.innerHTML = data.conclusion.replace(/\n/g, "<br>");
                pConclusion.classList.remove('text-muted');
            } else if (data.error) {
                alert("Error: " + data.error);
            } else {
                alert("No se pudo generar la conclusión.");
            }
        } catch (error) {
            alert("Error al generar conclusión: " + error.message);
        } finally {
            btnConclusion.disabled = false;
            btnConclusion.innerHTML = `<i class="bi bi-robot"></i> Generar Conclusión con IA`;
        }
    });
</script>
@endpush