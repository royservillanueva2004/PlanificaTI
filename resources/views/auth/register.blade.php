<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PlanificaTI</title>
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
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">

<div class="min-h-screen flex flex-col lg:flex-row">
    <!-- Sección izquierda - Formulario de Registro -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-gray-900">
        <div class="w-full max-w-md space-y-8">
            <!-- Logo y Título -->
            <div class="text-center">
                <div id="lottie-register" class="w-40 h-40 mx-auto"></div>
                <h1 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Únete a PlanificaTI
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Crea tu cuenta y comienza a optimizar tus procesos
                </p>
            </div>

            <!-- Mensajes de estado -->
            <div id="session-status" class="p-4 mb-4 text-sm rounded-lg hidden">
                <!-- Mensajes dinámicos aparecerán aquí -->
            </div>

            <!-- Formulario de Registro -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Campo Nombre -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nombre completo
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            value="{{ old('name') }}"
                            placeholder="Tu nombre completo"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white input-focus"
                        >
                    </div>
                    <div id="name-error" class="text-red-600 text-sm mt-1 hidden">
                        @error('name') {{ $message }} @enderror
                    </div>
                </div>

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
                        @error('email') {{ $message }} @enderror
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
                            autocomplete="new-password"
                            required
                            placeholder="Mínimo 8 caracteres"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white input-focus"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div id="password-error" class="text-red-600 text-sm mt-1 hidden">
                        @error('password') {{ $message }} @enderror
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <p id="password-strength" class="hidden"></p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li id="length" class="text-gray-400">8 caracteres mínimo</li>
                            <li id="uppercase" class="text-gray-400">1 letra mayúscula</li>
                            <li id="number" class="text-gray-400">1 número</li>
                        </ul>
                    </div>
                </div>

                <!-- Campo Confirmar Contraseña -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirmar contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            placeholder="Repite tu contraseña"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white input-focus"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="toggle-confirm-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div id="password-confirm-error" class="text-red-600 text-sm mt-1 hidden">
                        @error('password_confirmation') {{ $message }} @enderror
                    </div>
                </div>

                <!-- Términos y Condiciones -->
                <div class="flex items-center">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700"
                        required
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        Acepto los <a href="#" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Términos y Condiciones</a>
                    </label>
                </div>

                <!-- Botón de Registro -->
                <div>
                    <button
                        type="submit"
                        id="register-button"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors duration-200"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-indigo-300 group-hover:text-indigo-200"></i>
                        </span>
                        Crear cuenta
                    </button>
                </div>
            </form>

            <!-- Enlace a Login -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Inicia sesión
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
                Únete a nuestra plataforma y descubre cómo podemos transformar la gestión de tu negocio.
            </p>
            <div class="flex justify-center">
                <div id="lottie-secondary" class="w-80 h-80"></div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-4 text-left max-w-md mx-auto">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-300 mr-2 mt-1"></i>
                    <span>Gestión de proyectos integrada</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-300 mr-2 mt-1"></i>
                    <span>Reportes automáticos</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-300 mr-2 mt-1"></i>
                    <span>Equipo colaborativo</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-300 mr-2 mt-1"></i>
                    <span>Soporte 24/7</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para animaciones Lottie y validaciones -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para el formulario (animación de registro proporcionada)
        lottie.loadAnimation({
            container: document.getElementById('lottie-register'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://lottie.host/5d5c3c3e-3e3e-4c3a-b3b2-4b3b3b3b3b3b/UIk0fSXz6v.json' // URL de animación de registro
        });

        // Animación para el banner
        lottie.loadAnimation({
            container: document.getElementById('lottie-secondary'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets5.lottiefiles.com/packages/lf20_gn0tojcq.json' // URL de animación de negocios
        });

        // Mostrar/ocultar contraseña
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Mostrar/ocultar confirmación de contraseña
        document.getElementById('toggle-confirm-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Validación de contraseña en tiempo real
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthText = document.getElementById('password-strength');
            const lengthCheck = document.getElementById('length');
            const uppercaseCheck = document.getElementById('uppercase');
            const numberCheck = document.getElementById('number');

            // Validar longitud
            if (password.length >= 8) {
                lengthCheck.classList.remove('text-gray-400');
                lengthCheck.classList.add('text-green-500');
            } else {
                lengthCheck.classList.remove('text-green-500');
                lengthCheck.classList.add('text-gray-400');
            }

            // Validar mayúsculas
            if (/[A-Z]/.test(password)) {
                uppercaseCheck.classList.remove('text-gray-400');
                uppercaseCheck.classList.add('text-green-500');
            } else {
                uppercaseCheck.classList.remove('text-green-500');
                uppercaseCheck.classList.add('text-gray-400');
            }

            // Validar números
            if (/\d/.test(password)) {
                numberCheck.classList.remove('text-gray-400');
                numberCheck.classList.add('text-green-500');
            } else {
                numberCheck.classList.remove('text-green-500');
                numberCheck.classList.add('text-gray-400');
            }

            // Mostrar fortaleza de la contraseña
            if (password.length > 0) {
                strengthText.classList.remove('hidden');
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                
                const strengthMessages = ['Débil', 'Moderada', 'Fuerte'];
                const strengthColors = ['text-red-500', 'text-yellow-500', 'text-green-500'];
                
                strengthText.textContent = `Fortaleza: ${strengthMessages[strength-1] || ''}`;
                strengthText.className = strengthColors[strength-1] || '';
            } else {
                strengthText.classList.add('hidden');
            }
        });

        // Mostrar errores del servidor
        @if($errors->any())
            const statusDiv = document.getElementById('session-status');
            statusDiv.classList.remove('hidden');
            statusDiv.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900', 'dark:text-red-100');
            statusDiv.textContent = 'Por favor corrige los errores en el formulario.';
            
            @error('name')
                const nameError = document.getElementById('name-error');
                nameError.classList.remove('hidden');
                document.getElementById('name').classList.add('shake', 'border-red-500');
            @enderror
            
            @error('email')
                const emailError = document.getElementById('email-error');
                emailError.classList.remove('hidden');
                document.getElementById('email').classList.add('shake', 'border-red-500');
            @enderror
            
            @error('password')
                const passwordError = document.getElementById('password-error');
                passwordError.classList.remove('hidden');
                document.getElementById('password').classList.add('shake', 'border-red-500');
            @enderror
            
            @error('password_confirmation')
                const passwordConfirmError = document.getElementById('password-confirm-error');
                passwordConfirmError.classList.remove('hidden');
                document.getElementById('password_confirmation').classList.add('shake', 'border-red-500');
            @enderror

            // Eliminar animación de shake después de que termine
            setTimeout(() => {
                document.querySelectorAll('.shake').forEach(el => {
                    el.classList.remove('shake');
                });
            }, 500);
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