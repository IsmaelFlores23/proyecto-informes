<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\TernaController;
use App\Http\Controllers\AdminInformesController;
use App\Http\Controllers\GestionarUsuariosController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('Alumno.inicio.index');
})->middleware(['auth', 'verified'])->name('dashboard');

//Inicio de admin---
Route::get('/AdminIndex', function () {
    return view('Administrador.Inicio.index');
})->middleware(['auth', 'verified'])->name('dashboard');

//Admin empieza
Route::resource('AsignarTerna', TernaController::class)->middleware(['auth','verified']);
Route::resource('AdminInformes', AdminInformesController::class)->middleware(['auth','verified']);
Route::resource('GestionarUsuarios', GestionarUsuariosController::class)->middleware(['auth','verified']);
//Admin termina

Route::resource('subirInforme', InformeController::class)->middleware(['auth','verified']);
Route::resource('observarInforme', RevisionController::class)->middleware(['auth','verified']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
