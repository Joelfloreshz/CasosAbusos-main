<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// ==============================
//      MÓDULO ABOGADA
// ==============================
use App\Http\Controllers\Abogada\CasoController;
use App\Http\Controllers\Abogada\SeguimientoController;
use App\Http\Controllers\Abogada\DashboardController;
use App\Http\Controllers\Abogada\FormularioController;
use App\Http\Controllers\Abogada\RespuestaController;
use App\Http\Controllers\Abogada\GestionFormularioController;
use App\Http\Controllers\Abogada\PreguntaController;

// ==============================
//      MÓDULO PSICÓLOGA
// ==============================
use App\Http\Controllers\Psicologa\PsicologaCasoController;
use App\Http\Controllers\Psicologa\PsicologaSeguimientoController;
use App\Http\Controllers\Psicologa\PsicologaDashboardController;


// Página inicial (ajústalo si quieres redirigir al dashboard)
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard general (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por login
Route::middleware('auth')->group(function () {

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==============================
    //      MÓDULO ABOGADA
    // ==============================
    Route::prefix('abogada')->name('abogada.')->group(function () {

        // Home del módulo
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Casos (REST)
        Route::resource('casos', CasoController::class);

        // Seguimientos
        Route::post('casos/{caso}/seguimientos', [SeguimientoController::class, 'store'])->name('seguimientos.store');
        Route::delete('seguimientos/{seguimiento}', [SeguimientoController::class, 'destroy'])->name('seguimientos.destroy');

        // Formularios dinámicos
        Route::get('casos/{caso}/formularios', [FormularioController::class, 'index'])->name('formularios.index');
        Route::get('casos/{caso}/formularios/{formulario}', [FormularioController::class, 'show'])->name('formularios.show');

        // Respuestas de sesión
        Route::post('sesiones/{sesion}/respuestas', [RespuestaController::class, 'store'])->name('respuestas.store');
        Route::get('sesiones/{sesion}', [FormularioController::class, 'verSesion'])->name('sesiones.show');

        // Gestión de formularios y preguntas
        Route::resource('gestion-formularios', GestionFormularioController::class);
        Route::resource('gestion-formularios.preguntas', PreguntaController::class)->except(['show', 'index']);
    });

    // ==============================
    //      MÓDULO PSICÓLOGA
    // ==============================
    Route::prefix('psicologa')->name('psicologa.')->group(function () {

        // Dashboard del módulo
        Route::get('/', [PsicologaDashboardController::class, 'index'])->name('dashboard');

        // Casos Psicológicos (Expedientes)
        Route::resource('casos', PsicologaCasoController::class);

        // Seguimientos de Casos Psicológicos
        Route::post('casos/{caso}/seguimientos', [PsicologaSeguimientoController::class, 'store'])->name('seguimientos.store');
        Route::delete('seguimientos/{seguimiento}', [PsicologaSeguimientoController::class, 'destroy'])->name('seguimientos.destroy');
    
    
    });
});

// Rutas de autenticación (Breeze)
require __DIR__ . '/auth.php';
