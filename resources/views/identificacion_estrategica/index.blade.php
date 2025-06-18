@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">🧩 Identificación Estratégica</h1>

    <p class="text-gray-700 leading-relaxed mb-6">
        Tras el análisis realizado habiéndose identificado las <strong>oportunidades, amenazas, fortalezas y debilidades</strong>,
        es momento de identificar la estrategia que debe seguir su empresa para el logro de sus objetivos empresariales.
    </p>

    <p class="text-gray-700 leading-relaxed mb-6">
        Se trata de realizar una <strong>Matriz Cruzada</strong> como la que se muestra a continuación, para identificar
        la estrategia más conveniente a llevar a cabo.
    </p>

    {{-- Imagen o tabla visual estilo guía --}}
    <div class="border rounded-lg overflow-hidden shadow mb-8">
        <div class="grid grid-cols-3 text-center text-sm font-semibold">
            <div class="bg-gray-100 p-3"></div>
            <div class="bg-orange-100 p-3">OPORTUNIDADES</div>
            <div class="bg-blue-100 p-3">AMENAZAS</div>

            <div class="bg-green-100 p-3">FORTALEZAS</div>
            <div class="bg-purple-100 p-3">ESTRATEGIAS OFENSIVAS</div>
            <div class="bg-purple-100 p-3">ESTRATEGIAS DEFENSIVAS</div>

            <div class="bg-yellow-100 p-3">DEBILIDADES</div>
            <div class="bg-purple-100 p-3">ESTRATEGIAS DE REORIENTACIÓN</div>
            <div class="bg-purple-100 p-3">ESTRATEGIAS DE SUPERVIVENCIA</div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('identificacion.fortalezas_oportunidades') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
            👉 Continuar
        </a>
    </div>
</div>
@endsection
