<?php

namespace App\Http\Controllers;

use App\Models\MatrizCAME;
use Illuminate\Http\Request;

class MatrizCAMEController extends Controller
{
    // Mostrar la matriz CAME y formulario unificado
    public function index(Request $request)
    {
        $plan_id = session('plan_id');
        $acciones = MatrizCAME::where('plan_id', $plan_id)->get();

        // Si se solicita edición
        $editar = null;
        if ($request->has('editar')) {
            $editar = MatrizCAME::where('id', $request->editar)
                                ->where('plan_id', $plan_id)
                                ->firstOrFail();
        }

        return view('matrizcame.index', compact('acciones', 'editar'));
    }

    // Guardar nueva acción
    public function store(Request $request)
    {
        $request->validate([
            'accion' => 'required|string|max:255',
            'tipo' => 'required|in:C,A,M,E',
        ]);

        MatrizCAME::create([
            'accion' => $request->accion,
            'tipo' => $request->tipo,
            'plan_id' => session('plan_id'),
        ]);

        return redirect()->route('matrizcame.index')->with('success', 'Acción registrada correctamente.');
    }

    // Actualizar una acción existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|string|max:255',
            'tipo' => 'required|in:C,A,M,E',
        ]);

        $accion = MatrizCAME::where('id', $id)
                            ->where('plan_id', session('plan_id'))
                            ->firstOrFail();

        $accion->update([
            'accion' => $request->accion,
            'tipo' => $request->tipo,
            'plan_id' => session('plan_id'),
        ]);

        return redirect()->route('matrizcame.index')->with('success', 'Acción actualizada correctamente.');
    }

    // Eliminar acción
    public function destroy($id)
    {
        $accion = MatrizCAME::where('id', $id)
                            ->where('plan_id', session('plan_id'))
                            ->firstOrFail();

        $accion->delete();

        return redirect()->route('matrizcame.index')->with('success', 'Acción eliminada correctamente.');
    }
}
