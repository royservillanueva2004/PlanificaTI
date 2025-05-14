<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 text-gray-800">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 font-bold text-xl border-b border-gray-200">
                PlanificaTI
            </div>
            <nav class="p-4 space-y-2">
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">🏠 Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">📄 Planes Estratégicos</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">📊 FODA</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">🧩 CAME</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">🔍 Porter</a>
            </nav>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col">
            {{-- Esta sección de header YA VIENE con <x-app-layout>, elimínala --}}
            {{-- Content area --}}
            <main class="p-6">
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-2xl font-bold mb-4">Bienvenido a PlanificaTI</h2>
                    <p class="text-gray-600">Desde aquí puedes gestionar tus planes estratégicos de TI.</p>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
