<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanEstrategicoController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\MatrizCAMEController;

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
    // Aquí puedes agregar también FODA, PEST, etc.
});

require __DIR__.'/auth.php';
