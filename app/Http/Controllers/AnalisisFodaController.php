<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalisisFoda;

class AnalisisFodaController extends Controller
{
    public function guardar(Request $request)
    {
        $planId = session('plan_id');

        $request->validate([
            'fortalezas' => 'nullable|array',
            'fortalezas.*' => 'nullable|string|max:255',
            'debilidades' => 'nullable|array',
            'debilidades.*' => 'nullable|string|max:255',
        ]);

        // Limpia valores vacíos
        $fortalezas = array_filter($request->fortalezas ?? [], fn($v) => trim($v) !== '');
        $debilidades = array_filter($request->debilidades ?? [], fn($v) => trim($v) !== '');

        \App\Models\AnalisisFoda::updateOrCreate(
            ['plan_id' => $planId],
            [
                'fortalezas' => array_values($fortalezas),
                'debilidades' => array_values($debilidades),
            ]
        );

        return response()->json(['success' => true]);
    }
}