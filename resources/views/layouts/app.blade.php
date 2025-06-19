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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .app-layout {
            display: flex;
            height: 100vh;
        }

        aside {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
            width: 16rem; /* 64 */
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            z-index: 50;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            max-height: 100vh;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    {{-- Header Sticky --}}
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main x-data="{ openFoda: false, openInterno: false, openExterno: false }" class="app-layout text-gray-800">
        {{-- Sidebar --}}
        <aside>
            <nav class="p-4 space-y-2 text-sm">
                <a href="/planes" class="block px-4 py-2 hover:bg-blue-100">📄 Plan Estratégico</a>

                @if(session('plan_id'))
                    
                    <a href="/objetivos" class="block px-4 py-2 hover:bg-blue-100">🎯 Objetivos</a>
                    <a href="/uen" class="block px-4 py-2 hover:bg-blue-100">🏢 Unidades Estratégicas - UEN</a>

                    {{-- FODA --}}
                    <button @click="openFoda = !openFoda" class="w-full text-left px-4 py-2 hover:bg-blue-100 font-semibold">
                        📊 FODA
                    </button>
                    <div x-show="openFoda" class="pl-4 space-y-1">
                        {{-- Análisis Interno --}}
                        <button @click="openInterno = !openInterno" class="w-full text-left px-4 py-1 hover:bg-blue-100">🔍 Análisis Interno</button>
                        <div x-show="openInterno" class="pl-4">
                            <a href="/cadena-valor" class="block px-4 py-1 hover:bg-blue-100">🔗 Cadena de Valor</a>
                            <a href="/matriz-bcg" class="block px-4 py-1 hover:bg-blue-100">📈 Matriz Participación</a>
                        </div>

                        {{-- Análisis Externo --}}
                        <button @click="openExterno = !openExterno" class="w-full text-left px-4 py-1 hover:bg-blue-100">🌐 Análisis Externo</button>
                        <div x-show="openExterno" class="pl-4">
                            <a href="{{ route('fuerza_porter.redirigir') }}" class="block px-4 py-1 hover:bg-blue-100">🧠 5 Fuerzas de Porter</a>
                            <a href="/pest" class="block px-4 py-1 hover:bg-blue-100">🌍 PEST</a>
                        </div>
                    </div>

                    <a href="{{ route('identificacion.index') }}" class="block px-4 py-2 hover:bg-blue-100">🎯 Identificación Estratégica</a>
                    <a href="/matrizcame" class="block px-4 py-2 hover:bg-blue-100">🧩 Matriz CAME</a>
                    <a href="/resumen-ejecutivo" class="block px-4 py-2 hover:bg-blue-100">📋 Resumen del Plan Ejecutivo</a>
                @else
                    {{-- Desactivados --}}
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🏢 Unidades Estratégicas - UEN</span>
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🎯 Objetivos</span>
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">📊 FODA</span>
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🎯 Identificación Estratégica</span>
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">🧩 Matriz CAME</span>
                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">📋 Resumen del Plan Ejecutivo</span>
                @endif
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="main-content p-6">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
