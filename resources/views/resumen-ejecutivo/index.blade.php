@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="mb-4 text-center fw-bold text-primary">
                <i class="bi bi-journal-text"></i> Resumen Ejecutivo - Datos Generales
            </h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('resumen-ejecutivo.store') }}" method="POST" class="px-3">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-building"></i> Nombre del proyecto:
                    </label>
                    <input type="text" class="form-control form-control-lg" value="{{ $plan->nombre_plan }}" disabled>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-event"></i> Fecha de elaboración:
                    </label>
                    <input type="text" class="form-control form-control-lg" value="{{ $plan->created_at->format('d/m/Y') }}" disabled>
                </div>

                <div class="mb-4">
                    <label for="promotores" class="form-label fw-semibold">
                        <i class="bi bi-people-fill"></i> Emprendedores / Promotores:
                    </label>
                    <input type="text" name="promotores" class="form-control form-control-lg" 
                           value="{{ old('promotores', $resumen->promotores) }}" required placeholder="Nombres completos...">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                        <i class="bi bi-check-circle-fill"></i> Guardar y ver resumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
