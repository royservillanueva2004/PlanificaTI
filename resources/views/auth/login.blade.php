<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - PlanificaTI</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie para animaciones -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">

<div class="min-h-screen flex flex-col lg:flex-row">
    <!-- Sección izquierda - Formulario de Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-gray-900">
        <div class="w-full max-w-md space-y-8">
            <!-- Logo y Título -->
            <div class="text-center">
                <div id="lottie-login" class="w-40 h-40 mx-auto"></div>
                <h1 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Inicia sesión en PlanificaTI
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Accede a tu cuenta para gestionar tus proyectos
                </p>
            </div>

            <!-- Mensajes de estado -->
            <div id="session-status" class="p-4 mb-4 text-sm rounded-lg hidden">
                <!-- Mensajes dinámicos aparecerán aquí -->
            </div>

            <!-- Formulario -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                
                <!-- Campo Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            placeholder="ejemplo@email.com"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white input-focus"
                        >
                    </div>
                    <div id="email-error" class="text-red-600 text-sm mt-1 hidden">
                        <!-- Mensajes de error aparecerán aquí -->
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white input-focus"
                        >
                    </div>
                    <div id="password-error" class="text-red-600 text-sm mt-1 hidden">
                        <!-- Mensajes de error aparecerán aquí -->
                    </div>
                </div>

                <!-- Opciones adicionales -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Recordar sesión
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <!-- Botón de Login -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors duration-200"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-indigo-300 group-hover:text-indigo-200"></i>
                        </span>
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <!-- Enlace a Registro -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Regístrate ahora
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Sección derecha - Banner con animación -->
    <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center p-12">
        <div class="text-white text-center max-w-2xl">
            <h2 class="text-4xl font-bold mb-6">Bienvenido a PlanificaTI</h2>
            <p class="text-xl opacity-90 mb-10 leading-relaxed">
                Soluciones tecnológicas para optimizar tus procesos empresariales y llevar tu negocio al siguiente nivel.
            </p>
            <div class="flex justify-center">
                <div id="lottie-secondary" class="w-80 h-80"></div>
            </div>
            <div class="mt-8 flex justify-center space-x-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-300 mr-2 text-xl"></i>
                    <span>Gestión eficiente</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-300 mr-2 text-xl"></i>
                    <span>Seguridad garantizada</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para animaciones Lottie -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para el formulario
        lottie.loadAnimation({
            container: document.getElementById('lottie-login'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets5.lottiefiles.com/packages/lf20_5tkzkblw.json' // URL de animación de login
        });

        // Animación para el banner
        lottie.loadAnimation({
            container: document.getElementById('lottie-secondary'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets5.lottiefiles.com/packages/lf20_gn0tojcq.json' // URL de animación de negocios
        });

        // Simulación de mensajes de error (en un entorno real, esto sería manejado por el backend)
        @if($errors->any())
            const statusDiv = document.getElementById('session-status');
            statusDiv.classList.remove('hidden');
            statusDiv.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900', 'dark:text-red-100');
            statusDiv.textContent = '{{ $errors->first() }}';
            
            @error('email')
                const emailError = document.getElementById('email-error');
                emailError.classList.remove('hidden');
                emailError.textContent = '{{ $message }}';
            @enderror
            
            @error('password')
                const passwordError = document.getElementById('password-error');
                passwordError.classList.remove('hidden');
                passwordError.textContent = '{{ $message }}';
            @enderror
        @endif

        @if(session('status'))
            const statusDiv = document.getElementById('session-status');
            statusDiv.classList.remove('hidden');
            statusDiv.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900', 'dark:text-green-100');
            statusDiv.textContent = '{{ session('status') }}';
        @endif
    });
</script>

</body>
</html>