<?php

namespace App\Http\Controllers;

use App\Models\FuerzaPorter;
use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

class FuerzaPorterController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Seleccione un plan estratégico primero.');
        }

        // Obtener todos los análisis de las 5 Fuerzas de Porter relacionados con el plan seleccionado
        $analisis = FuerzaPorter::where('plan_id', $planId)->get();

        return view('fuerza_porter.index', compact('analisis'));
    }

    // Mostrar formulario para crear nuevo análisis
    public function create()
    {
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();
        return view('fuerza_porter.create', compact('planes'));
    }

            // Guardar nuevo análisis en BD
            public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            // ... tus otras validaciones
        ]);

        // Convertir arrays a JSON si existen
        $validated['oportunidades'] = $request->has('oportunidades') 
            ? json_encode($request->oportunidades) 
            : null;
            
        $validated['amenazas'] = $request->has('amenazas') 
            ? json_encode($request->amenazas) 
            : null;

        try {
            FuerzaPorter::create($validated);
            return redirect()->route('fuerza_porter.index')->with('success', 'Análisis guardado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al guardar: '.$e->getMessage());
        }
    }

    // Mostrar un análisis para editar
    public function edit($id)
    {
        $registro = FuerzaPorter::findOrFail($id);
        $planes = PlanEstrategico::where('user_id', auth()->id())->get();

        return view('fuerza_porter.edit', compact('registro', 'planes'));
    }

    // Actualizar un análisis en la base de datos
    public function update(Request $request, $id)
    {
        // Buscar el análisis de FuerzaPorter por ID
        $registro = FuerzaPorter::findOrFail($id);

        // Validación de los campos
        $request->validate([
            'plan_id' => 'required|exists:plan_estrategicos,id',
            'crecimiento' => 'nullable|integer|min:1|max:6',
            'naturaleza_competidores' => 'nullable|integer|min:1|max:6',
            'exceso_capacidad_productiva' => 'nullable|integer|min:1|max:6',
            'rentabilidad_media_sector' => 'nullable|integer|min:1|max:6',
            'diferenciacion_producto' => 'nullable|integer|min:1|max:6',
            'barreras_salida' => 'nullable|integer|min:1|max:6',
            'economias_escala' => 'nullable|integer|min:1|max:6',
            'necesidad_capital' => 'nullable|integer|min:1|max:6',
            'acceso_tecnologia' => 'nullable|integer|min:1|max:6',
            'reglamentos_leyes' => 'nullable|integer|min:1|max:6',
            'tramites_burocraticos' => 'nullable|integer|min:1|max:6',
            'reaccion_competidores' => 'nullable|integer|min:1|max:6',
            'numero_clientes' => 'nullable|integer|min:1|max:6',
            'integracion_ascendente' => 'nullable|integer|min:1|max:6',
            'rentabilidad_clientes' => 'nullable|integer|min:1|max:6',
            'coste_cambio' => 'nullable|integer|min:1|max:6',
            'disponibilidad_sustitutivos' => 'nullable|integer|min:1|max:6',
            'conclusion' => 'nullable|string',
            'oportunidades' => 'nullable|string',
            'amenazas' => 'nullable|string',
        ]);

        // Actualizar el análisis en la base de datos
        $registro->update($request->all());

        // Redirigir al listado con mensaje de éxito
        return redirect()->route('fuerza_porter.index')->with('success', 'Análisis actualizado correctamente.');
    }

    // Eliminar un análisis de la base de datos
    public function destroy($id)
    {
        // Buscar el registro por ID
        $registro = FuerzaPorter::findOrFail($id);
        $registro->delete();

        // Redirigir al listado con mensaje de éxito
        return redirect()->route('fuerza_porter.index')->with('success', 'Análisis eliminado.');
    }
}
