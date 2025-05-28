<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalisisFoda;

class AnalisisFodaController extends Controller
{
    public function guardar(Request $request)
    {
        $planId = session('plan_id');

        $registro = AnalisisFoda::firstOrNew(['plan_id' => $planId]);

        // Mezclar las nuevas con las anteriores
        $registro->fortalezas = array_values(array_unique(array_filter(array_merge(
            $registro->fortalezas ?? [],
            $request->input('fortalezas', [])
        ))));

        $registro->debilidades = array_values(array_unique(array_filter(array_merge(
            $registro->debilidades ?? [],
            $request->input('debilidades', [])
        ))));

        $registro->save();

        return redirect()->route('planes.index')->with('success', 'Análisis FODA actualizado correctamente.');
    }
}