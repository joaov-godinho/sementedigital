<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return view('home');
    })->middleware(['auth', 'verified'])->name('/');

    Route::get('/tarefas', function () {
        return view('tarefas');
    })->middleware(['auth', 'verified'])->name('tarefas');
    
    Route::middleware('auth')->group(function () {
        Route::get('/previsao-tempo', [WeatherController::class, 'show'])->middleware(['auth', 'verified'])->name('previsao-tempo');
    });

    Route::get('/mercado', function () {
        return view('mercado');
    })->middleware(['auth', 'verified'])->name('mercado');

    Route::get('/contato', function () {
        return view('contato');
    })->middleware(['auth', 'verified'])->name('contato');

    Route::get('/sobre', function () {
        return view('sobre');
    })->middleware(['auth', 'verified'])->name('sobre');

    Route::get('/politicas', function () {
        return view('politicas');
    })->middleware(['auth', 'verified'])->name('politicas');
});

require __DIR__.'/auth.php';