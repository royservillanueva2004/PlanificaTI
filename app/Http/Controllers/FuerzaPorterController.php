<?php

namespace App\Http\Controllers;

use App\Models\FuerzaPorter;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;
use App\Models\AnalisisFoda;

class FuerzaPorterController extends Controller
{
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Seleccione un plan estratégico primero.');
        }

        $registro = FuerzaPorter::where('plan_id', $planId)->first();

        return view('fuerza_porter.index', compact('registro'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'crecimiento' => 'required|integer|min:1|max:5',
            'naturaleza_competidores' => 'required|integer|min:1|max:5',
            'exceso_capacidad_productiva' => 'required|integer|min:1|max:5',
            'rentabilidad_media_sector' => 'required|integer|min:1|max:5',
            'diferenciacion_producto' => 'required|integer|min:1|max:5',
            'barreras_salida' => 'required|integer|min:1|max:5',
            'economias_escala' => 'required|integer|min:1|max:5',
            'necesidad_capital' => 'required|integer|min:1|max:5',
            'acceso_tecnologia' => 'required|integer|min:1|max:5',
            'reglamentos_leyes' => 'required|integer|min:1|max:5',
            'tramites_burocraticos' => 'required|integer|min:1|max:5',
            'numero_clientes' => 'required|integer|min:1|max:5',
            'integracion_ascendente' => 'required|integer|min:1|max:5',
            'rentabilidad_clientes' => 'required|integer|min:1|max:5',
            'coste_cambio' => 'required|integer|min:1|max:5',
            'disponibilidad_sustitutivos' => 'required|integer|min:1|max:5',
        ]);

        $total = collect($validated)->except('plan_id')->sum();
        $conclusion = match (true) {
            $total < 30 => 'Estamos en un mercado altamente competitivo...',
            $total < 45 => 'Competitividad relativamente alta...',
            $total < 60 => 'La situación actual del mercado es favorable...',
            default => 'Estamos en una situación excelente para la empresa.',
        };

        // Buscar análisis existente o crear uno nuevo
        $registro = FuerzaPorter::updateOrCreate(
            ['plan_id' => $validated['plan_id']],
            [...$validated, 'conclusion' => $conclusion]
        );

        return redirect()->route('fuerza_porter.resultado', $registro->id);
    }

    public function resultado($id)
    {
        $registro = FuerzaPorter::findOrFail($id);
        $foda = AnalisisFoda::where('plan_id', $registro->plan_id)->first();

        // Calcular puntaje total
        $total = collect($registro->toArray())->only([
            'crecimiento', 'naturaleza_competidores', 'exceso_capacidad_productiva',
            'rentabilidad_media_sector', 'diferenciacion_producto', 'barreras_salida',
            'economias_escala', 'necesidad_capital', 'acceso_tecnologia',
            'reglamentos_leyes', 'tramites_burocraticos',
            'numero_clientes', 'integracion_ascendente',
            'rentabilidad_clientes', 'coste_cambio',
            'disponibilidad_sustitutivos'
        ])->sum();

        return view('fuerza_porter.resultado', compact('registro', 'foda', 'total'));
    }

    public function guardarFoda(Request $request, $id)
    {
        $porter = FuerzaPorter::findOrFail($id);

        $request->validate([
            'oportunidades' => 'nullable|array',
            'amenazas' => 'nullable|array',
        ]);

        $foda = AnalisisFoda::firstOrNew(['plan_id' => $porter->plan_id]);

        $foda->oportunidades = array_values(array_unique(array_filter(array_merge(
            $foda->oportunidades ?? [],
            $request->oportunidades ?? []
        ))));

        $foda->amenazas = array_values(array_unique(array_filter(array_merge(
            $foda->amenazas ?? [],
            $request->amenazas ?? []
        ))));

        $foda->save();

        return back()->with('success', 'Oportunidades y amenazas guardadas correctamente.');
    }

    public function edit($id)
    {
        $registro = FuerzaPorter::findOrFail($id);
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        return view('fuerza_porter.edit', compact('registro', 'planes'));
    }

    public function update(Request $request, $id)
    {
        $registro = FuerzaPorter::findOrFail($id);

        $validated = $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'crecimiento' => 'nullable|integer|min:1|max:5',
            'naturaleza_competidores' => 'nullable|integer|min:1|max:5',
            'exceso_capacidad_productiva' => 'nullable|integer|min:1|max:5',
            'rentabilidad_media_sector' => 'nullable|integer|min:1|max:5',
            'diferenciacion_producto' => 'nullable|integer|min:1|max:5',
            'barreras_salida' => 'nullable|integer|min:1|max:5',
            'economias_escala' => 'nullable|integer|min:1|max:5',
            'necesidad_capital' => 'nullable|integer|min:1|max:5',
            'acceso_tecnologia' => 'nullable|integer|min:1|max:5',
            'reglamentos_leyes' => 'nullable|integer|min:1|max:5',
            'tramites_burocraticos' => 'nullable|integer|min:1|max:5',
            'numero_clientes' => 'nullable|integer|min:1|max:5',
            'integracion_ascendente' => 'nullable|integer|min:1|max:5',
            'rentabilidad_clientes' => 'nullable|integer|min:1|max:5',
            'coste_cambio' => 'nullable|integer|min:1|max:5',
            'disponibilidad_sustitutivos' => 'nullable|integer|min:1|max:5',
            'conclusion' => 'nullable|string',
        ]);

        $registro->update($validated);

        return redirect()->route('fuerza_porter.resultado', $registro->id)->with('success', 'Análisis actualizado correctamente.');
    }

    public function destroy($id)
    {
        $registro = FuerzaPorter::findOrFail($id);
        $registro->delete();

        return redirect()->route('fuerza_porter.index')->with('success', 'Análisis eliminado.');
    }
}
