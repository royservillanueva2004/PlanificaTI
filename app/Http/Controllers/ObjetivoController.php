<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

class ObjetivoController extends Controller
{
    public function index()
    {
        $generales = Objetivo::where('tipo', 'general')
            ->whereHas('plan', function ($q) {
                $q->where('user_id', auth()->id());
            })->with('especificos')->get();

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

        // Crear objetivos específicos si hay
        if ($request->has('especificos')) {
            foreach ($request->especificos as $desc) {
                if ($desc) {
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
        $objetivo = Objetivo::findOrFail($id);
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        $generales = Objetivo::where('tipo', 'general')->where('id', '!=', $id)->get();

        return view('objetivos.edit', compact('objetivo', 'planes', 'generales'));
    }

    public function update(Request $request, $id)
    {
        $objetivo = Objetivo::findOrFail($id);

        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'tipo' => 'required|in:general,especifico',
            'descripcion' => 'required|string',
            'parent_id' => 'nullable|exists:objetivos,id',
        ]);

        $objetivo->update([
            'plan_id' => $request->plan_id,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('objetivos.index')->with('success', 'Objetivo actualizado.');
    }

    public function destroy($id)
    {
        $objetivo = Objetivo::findOrFail($id);
        $objetivo->delete();

        return redirect()->route('objetivos.index')->with('success', 'Objetivo eliminado.');
    }
}