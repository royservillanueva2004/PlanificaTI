@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">📊 Matriz FO: Fortalezas vs Oportunidades</h1>

    <p class="text-gray-600 mb-4">
        Evalúe en qué medida cada fortaleza puede aprovechar una oportunidad.  
        <br>
        <strong>Escala:</strong> 
        <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs">0 = Total desacuerdo</span>,
        <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs">4 = Total acuerdo</span>.
    </p>

    <form method="POST" action="{{ route('identificacion.guardar.fo') }}">
        @csrf

        <div class="overflow-x-auto border rounded-lg shadow">
            <table class="w-full text-sm text-center border-collapse">
                <thead class="bg-blue-100 text-gray-900 uppercase text-xs font-semibold">
                    <tr>
                        <th class="bg-blue-50 px-4 py-2 text-center align-top w-[200px]">Fortalezas \ Oportunidades</th>
                        @foreach ($oportunidades as $j => $oportunidad)
                            <th class="bg-blue-50 px-4 py-2 text-center align-top min-w-[200px] max-w-[200px] w-[200px]">
                                <div class="text-xs font-bold text-gray-700">O{{ $j + 1 }}</div>
                                <div class="text-[11px] text-gray-600 leading-tight break-words">
                                    {{ $oportunidad }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fortalezas as $i => $fortaleza)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="bg-green-50 text-left px-4 py-3 font-medium min-w-[220px]">
                                F{{ $i + 1 }}. {{ $fortaleza }}
                            </td>
                            @foreach ($oportunidades as $j => $oportunidad)
                                <td class="px-4 py-2 w-[200px]">
                                    <select name="fo[{{ $i }}][{{ $j }}]"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-center focus:outline-none focus:ring focus:ring-blue-300">
                                        @for ($k = 0; $k <= 4; $k++)
                                            <option value="{{ $k }}"
                                                @if(isset($valores_guardados[$i][$j]) && $valores_guardados[$i][$j] == $k) selected @endif>
                                                {{ $k }}
                                            </option>
                                        @endfor
                                    </select>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                ➡️ Continuar con Fortalezas vs Amenazas
            </button>
        </div>
    </form>
</div>
@endsection
