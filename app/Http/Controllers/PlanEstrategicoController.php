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
            'valores' => 'nullable|string',
        ]);

        PlanEstrategico::create([
            'user_id' => auth()->id(),
            'nombre_plan' => $request->nombre_plan,
            'mision' => $request->mision,
            'vision' => $request->vision,
            'valores' => $request->valores,
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
            'valores' => 'nullable|string',
        ]);

        $plane = \App\Models\PlanEstrategico::findOrFail($id);
        $plane->update($request->all());

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
}
