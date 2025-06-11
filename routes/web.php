<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanEstrategicoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MatrizCAMEController;
use App\Http\Controllers\CadenaValorController;
use App\Http\Controllers\AnalisisFodaController;
use App\Http\Controllers\MatrizBCGController;
use App\Http\Controllers\FuerzaPorterController;
use App\Http\Controllers\PestController;
use App\Http\Controllers\ResumenEjecutivoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Planes: ver, crear, seleccionar
    Route::resource('planes', PlanEstrategicoController::class);
    Route::post('/planes/seleccionar', [PlanEstrategicoController::class, 'seleccionar'])->name('planes.seleccionar');
});

Route::middleware(['auth', 'plan.selected'])->group(function () {
    Route::resource('objetivos', ObjetivoController::class);
    Route::resource('matrizcame', MatrizCAMEController::class);

    // Rutas específicas para Cadena de Valor
    Route::get('/cadena-valor/analisis', [CadenaValorController::class, 'verAnalisis'])->name('cadena-valor.ver');
    Route::post('/cadena-valor/analisis', [CadenaValorController::class, 'mostrarAnalisis'])->name('cadena-valor.analisis');
    Route::post('/generar-reflexion', [CadenaValorController::class, 'generarReflexion'])->name('generar.reflexion');

    // Guardar FODA
    Route::post('/foda/guardar', [AnalisisFodaController::class, 'guardar'])->name('foda.guardar');


    // Matriz - bcg
    Route::get('/matriz-bcg', [MatrizBCGController::class, 'index'])->name('matriz-bcg.index');
    Route::post('/matriz-bcg', [MatrizBCGController::class, 'store'])->name('matriz-bcg.store');
    Route::get('/matriz-bcg/resultado', [MatrizBCGController::class, 'resultado'])->name('matriz-bcg.resultado');
    


    // Redirección inteligente: index o resultado según exista el análisis
    Route::get('/fuerza_porter/redirigir', function () {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Seleccione un plan estratégico primero.');
        }

        $analisis = \App\Models\FuerzaPorter::where('plan_id', $planId)->first();

        return $analisis
            ? redirect()->route('fuerza_porter.resultado', $analisis->id)
            : redirect()->route('fuerza_porter.index');
    })->name('fuerza_porter.redirigir');

    // Recurso completo
    Route::resource('fuerza_porter', FuerzaPorterController::class);
    Route::get('/fuerza_porter/{id}/resultado', [FuerzaPorterController::class, 'resultado'])->name('fuerza_porter.resultado');
    Route::post('/fuerza_porter/{id}/guardar-foda', [FuerzaPorterController::class, 'guardarFoda'])->name('fuerza_porter.guardar_foda');

    Route::resource('pest', PestController::class);

    // Registrar todo menos `show`
    Route::resource('cadena-valor', CadenaValorController::class)->except(['show']);

    Route::get('/resumen-ejecutivo', [ResumenEjecutivoController::class, 'index'])->name('resumen-ejecutivo.index');
    Route::post('/resumen-ejecutivo', [ResumenEjecutivoController::class, 'store'])->name('resumen-ejecutivo.store');
    Route::get('/resumen-ejecutivo/mostrar', [ResumenEjecutivoController::class, 'mostrar'])->name('resumen-ejecutivo.mostrar');
});

require __DIR__.'/auth.php';
