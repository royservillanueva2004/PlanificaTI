<?php

use App\Models\PlanEstrategico;
use Illuminate\Http\Request;

public function index()
{
    $planes = PlanEstrategico::where('user_id', auth()->id())->get();
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

public function edit(PlanEstrategico $plane)
{
    $this->authorize('update', $plane);
    return view('planes.edit', compact('plane'));
}

public function update(Request $request, PlanEstrategico $plane)
{
    $request->validate([
        'nombre_plan' => 'required|string|max:255',
        'mision' => 'nullable|string',
        'vision' => 'nullable|string',
        'valores' => 'nullable|string',
    ]);

    $plane->update($request->all());

    return redirect()->route('planes.index')->with('success', 'Plan actualizado.');
}

public function destroy(PlanEstrategico $plane)
{
    $this->authorize('delete', $plane);
    $plane->delete();

    return redirect()->route('planes.index')->with('success', 'Plan eliminado.');
}
