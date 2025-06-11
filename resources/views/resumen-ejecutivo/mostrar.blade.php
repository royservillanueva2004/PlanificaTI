@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <div class="card-body">
            <h2 class="text-center text-primary mb-4">
                <i class="bi bi-clipboard2-check-fill"></i> Resumen Ejecutivo del Plan Estratégico
            </h2>

            <p><strong><i class="bi bi-building"></i> Nombre del proyecto:</strong> {{ $plan->nombre_plan }}</p>
            <p><strong><i class="bi bi-calendar-event"></i> Fecha de elaboración:</strong> {{ $plan->created_at->format('d/m/Y') }}</p>
            <p><strong><i class="bi bi-person-badge"></i> Emprendedores / Promotores:</strong> {{ $resumen->promotores }}</p>
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
                @php $valores = json_decode($plan->valores, true) ?? []; @endphp
                @forelse($valores as $valor)
                    <span class="badge bg-primary fs-6">{{ $valor }}</span>
                @empty
                    <p>No se han registrado valores.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-success text-white fw-bold">OBJETIVOS ESTRATÉGICOS</div>
        <div class="card-body">
            @forelse($objetivos as $general => $items)
                <div class="mb-3">
                    <h6 class="text-success"><i class="bi bi-flag-fill"></i> {{ $general }}</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($items as $item)
                            <li class="list-group-item">{{ $item->objetivo_especifico }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p>No se han registrado objetivos aún.</p>
            @endforelse
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-dark text-white fw-bold">ANÁLISIS FODA</div>
        <div class="card-body row g-4">
            <div class="col-md-6">
                <h6 class="text-success">Fortalezas</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['fortaleza'] ?? [] as $item)
                        <li class="list-group-item">{{ $item->descripcion }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-primary">Oportunidades</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['oportunidad'] ?? [] as $item)
                        <li class="list-group-item">{{ $item->descripcion }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-danger">Debilidades</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['debilidad'] ?? [] as $item)
                        <li class="list-group-item">{{ $item->descripcion }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="text-warning">Amenazas</h6>
                <ul class="list-group list-group-flush">
                    @foreach($foda['amenaza'] ?? [] as $item)
                        <li class="list-group-item">{{ $item->descripcion }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('resumen-ejecutivo.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
            <i class="bi bi-pencil-square"></i> Editar Promotores
        </a>
    </div>
</div>
@endsection
