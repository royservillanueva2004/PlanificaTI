<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanEstrategicoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MatrizCAMEController;
use App\Http\Controllers\CadenaValorController;
use App\Http\Controllers\AnalisisFodaController;

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
    Route::get('/matriz-participacion', [App\Http\Controllers\MatrizParticipacionController::class, 'index'])->name('matriz.participacion');

    // Registrar todo menos `show`
    Route::resource('cadena-valor', CadenaValorController::class)->except(['show']);
});

require __DIR__.'/auth.php';
