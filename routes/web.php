<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome'); //<----  Default
// });

Route::get('/', function () {
    return redirect()->route('login');  //<-----  Opción 1
});

// Route::get('/', function () {
//     return view('auth.login'); //<------ Opción 2
// });

// Route::get('/dashboard', [RegisterController::class, 'index'])->middleware(['auth','verified'])->name('dashboard'); <--- Default

// JB - Cargas principales del sistema de registros.
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [RegisterController::class, 'index'])->name('dashboard');
    Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');
    Route::post('/register/duplicate', [RegisterController::class, 'duplicate'])->name('register.duplicate');
    Route::delete('/register/deletetable', [RegisterController::class, 'deletetable'])->name('register.deletetable');
    Route::get('/register/{id}/edit', [RegisterController::class, 'edit'])->name('register.edit');
    Route::put('/register/{id}/update', [RegisterController::class, 'update'])->name('register.update');
    Route::delete('/register/{id}/destroy', [RegisterController::class, 'destroy'])->name('register.destroy');
});

// JB - Historial de todo los registro cargados en el sistema.
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/register/{anio?}/loghistory', [RegisterController::class, 'loghistory'])->name('register.loghistory');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/:id', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
