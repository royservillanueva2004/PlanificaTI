<?php

namespace App\Http\Controllers;

use App\Models\Pest;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

class PestController extends Controller
{
    // Mostrar todos los registros PEST
        public function index()
    {
        $planId = session('plan_id');
        
        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Seleccione un plan estratégico primero.');
        }

        $analisis = Pest::where('plan_id', $planId)->with('plan')->get();
        
        return view('pest.index', compact('analisis'));
    }

    // Mostrar formulario para crear nuevo análisis PEST
    public function create()
    {
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        return view('pest.create', compact('planes'));
    }

    // Guardar nuevo análisis PEST en BD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'politicos' => 'nullable|string',
            'economicos' => 'nullable|string',
            'sociales' => 'nullable|string',
            'tecnologicos' => 'nullable|string',
            'ambientales' => 'nullable|string',
            'legales' => 'nullable|string',
            'oportunidades' => 'nullable|string',
            'amenazas' => 'nullable|string',
            'conclusion' => 'nullable|string',
        ]);

        // Convertir arrays a JSON si es necesario
        $validated['oportunidades'] = $request->has('oportunidades') 
            ? json_encode($request->oportunidades) 
            : null;
            
        $validated['amenazas'] = $request->has('amenazas') 
            ? json_encode($request->amenazas) 
            : null;

        try {
            Pest::create($validated);
            return redirect()->route('pest.index')->with('success', 'Análisis PEST guardado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al guardar: '.$e->getMessage());
        }
    }

    // Mostrar un análisis PEST para editar
    public function edit($id)
    {
        $registro = Pest::findOrFail($id);
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();

        return view('pest.edit', compact('registro', 'planes'));
    }

    // Actualizar un análisis PEST en la base de datos
    public function update(Request $request, $id)
    {
        $registro = Pest::findOrFail($id);

        $validated = $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'politicos' => 'nullable|string',
            'economicos' => 'nullable|string',
            'sociales' => 'nullable|string',
            'tecnologicos' => 'nullable|string',
            'ambientales' => 'nullable|string',
            'legales' => 'nullable|string',
            'oportunidades' => 'nullable|string',
            'amenazas' => 'nullable|string',
            'conclusion' => 'nullable|string',
        ]);

        // Actualizar arrays si es necesario
        if ($request->has('oportunidades')) {
            $validated['oportunidades'] = json_encode($request->oportunidades);
        }
        
        if ($request->has('amenazas')) {
            $validated['amenazas'] = json_encode($request->amenazas);
        }

        $registro->update($validated);

        return redirect()->route('pest.index')->with('success', 'Análisis PEST actualizado correctamente.');
    }

    // Eliminar un análisis PEST de la base de datos
    public function destroy($id)
    {
        $registro = Pest::findOrFail($id);
        $registro->delete();

        return redirect()->route('pest.index')->with('success', 'Análisis PEST eliminado.');
    }
}