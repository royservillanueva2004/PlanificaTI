<nav class="bg-white border-b border-gray-100">
    <div class="flex justify-between h-16 items-center px-4 sm:px-6 lg:px-8">

        {{-- 🟦 Título completamente alineado a la izquierda --}}
        <a href="{{ route('planes.index') }}" class="flex items-center gap-2 text-blue-700 font-extrabold text-2xl tracking-tight hover:text-blue-900 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2a2 2 0 002 2h2a2 2 0 002-2v-5h-2a2 2 0 01-2-2V5H7v5a2 2 0 01-2 2H3v5a2 2 0 002 2h2a2 2 0 002-2z" />
    </svg>
    Planifica<span class="text-gray-900">TI</span>
</a>

        {{-- Mostrar nombre del plan estratégico seleccionado --}}
        @if(session('plan_id'))
            @php
                $planSeleccionado = \App\Models\PlanEstrategico::find(session('plan_id'));
            @endphp
            @if($planSeleccionado)
                <div class="text-lg font-semibold text-gray-700">
                    📘 Plan seleccionado: <span class="text-blue-600">{{ $planSeleccionado->nombre_plan }}</span>
                </div>
            @endif
        @endif

        {{-- 🟪 Menú usuario a la derecha --}}
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>