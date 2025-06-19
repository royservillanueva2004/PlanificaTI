<?php

namespace App\Http\Controllers;

use App\Models\MatrizBCG;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MatrizBCGController extends Controller
{
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Debe seleccionar un plan estratégico.');
        }

        $matriz = MatrizBCG::where('plan_id', $planId)->first();

        // Si hay datos, calcula los valores reales
        if ($matriz) {
            $productos = count($matriz->productos ?? []);
            $anios = count($matriz->tcm ?? []);
            $anioInicio = 2020;
            $anioFin = $anioInicio + $anios - 1;
            $competidores = count($matriz->competidores ?? []);
        } else {
            // Valores por defecto para el formulario inicial
            $productos = 5;
            $anioInicio = 2020;
            $anioFin = 2024;
            $competidores = 5;
        }

        return view('matriz-bcg.index', compact('matriz', 'productos', 'anioInicio', 'anioFin', 'competidores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'productos' => 'required|array|min:1',
            'ventas' => 'required|array|min:1',
            'tcm' => 'required|array',
            'demanda_global' => 'required|array',
            'competidores' => 'required|array',
        ]);

        MatrizBCG::updateOrCreate(
            ['plan_id' => $request->plan_id],
            [
                'productos' => array_values($request->productos),
                'ventas' => array_map('floatval', $request->ventas),
                'tcm' => $request->tcm,
                'demanda_global' => $request->demanda_global,
                'competidores' => $request->competidores,
            ]
        );

        return redirect()->route('matriz-bcg.resultado')->with('success', 'Datos guardados y visualización generada.');
    }

    public function resultado()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Debe seleccionar un plan estratégico.');
        }

        $matriz = MatrizBCG::where('plan_id', $planId)->first();

        if (!$matriz) {
            return redirect()->route('matriz-bcg.index')->with('error', 'Primero debe completar y guardar la matriz BCG.');
        }

        return view('matriz-bcg.resultado', compact('matriz'));
    }


    
}
