<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\TernaController;
use App\Http\Controllers\AdminInformesController;
use App\Http\Controllers\GestionarUsuariosController;

// Ruta principal redirige a login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas para todos los usuarios autenticados
Route::get('/dashboard', function () {
    return view('Alumno.inicio.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para administradores
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('AsignarTerna', TernaController::class);
    Route::resource('AdminInformes', AdminInformesController::class);
    Route::resource('GestionarUsuarios', GestionarUsuariosController::class);
});

// Rutas para docentes
Route::middleware(['auth', 'verified', 'role:docente'])->group(function () {
    // Otras rutas específicas para docentes
});

// Rutas para alumnos
Route::middleware(['auth', 'verified', 'role:alumno'])->group(function () {
    Route::resource('subirInforme', InformeController::class);
    Route::resource('observarInforme', RevisionController::class);
    // Otras rutas específicas para alumnos
});

// Rutas compartidas entre roles (si es necesario)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
