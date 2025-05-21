<?php

namespace App\Http\Controllers;

use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

class PlanEstrategicoController extends Controller
{
    public function index()
    {
        $planes = PlanEstrategico::where('user_id', auth()->id())
                              ->where('estado', true)
                              ->get();

         return view('planes.index', compact('planes'));
    }

    public function create()
    {
        return view('planes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_plan' => 'required|string|max:255',
            'mision' => 'nullable|string',
            'vision' => 'nullable|string',
            'valores' => 'nullable|array', // Cambiado: ahora se espera un array
            'valores.*' => 'nullable|string' // Cada valor debe ser texto
        ]);

        PlanEstrategico::create([
            'user_id' => auth()->id(),
            'nombre_plan' => $request->nombre_plan,
            'mision' => $request->mision,
            'vision' => $request->vision,
            'valores' => implode(',', array_filter($request->valores)), // Convertimos el array a string
        ]);

        return redirect()->route('planes.index')->with('success', 'Plan creado correctamente.');
    }

    public function edit($id)
    {
        $plane = \App\Models\PlanEstrategico::findOrFail($id);
        return view('planes.edit', compact('plane'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_plan' => 'required|string|max:255',
            'mision' => 'nullable|string',
            'vision' => 'nullable|string',
            'valores' => 'nullable|array',
            'valores.*' => 'nullable|string'
        ]);

        $plane = PlanEstrategico::findOrFail($id);

        $plane->update([
            'nombre_plan' => $request->nombre_plan,
            'mision' => $request->mision,
            'vision' => $request->vision,
            'valores' => implode(',', array_filter($request->valores)),
        ]);

        return redirect()->route('planes.index')->with('success', 'Plan actualizado.');
    }

    public function destroy($id)
    {
        $plan = \App\Models\PlanEstrategico::findOrFail($id);

        // Solo permitir desactivar si pertenece al usuario autenticado
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }

        $plan->estado = false;
        $plan->save();

        return redirect()->route('planes.index')->with('success', 'Plan desactivado correctamente.');
    }
    public function seleccionar(Request $request)

    {
        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id'
        ]);

        session(['plan_id' => $request->plan_id]);

        return redirect()->route('objetivos.index')->with('success', 'Plan seleccionado correctamente.');
    }
}
