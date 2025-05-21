<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PlanificaTI - Sistema de Plan Estratégico</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Tailwind CSS inline */
                /*! tailwindcss v3.3.3 | MIT License | https://tailwindcss.com */
                @layer base, components, utilities;
                /* ... (mantener el CSS de Tailwind existente) ... */
                
                /* Personalizaciones específicas para PlanificaTI */
                .bg-planif-gradient {
                    background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
                }
                .text-planif-primary {
                    color: #3949ab;
                }
                .dark .text-planif-primary {
                    color: #7986cb;
                }
                .border-planif {
                    border-color: #3949ab;
                }
                .hover\:bg-planif-primary:hover {
                    background-color: #3949ab;
                }
                .dark .hover\:bg-planif-primary:hover {
                    background-color: #5c6bc0;
                }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#121212] text-[#1a237e] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <!-- Logo animado en el header - versión pequeña -->
                        <img src="https://cdn.pixabay.com/animation/2022/09/28/05/18/05-18-33-400_512.gif" alt="PlanificaTI" class="h-10 w-10 object-contain">
                        <span class="font-bold text-planif-primary hidden sm:block">PlanificaTI</span>
                    </div>
                    
                    <div class="flex items-center justify-end gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-white border-planif border text-planif-primary dark:border-gray-600 dark:hover:border-gray-400 rounded-sm text-sm leading-normal hover:bg-planif-primary hover:text-white transition-colors"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 dark:text-gray-300 text-planif-primary border border-transparent hover:border-planif dark:hover:border-gray-600 rounded-sm text-sm leading-normal"
                            >
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 dark:text-gray-300 text-planif-primary border border-transparent hover:border-planif dark:hover:border-gray-600 rounded-sm text-sm leading-normal">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-12 bg-white dark:bg-[#1e1e1e] dark:text-gray-200 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#333333] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <h1 class="mb-4 text-2xl font-bold text-planif-primary dark:text-blue-400">Transforma tu negocio con tecnología</h1>
                    <p class="mb-6 text-[#4a5568] dark:text-gray-400">PlanificaTI ofrece soluciones tecnológicas personalizadas para optimizar tus procesos empresariales y llevar tu negocio al siguiente nivel.</p>
                    <ul class="flex flex-col mb-6 lg:mb-8 gap-4">
                        <li class="flex items-start gap-4 py-2">
                            <span class="flex items-center justify-center rounded-full bg-white dark:bg-[#1e1e1e] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-5 h-5 border dark:border-gray-600 border-gray-200 mt-0.5">
                                <svg class="w-3 h-3 text-planif-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span>
                               <strong class="font-medium">Planes Estratégicos Personalizados</strong> - Diseñamos soluciones estratégicas adaptadas a los objetivos y necesidades específicas de tu organización.
                            </span>
                        </li>
                        <li class="flex items-start gap-4 py-2">
                            <span class="flex items-center justify-center rounded-full bg-white dark:bg-[#1e1e1e] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-5 h-5 border dark:border-gray-600 border-gray-200 mt-0.5">
                                <svg class="w-3 h-3 text-planif-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span>
                                <strong class="font-medium">Consultoría especializada</strong> - Te ayudamos a planificar tu estrategia tecnológica.
                            </span>
                        </li>
                        <li class="flex items-start gap-4 py-2">
                            <span class="flex items-center justify-center rounded-full bg-white dark:bg-[#1e1e1e] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-5 h-5 border dark:border-gray-600 border-gray-200 mt-0.5">
                                <svg class="w-3 h-3 text-planif-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span>
                                <strong class="font-medium">Soporte 24/7</strong> - Nuestro equipo está disponible para resolver cualquier incidencia.
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="bg-planif-gradient relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center">
                    <!-- Logo animado en la sección principal - versión grande -->
                    <img src="https://cdn.pixabay.com/animation/2022/09/28/05/18/05-18-33-400_512.gif" alt="PlanificaTI" class="w-48 h-48 object-contain transition-all translate-y-0 opacity-100 duration-750 starting:opacity-0 starting:translate-y-6">
                    
                    <div class="absolute inset-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg shadow-[inset_0px_0px_0px_1px_rgba(255,255,255,0.1)]"></div>
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>