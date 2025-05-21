<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

class ObjetivoController extends Controller
{
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Seleccione un plan estratégico primero.');
        }

        $generales = Objetivo::where('tipo', 'general')
            ->where('plan_id', $planId) // ✅ Solo objetivos del plan seleccionado
            ->with('especificos')
            ->get();

        return view('objetivos.index', compact('generales'));
    }

    public function create()
    {
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        return view('objetivos.create', compact('planes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'descripcion_general' => 'required|string',
            'especificos.*' => 'nullable|string'
        ]);

        // Crear objetivo general
        $general = Objetivo::create([
            'plan_id' => $request->plan_id,
            'tipo' => 'general',
            'descripcion' => $request->descripcion_general,
        ]);

        // Crear objetivos específicos si existen
        if ($request->has('especificos')) {
            foreach ($request->especificos as $desc) {
                if (!empty($desc)) {
                    Objetivo::create([
                        'plan_id' => $request->plan_id,
                        'tipo' => 'especifico',
                        'descripcion' => $desc,
                        'parent_id' => $general->id,
                    ]);
                }
            }
        }

        return redirect()->route('objetivos.index')->with('success', 'Objetivos guardados correctamente.');
    }

    public function edit($id)
    {
        $objetivo = Objetivo::with('especificos')->findOrFail($id);
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        $generales = Objetivo::where('tipo', 'general')->where('id', '!=', $id)->get();

        return view('objetivos.edit', compact('objetivo', 'planes', 'generales'));
    }

    public function update(Request $request, $id)
    {
        $objetivo = Objetivo::findOrFail($id);

        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'descripcion' => 'required|string',
            'especificos' => 'nullable|array',
            'especificos.*' => 'nullable|string'
        ]);

        // Actualizar objetivo general
        $objetivo->update([
            'plan_id' => $request->plan_id,
            'descripcion' => $request->descripcion
        ]);

        // Eliminar específicos antiguos
        Objetivo::where('parent_id', $objetivo->id)->delete();

        // Crear nuevos específicos
        if ($request->has('especificos')) {
            foreach ($request->especificos as $desc) {
                if (!empty($desc)) {
                    Objetivo::create([
                        'plan_id' => $request->plan_id,
                        'tipo' => 'especifico',
                        'descripcion' => $desc,
                        'parent_id' => $objetivo->id,
                    ]);
                }
            }
        }

        return redirect()->route('objetivos.index')->with('success', 'Objetivo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $objetivo = Objetivo::findOrFail($id);
        $objetivo->delete();

        return redirect()->route('objetivos.index')->with('success', 'Objetivo eliminado.');
    }
}