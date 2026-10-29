<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CasoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbonadoController;

// Rutas de Autenticación (Públicas)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas Protegidas (Solo para usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('/main', [MainController::class, 'index'])->name('main.index');

    // Rutas para la ventana emergente de Casos
    Route::get('/casos/crear', [CasoController::class, 'create'])->name('casos.create');
    Route::post('/casos/guardar', [CasoController::class, 'store'])->name('casos.store');

    // Ventana emergente de Consulta Histórica
    Route::get('/casos/consulta-historica', [CasoController::class, 'consultaHistorica'])->name('casos.consulta_historica');

    // Ventana emergente del Detalle de Caso Histórico
    Route::get('/casos/detalle/{id}', [CasoController::class, 'detalle'])->name('casos.detalle');

    // Endpoints AJAX para la cascada de Tipologías
    Route::get('/api/categorias/{tipoId}', [CasoController::class, 'getCategorias'])->name('api.categorias');
    Route::get('/api/tipologias/{categoriaId}', [CasoController::class, 'getTipologias'])->name('api.tipologias');

    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');

        //Nuevas rutas de edición
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

        //Ruta para descarga de reporte
        Route::get('/abonados/exportar', [AbonadoController::class, 'exportarExcel'])->name('abonados.exportar');
    });
});
