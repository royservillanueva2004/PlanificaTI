<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resumen Ejecutivo</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { color: #2c3e50; }
        .seccion { margin-bottom: 20px; }
        .titulo { background-color: #eee; padding: 5px; font-weight: bold; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>

    <h2 align="center">Resumen Ejecutivo del Plan Estratégico</h2>

    <div class="seccion">
        <div class="titulo">Nombre del Proyecto:</div>
        <p>{{ $plan->nombre_plan }}</p>

        <div class="titulo">Fecha:</div>
        <p>{{ $plan->created_at->format('d/m/Y') }}</p>

        <div class="titulo">Promotores:</div>
        <p>{{ $resumen->promotores }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Misión:</div>
        <p>{{ $plan->mision }}</p>

        <div class="titulo">Visión:</div>
        <p>{{ $plan->vision }}</p>

        <div class="titulo">Valores:</div>
        <p>{{ is_array($plan->valores) ? implode(', ', $plan->valores) : $plan->valores }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Objetivos Estratégicos:</div>
        <ul>
        @foreach($objetivos as $obj)
            <li><strong>{{ $obj->descripcion }}</strong>
                <ul>
                    @foreach($obj->especificos as $esp)
                        <li>{{ $esp->descripcion }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        </ul>
    </div>

    <div class="seccion">
        <div class="titulo">Análisis FODA:</div>
        <p><strong>Fortalezas:</strong> {{ implode('; ', $foda['fortaleza']) }}</p>
        <p><strong>Debilidades:</strong> {{ implode('; ', $foda['debilidad']) }}</p>
        <p><strong>Oportunidades:</strong> {{ implode('; ', $foda['oportunidad']) }}</p>
        <p><strong>Amenazas:</strong> {{ implode('; ', $foda['amenaza']) }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Identificación Estratégica:</div>
        <p>{{ $resumen->identificacion_estrategica }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Acciones CAME:</div>
        @php
            $tipos = ['C' => 'Corregir', 'A' => 'Afrontar', 'M' => 'Mantener', 'E' => 'Explotar'];
        @endphp
        @foreach($tipos as $tipo => $nombre)
            <p><strong>{{ $nombre }}:</strong></p>
            <ul>
                @foreach($matrizCame->where('tipo', $tipo) as $accion)
                    <li>{{ $accion->accion }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>

    <div class="seccion">
        <div class="titulo">Conclusiones:</div>
        <p>{{ $resumen->conclusiones }}</p>
    </div>

</body>
</html>
