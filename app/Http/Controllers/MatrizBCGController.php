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

        return view('matriz-bcg.index', compact('matriz'));
    }

    public function store(Request $request)
    {
        $matriz = MatrizBCG::updateOrCreate(
            ['plan_id' => $request->plan_id],
            [
                'productos' => $request->productos,
                'ventas' => $request->ventas,
                'tcm' => $request->tcm,
                'demanda_global' => $request->demanda_global,
                'competidores' => $request->competidores
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

        return view('matriz-bcg.resultado', compact('matriz'));
    }


    
}
