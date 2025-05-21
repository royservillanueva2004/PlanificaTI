@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Autoevaluación de la Cadena de Valor</h1>

    <form action="{{ route('cadena-valor.store') }}" method="POST">
        @csrf

        @foreach($preguntas as $index => $pregunta)
            <div class="mb-3">
                <label class="form-label">{{ $index + 1 }}. {{ $pregunta }}</label><br>
                @for($i = 0; $i <= 4; $i++)
                    <label class="me-2">
                        <input type="radio" name="respuestas[{{ $index }}]" value="{{ $i }}" required> {{ $i }}
                    </label>
                @endfor
            </div>
        @endforeach

        <div class="mb-3">
            <label class="form-label">Reflexión</label>
            <textarea name="reflexion" class="form-control" rows="4"></textarea>
        </div>

        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
