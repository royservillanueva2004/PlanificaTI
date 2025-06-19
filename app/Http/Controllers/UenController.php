<?php

namespace App\Http\Controllers;

use App\Models\Uen;
use Illuminate\Http\Request;

class UenController extends Controller
{
    public function index()
    {
        $plan_id = session('plan_id');
        $uens = Uen::where('plan_id', $plan_id)->get();

        return view('uen.index', compact('uens'));
    }

    public function store(Request $request)
    {
        $request->validate(['descripcion' => 'required|string']);

        Uen::create([
            'plan_id' => session('plan_id'),
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', 'UEN registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['descripcion' => 'required|string']);
        $uen = Uen::findOrFail($id);
        $uen->update(['descripcion' => $request->descripcion]);

        return redirect()->route('uen.index')->with('success', 'UEN actualizada correctamente.');
    }

    public function destroy($id)
    {
        Uen::where('id', $id)->delete();
        return redirect()->back()->with('success', 'UEN eliminada.');
    }
}