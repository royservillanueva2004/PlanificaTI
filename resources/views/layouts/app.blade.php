<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>PlanificaTI - Sistema de Plan Estratégico</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main x-data="{ openFoda: false, openInterno: false, openExterno: false }" class="flex min-h-screen bg-gray-100 text-gray-800">

                {{-- Sidebar --}}
                <aside class="w-64 bg-white shadow-md">
                    

                    <nav class="p-4 space-y-2 text-sm">
                        <a href="/planes" class="block px-4 py-2 hover:bg-blue-100">📄 Plan Estratégico</a>

                        @if(session('plan_id'))
                            <a href="/objetivos" class="block px-4 py-2 hover:bg-blue-100">🎯 Objetivos</a>

                            {{-- FODA --}}
                            <button @click="openFoda = !openFoda" class="w-full text-left px-4 py-2 hover:bg-blue-100 font-semibold">
                                📊 FODA
                            </button>

                            <div x-show="openFoda" class="pl-4 space-y-1">
                                {{-- Análisis Interno --}}
                                <button @click="openInterno = !openInterno" class="w-full text-left px-4 py-1 hover:bg-blue-100">
                                    🔍 Análisis Interno
                                </button>
                                <div x-show="openInterno" class="pl-4">
                                    <a href="/cadena-valor" class="block px-4 py-1 hover:bg-blue-100">🔗 Cadena de Valor</a>
                                    <a href="/matriz-bcg" class="block px-4 py-1 hover:bg-blue-100">📈 Matriz Participación</a>
                                </div>

                                {{-- Análisis Externo --}}
                                <button @click="openExterno = !openExterno" class="w-full text-left px-4 py-1 hover:bg-blue-100">
                                    🌐 Análisis Externo
                                </button>
                                <div x-show="openExterno" class="pl-4">
                                    <a href="{{ route('fuerza_porter.redirigir') }}" class="block px-4 py-1 hover:bg-blue-100">🧠 5 Fuerzas de Porter</a>
                                    <a href="/pest" class="block px-4 py-1 hover:bg-blue-100">🌍 PEST</a>
                                </div>
                            </div>

                            <a href="/estrategia" class="block px-4 py-2 hover:bg-blue-100">🎯 Identificación Estratégica</a>
                            <a href="/matrizcame" class="block px-4 py-2 hover:bg-blue-100">🧩 Matriz CAME</a>
                            <a href="/resumen-ejecutivo" class="block px-4 py-2 hover:bg-blue-100">📋 Resumen del Plan Ejecutivo</a>
                        @else
                            {{-- Desactivados --}}
                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🎯 Objetivos (Seleccione un plan)</span>
                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">📊 FODA</span>
                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🎯 Identificación Estratégica</span>
                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🧩 Matriz CAME</span>
                            <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">📋 Resumen del Plan Ejecutivo</span>
                        @endif
                    </nav>
                </aside>

                {{-- Contenido principal --}}
                <div class="flex-1 p-6">
                    @yield('content')
                </div>

            </main>
        </div>
        @yield('scripts')
    </body>
</html>
