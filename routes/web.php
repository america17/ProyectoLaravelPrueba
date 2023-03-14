<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'email'])->name('dashboard');

Route::middleware(['auth', 'email'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/generar-codigo', [EmailController::class, 'enviarCorreo'])->name('generar-codigo');
    Route::get('/codigo-movil', [EmailController::class, 'codigoMovil'])->name('codigo-movil');
    Route::get('/cargar-codigo', [EmailController::class, 'cargarCodigo'])->name('cargar-codigo');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/cargar-segundo-codigo', [EmailController::class, 'segundoCodigo'])->name('cargar-segundo-codigo');
});

Route::get('/prueba', [EmailController::class, 'miMetodo'])->name('pruebax');

require __DIR__.'/auth.php';
