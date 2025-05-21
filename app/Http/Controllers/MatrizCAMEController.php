<?php

namespace App\Http\Controllers;

use App\Models\MatrizCAME;
use Illuminate\Http\Request;

class MatrizCAMEController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        $acciones = MatrizCAME::all();
        return view('matrizcame.index', compact('acciones'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        return view('matrizcame.create');
    }

    // Guardar nuevo registro en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'accion' => 'required|string|max:255',
            'tipo' => 'required|in:C,A,M,E'
        ]);

        MatrizCAME::create($request->all());

        return redirect()->route('matrizcame.index')->with('success', 'Acción registrada correctamente.');
    }

    // Mostrar el formulario para editar un registro existente
    public function edit($id)
    {
        // Busca el registro por ID
        $matrizcame = MatrizCAME::findOrFail($id);

        // Pasa la variable a la vista
        return view('matrizcame.edit', compact('matrizcame'));
    }

    // Actualizar el registro en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|string|max:255',
            'tipo' => 'required|in:C,A,M,E'
        ]);

        $accion = MatrizCAME::findOrFail($id);
        $accion->update($request->all());

        return redirect()->route('matrizcame.index')->with('success', 'Acción actualizada correctamente.');
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $accion = MatrizCAME::findOrFail($id);
        $accion->delete();

        return redirect()->route('matrizcame.index')->with('success', 'Acción eliminada correctamente.');
    }
}
