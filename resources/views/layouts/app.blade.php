<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            <main class="flex min-h-screen bg-gray-100 text-gray-800">

                {{-- Sidebar --}}
                <aside class="w-64 bg-white shadow-md">
                    <nav class="p-4 space-y-2">
                        <a href="/dashboard" class="block px-4 py-2 hover:bg-blue-100">🏠 Dashboard</a>

                        {{-- Información de la Empresa --}}
                        <a href="/planes" class="block px-4 py-2 hover:bg-blue-100">📄 Plan Estratégico</a> {{-- contiene misión, visión, valores --}}
                        <a href="/objetivos" class="block px-4 py-2 hover:bg-blue-100">🎯 Objetivos</a>

                        {{-- Análisis estratégico --}}
                        <a href="/foda" class="block px-4 py-2 hover:bg-blue-100">📊 FODA</a>
                        <a href="/cadena-valor" class="block px-4 py-2 hover:bg-blue-100">🔗 Cadena de Valor</a>
                        <a href="/matriz-participacion" class="block px-4 py-2 hover:bg-blue-100">📈 Matriz de Participación</a>
                        <a href="/porter" class="block px-4 py-2 hover:bg-blue-100">🧠 5 Fuerzas de Porter</a>
                        <a href="/pest" class="block px-4 py-2 hover:bg-blue-100">🌐 Análisis PEST</a>
                        <a href="/estrategia" class="block px-4 py-2 hover:bg-blue-100">🎯 Identificación de Estrategia</a>
                        <a href="/came" class="block px-4 py-2 hover:bg-blue-100">🧩 Matriz CAME</a>

                        {{-- Resumen final --}}
                        <a href="/resumen-ejecutivo" class="block px-4 py-2 hover:bg-blue-100">📋 Resumen Ejecutivo</a>
                    </nav>
                </aside>

                {{-- Contenido principal --}}
                <div class="flex-1 p-6">
                    @yield('content')
                </div>

            </main>
        </div>
    </body>
</html>
