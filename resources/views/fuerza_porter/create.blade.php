@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-5">Análisis 5 Fuerzas de Porter</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3 bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('fuerza_porter.store') }}" id="porterForm">
        @csrf

        <div class="overflow-x-auto shadow-xl sm:rounded-lg mb-5">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left w-1/4">Perfil Competitivo</th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Nada<br><small>1 punto</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Poco<br><small>2 puntos</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Medio<br><small>3 puntos</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Alto<br><small>4 puntos</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Muy Alto<br><small>5 puntos</small></th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 1. Rivalidad entre competidores -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="border border-gray-300 px-4 py-2 font-semibold bg-blue-100">1. Rivalidad empresas del sector</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Crecimiento (lento)</td>
                        <td class="border border-gray-300"><input type="radio" name="crecimiento" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="crecimiento" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="crecimiento" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="crecimiento" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="crecimiento" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_crecimiento">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Naturaleza de los competidores (muchos)</td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_naturaleza" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_naturaleza" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_naturaleza" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_naturaleza" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_naturaleza" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_rivalidad_naturaleza">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Exceso de capacidad productiva (Si)</td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_exceso" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_exceso" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_exceso" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_exceso" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_exceso" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_rivalidad_exceso">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Rentabilidad media del sector (Baja)</td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_rentabilidad" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_rentabilidad" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_rentabilidad" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_rentabilidad" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_rentabilidad" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_rivalidad_rentabilidad">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Diferenciacion del producto (Escasa)</td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_diferenciacion" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_diferenciacion" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_diferenciacion" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_diferenciacion" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_diferenciacion" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_rivalidad_diferenciacion">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Barreras de salida (Bajas)</td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_barreras" value="1" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_barreras" value="2" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_barreras" value="3" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_barreras" value="4" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="rivalidad_barreras" value="5" class="mx-auto rivalidad" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_rivalidad_barreras">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Rivalidad</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_rivalidad">0</span></td>
                    </tr>

                    <!-- 2. Poder de negociación de los clientes -->
                    <tr class="bg-gray-50">
                        <td colspan="7" class="border border-gray-300 px-4 py-2 font-semibold bg-blue-100">2. Barreras de Entrada</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Economias de escala (No)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_economias" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_economias" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_economias" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_economias" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_economias" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_economias">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Necesidad de capital (Bajas)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_capital" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_capital" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_capital" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_capital" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_capital" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_capital">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Acceso a la tecnologia (Fácil)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tecnologia" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tecnologia" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tecnologia" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tecnologia" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tecnologia" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_tecnologia">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Reglamentos o leyes limitativos (No)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reglamentos" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reglamentos" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reglamentos" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reglamentos" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reglamentos" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_reglamentos">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Tramites burocraticos (No)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tramites" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tramites" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tramites" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tramites" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_tramites" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_tramites">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Reaccion esperada actuales competidores (Escasa)</td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reaccion" value="1" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reaccion" value="2" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reaccion" value="3" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reaccion" value="4" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="barreras_reaccion" value="5" class="mx-auto barreras" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_barreras_reaccion">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Barreras</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_barreras">0</span></td>
                    </tr>

                    <tr class="bg-gray-50">
                        <td colspan="7" class="border border-gray-300 px-4 py-2 font-semibold bg-blue-100">3. Poder de los Clientes</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Numero de clientes (Pocos)</td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_numero" value="1" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_numero" value="2" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_numero" value="3" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_numero" value="4" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_numero" value="5" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_clientes_numero">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Posibilidad de integracion ascendente (Pequeña)</td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_integracion" value="1" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_integracion" value="2" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_integracion" value="3" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_integracion" value="4" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_integracion" value="5" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_clientes_integracion">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Rentabilidad de los clientes (Baja)</td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_rentabilidad" value="1" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_rentabilidad" value="2" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_rentabilidad" value="3" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_rentabilidad" value="4" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_rentabilidad" value="5" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_clientes_rentabilidad">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Coste de cambio de proveedor para cliente (Bajo)</td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_coste" value="1" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_coste" value="2" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_coste" value="3" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_coste" value="4" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="clientes_coste" value="5" class="mx-auto clientes" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_clientes_coste">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Clientes</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_clientes">0</span></td>
                    </tr>

                    <tr class="bg-gray-50">
                        <td colspan="7" class="border border-gray-300 px-4 py-2 font-semibold bg-blue-100">4. Productos sustitutivos</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Disponibilidad de productos sustitutos (Grande)</td>
                        <td class="border border-gray-300"><input type="radio" name="sustitutos_disponibilidad" value="1" class="mx-auto sustitutos" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="sustitutos_disponibilidad" value="2" class="mx-auto sustitutos" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="sustitutos_disponibilidad" value="3" class="mx-auto sustitutos" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="sustitutos_disponibilidad" value="4" class="mx-auto sustitutos" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="sustitutos_disponibilidad" value="5" class="mx-auto sustitutos" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_sustitutos_disponibilidad">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Sustitutos</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_sustitutos">0</span></td>
                    </tr>

                    <!-- Total General -->
                    <tr class="bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 font-semibold text-lg">TOTAL GENERAL</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold text-lg"><span id="total_general">0</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Secciones adicionales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="oportunidades" class="block text-lg font-semibold mb-2">Oportunidades</label>
                <div id="oportunidades-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="oportunidades[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Oportunidad 1" />
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('oportunidades')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Oportunidad</button>
            </div>

            <div>
                <label for="amenazas" class="block text-lg font-semibold mb-2">Amenazas</label>
                <div id="amenazas-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="amenazas[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Amenaza 1" />
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('amenazas')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Amenaza</button>
            </div>
        </div>

        <div class="mb-6">
            <label for="conclusion" class="block text-lg font-semibold mb-2">Conclusión</label>
            <textarea class="w-full p-3 border border-gray-300 rounded" id="conclusion" name="conclusion" rows="4"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
            Guardar análisis
        </button>
    </form>
</div>

<script>
function calcularPuntaje() {
    // Actualizar puntajes individuales
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        const name = input.name;
        const value = input.value;
        document.getElementById(`puntaje_${name}`).textContent = value;
    });

    // Calcular subtotales por fuerza
    const calcularSubtotal = (clase) => {
        let subtotal = 0;
        document.querySelectorAll(`input.${clase}:checked`).forEach(input => {
            subtotal += parseInt(input.value);
        });
        return subtotal;
    };

    // Rivalidad
    const subtotalRivalidad = calcularSubtotal('rivalidad');
    document.getElementById('subtotal_rivalidad').textContent = subtotalRivalidad;

    // Barreras
    const subtotalBarreras = calcularSubtotal('barreras');
    document.getElementById('subtotal_barreras').textContent = subtotalBarreras;

    // Clientes
    const subtotalClientes = calcularSubtotal('clientes');
    document.getElementById('subtotal_clientes').textContent = subtotalClientes;

    // Sustitutos
    const subtotalSustitutos = calcularSubtotal('sustitutos');
    document.getElementById('subtotal_sustitutos').textContent = subtotalSustitutos;

    // Calcular total general
    const totalGeneral = subtotalRivalidad + subtotalBarreras + subtotalClientes + subtotalSustitutos;
    document.getElementById('total_general').textContent = totalGeneral;

    // Generar conclusión automática basada en el puntaje total
    generarConclusion(totalGeneral);
}

function generarConclusion(puntajeTotal) {
    let conclusion = "";
    
    if (puntajeTotal < 30) {
        conclusion = "Estamos en un mercado altamente competitivo, en el que es muy difícil hacerse un hueco en el mercado.";
    } else if (puntajeTotal < 45) {
        conclusion = "Estamos en un mercado de competitividad relativamente alta, pero con ciertas modificaciones en el producto y la política comercial de la empresa, podría encontrarse un nicho de mercado.";
    } else if (puntajeTotal < 60) {
        conclusion = "La situación actual del mercado es favorable a la empresa.";
    } else {
        conclusion = "Estamos en una situación excelente para la empresa.";
    }
    
    document.getElementById('conclusion').value = conclusion;
}

function addItem(type) {
    const container = document.getElementById(`${type}-container`);
    const index = container.children.length + 1;
    const newItem = document.createElement('div');
    newItem.classList.add('flex', 'gap-3', 'mb-2');
    newItem.innerHTML = `
        <input type="text" name="${type}[]" class="w-full p-3 border border-gray-300 rounded" placeholder="${type.slice(0, -1)} ${index}" />
        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
    `;
    container.appendChild(newItem);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>
@endsection