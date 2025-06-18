<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalisisFoda;
use App\Models\MatrizEstrategica;

class IdentificacionEstrategicaController extends Controller
{
    public function index()
    {
        return view('identificacion_estrategica.index');
    }

    public function fortalezasOportunidades()
    {
        $planId = session('plan_id');

        $foda = AnalisisFoda::where('plan_id', $planId)->first();
        $matriz = MatrizEstrategica::where('plan_id', $planId)->first();

        return view('identificacion_estrategica.fortalezas_oportunidades', [
            'fortalezas' => $foda->fortalezas ?? [],
            'oportunidades' => $foda->oportunidades ?? [],
            'valores_guardados' => $matriz->fo ?? []
        ]);
    }

    public function guardarFO(Request $request)
    {
        $planId = session('plan_id');
        $fo = $request->input('fo'); // fo[i][j] => valor

        MatrizEstrategica::updateOrCreate(
            ['plan_id' => $planId],
            ['fo' => $fo]
        );

        return redirect()->route('identificacion.fortalezas_amenazas');
    }

    public function fortalezasAmenazas()
    {
        $planId = session('plan_id');

        $foda = AnalisisFoda::where('plan_id', $planId)->first();
        $matriz = MatrizEstrategica::where('plan_id', $planId)->first();

        return view('identificacion_estrategica.fortalezas_amenazas', [
            'fortalezas' => $foda->fortalezas ?? [],
            'amenazas' => $foda->amenazas ?? [],
            'valores_guardados' => $matriz->fa ?? []
        ]);
    }

    public function guardarFA(Request $request)
    {
        $planId = session('plan_id');

        $matriz = MatrizEstrategica::firstOrNew(['plan_id' => $planId]);
        $matriz->fa = $request->input('fa');
        $matriz->save();

        return redirect()->route('identificacion.debilidades_oportunidades');
    }

    public function debilidadesOportunidades()
    {
        $planId = session('plan_id');

        $foda = AnalisisFoda::where('plan_id', $planId)->first();
        $matriz = MatrizEstrategica::where('plan_id', $planId)->first();

        return view('identificacion_estrategica.debilidades_oportunidades', [
            'debilidades' => $foda->debilidades ?? [],
            'oportunidades' => $foda->oportunidades ?? [],
            'valores_guardados' => $matriz->do ?? []
        ]);
    }

    public function guardarDO(Request $request)
    {
        $planId = session('plan_id');

        $matriz = MatrizEstrategica::firstOrNew(['plan_id' => $planId]);
        $matriz->do = $request->input('do');
        $matriz->save();

        return redirect()->route('identificacion.debilidades_amenazas');
    }


    public function debilidadesAmenazas()
    {
        $planId = session('plan_id');

        $foda = AnalisisFoda::where('plan_id', $planId)->first();
        $matriz = MatrizEstrategica::where('plan_id', $planId)->first();

        return view('identificacion_estrategica.debilidades_amenazas', [
            'debilidades' => $foda->debilidades ?? [],
            'amenazas' => $foda->amenazas ?? [],
            'valores_guardados' => $matriz->da ?? []
        ]);
    }

    public function guardarDA(Request $request)
    {
        $planId = session('plan_id');

        $matriz = MatrizEstrategica::firstOrNew(['plan_id' => $planId]);
        $matriz->da = $request->input('da');
        $matriz->save();

        return redirect()->route('identificacion.resultados');
    }

    public function verResultados()
    {
        $planId = session('plan_id');

        $matriz = MatrizEstrategica::where('plan_id', $planId)->first();

        $sumar = function ($matriz) {
            return collect($matriz)->flatten()->sum();
        };

        $fo = $sumar($matriz->fo ?? []);
        $fa = $sumar($matriz->fa ?? []);
        $do = $sumar($matriz->do ?? []);
        $da = $sumar($matriz->da ?? []);

        $estrategias = [
            'FO' => ['tipo' => 'Estrategia Ofensiva', 'puntaje' => $fo, 'descripcion' => 'Deberá adoptar estrategias de crecimiento.'],
            'FA' => ['tipo' => 'Estrategia Defensiva', 'puntaje' => $fa, 'descripcion' => 'La empresa está preparada para enfrentarse a las amenazas.'],
            'DO' => ['tipo' => 'Estrategia de Reorientación', 'puntaje' => $do, 'descripcion' => 'La empresa no puede aprovechar las oportunidades porque carece de preparación adecuada.'],
            'DA' => ['tipo' => 'Estrategia de Supervivencia', 'puntaje' => $da, 'descripcion' => 'Se enfrenta a amenazas externas sin las fortalezas necesarias para competir.'],
        ];

        // Determinar la estrategia dominante
        $maxClave = collect($estrategias)->sortByDesc('puntaje')->keys()->first();
        $estrategiaDominante = $estrategias[$maxClave];

        return view('identificacion_estrategica.resultados', compact('estrategias', 'estrategiaDominante'));
    }

}
