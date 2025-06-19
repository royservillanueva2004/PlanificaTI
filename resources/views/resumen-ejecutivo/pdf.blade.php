<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen Ejecutivo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2c3e50;
            line-height: 1.6;
            margin: 30px;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            color: #1f4e79;
            margin-bottom: 25px;
        }

        .seccion {
            margin-bottom: 24px;
            padding: 14px 16px;
            border: 1px solid #d0d7de;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .titulo {
            background-color: #1f4e79;
            color: #ffffff;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 13px;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        p {
            text-align: justify;
            margin: 6px 0;
        }

        ul {
            padding-left: 18px;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
            text-align: justify;
        }

        .espaciado {
            margin-top: 8px;
        }
    </style>
</head>
<body>

    <h2>Resumen Ejecutivo del Plan Estratégico</h2>

    <div class="seccion">
        <div class="titulo">Nombre del Proyecto</div>
        <p>{{ $plan->nombre_plan }}</p>

        <div class="titulo">Fecha de Elaboración</div>
        <p>{{ $plan->created_at->format('d/m/Y') }}</p>

        <div class="titulo">Promotores</div>
        <p>{{ $resumen->promotores }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Misión</div>
        <p>{{ $plan->mision }}</p>

        <div class="titulo">Visión</div>
        <p>{{ $plan->vision }}</p>

        <div class="titulo">Valores</div>
        <p>{{ is_array($plan->valores) ? implode(', ', $plan->valores) : $plan->valores }}</p>
    </div>
        <div class="seccion">
        <div class="titulo">Unidades Estratégicas de Negocio (UEN)</div>
        @if(isset($uens) && count($uens))
            <ul>
                @foreach($uens as $uen)
                    <li>{{ $uen->descripcion }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No se han definido unidades estratégicas.</p>
        @endif
    </div>

    <div class="seccion">
        <div class="titulo">Objetivos Estratégicos</div>
        <ul>
        @foreach($objetivos as $obj)
            <li><strong>{{ $obj->descripcion }}</strong>
                @if($obj->especificos->isNotEmpty())
                <ul>
                    @foreach($obj->especificos as $esp)
                        <li>{{ $esp->descripcion }}</li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
        </ul>
    </div>

    <div class="seccion">
        <div class="titulo">Análisis FODA</div>
        <p><strong>Fortalezas:</strong> {{ implode('; ', $foda['fortaleza']) }}</p>
        <p><strong>Debilidades:</strong> {{ implode('; ', $foda['debilidad']) }}</p>
        <p><strong>Oportunidades:</strong> {{ implode('; ', $foda['oportunidad']) }}</p>
        <p><strong>Amenazas:</strong> {{ implode('; ', $foda['amenaza']) }}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Identificación Estratégica</div>
        @php
            $parrafos = explode("\n", $resumen->identificacion_estrategica);
        @endphp
        @foreach($parrafos as $p)
            @if(trim($p) !== '')
                <p>{{ trim($p) }}</p>
            @endif
        @endforeach
    </div>

    <div class="seccion">
        <div class="titulo">Acciones Competitivas</div>
        @php
            $tipos = ['C' => 'Corregir', 'A' => 'Afrontar', 'M' => 'Mantener', 'E' => 'Explotar'];
        @endphp
        @foreach($tipos as $tipo => $nombre)
            <p class="espaciado"><strong>{{ $nombre }}:</strong></p>
            <ul>
                @foreach($matrizCame->where('tipo', $tipo) as $accion)
                    <li>{{ $accion->accion }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>

    <div class="seccion">
        <div class="titulo">Conclusiones</div>
        @php
            $lineas = explode("\n", $resumen->conclusiones);
        @endphp
        @foreach($lineas as $linea)
            @if(trim($linea) !== '')
                <p>{{ trim($linea) }}</p>
            @endif
        @endforeach
    </div>

</body>
</html>
