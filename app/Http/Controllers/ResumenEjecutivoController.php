<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanEstrategico;
use App\Models\ResumenEjecutivo;
use App\Models\Objetivo;
use App\Models\AnalisisFoda;
use Illuminate\Support\Facades\Session;

class ResumenEjecutivoController extends Controller
{
    public function index()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::firstOrNew(['plan_id' => $plan_id]);

        return view('resumen-ejecutivo.index', compact('plan', 'resumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotores' => 'required|string|max:255',
        ]);

        $plan_id = session('plan_id');

        ResumenEjecutivo::updateOrCreate(
            ['plan_id' => $plan_id],
            ['promotores' => $request->promotores]
        );

        return redirect()->route('resumen-ejecutivo.mostrar')->with('success', 'Resumen guardado.');
    }

    public function mostrar()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::where('plan_id', $plan_id)->first();
        $objetivos = Objetivo::where('plan_id', $plan_id)->get()->groupBy('objetivo_general');
        $foda = AnalisisFoda::where('plan_id', $plan_id)->get()->groupBy('tipo');

        return view('resumen-ejecutivo.mostrar', compact('plan', 'resumen', 'objetivos', 'foda'));
    }
}
