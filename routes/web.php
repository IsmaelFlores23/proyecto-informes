<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\TernaController;
use App\Http\Controllers\AdminInformesController;
use App\Http\Controllers\GestionarUsuariosController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\DocenteUserController;
use App\Http\Controllers\AlumnoUserController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\GestionarAlumnosController;
use App\Http\Controllers\GestionarDocentesController;
use App\Http\Controllers\GestionarAdminsController;

// Ruta principal redirige a login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas para todos los usuarios autenticados
Route::get('/dashboard', function () {
    return view('Alumno.inicio.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para administradores
// En la sección de rutas para admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('AsignarTerna', TernaController::class);
    Route::resource('AdminInformes', AdminInformesController::class);
    Route::resource('GestionarUsuarios', GestionarUsuariosController::class);

    //Estas dos rutas serian eliminadas luego de implementar rutas /alumnos/{id} y /docentes/{id}
    // Route::resource('UserDocente', DocenteUserController::class);
    // Route::resource('UserAlumno', AlumnoUserController::class);
    Route::resource('campus', CampusController::class);
    Route::resource('facultad', FacultadController::class);        

    Route::resource('GestionarAlumnos', GestionarAlumnosController::class);
    Route::resource('GestionarDocentes', GestionarDocentesController::class);
    Route::resource('GestionarAdmins', GestionarAdminsController::class);

    Route::get('/ver-informes/{numero_cuenta}', [AdminInformesController::class, 'verTodosLosInformes'])
    ->name('verInformes.alumno');

    // Rutas para mostrar perfil de usuario
    Route::get('/alumnos/{id}', [AlumnoUserController::class, 'show'])->name('alumnos.show');
    Route::get('/docentes/{id}', [DocenteUserController::class, 'show'])->name('docentes.show');
});

// Rutas para docentes
Route::middleware(['auth', 'verified', 'role:docente'])->group(function () {
    // Otras rutas específicas para docentes
});

// Rutas para alumnos
Route::middleware(['auth', 'verified', 'role:alumno'])->group(function () {
    Route::resource('subirInforme', InformeController::class);
    Route::resource('observarInforme', RevisionController::class);
    Route::resource('informacionTerna', InformacionController::class);
    // Otras rutas específicas para alumnos

        // Ruta para mostrar el PDF protegido dentro del iframe
    Route::get('/observarInforme/pdf/{nombreArchivo}', [RevisionController::class, 'verPdf'])
        ->name('observarInforme.pdf');
});


// Rutas compartidas entre roles (si es necesario)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';