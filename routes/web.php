<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\ContatoController;

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
    Route::get('/tarefas/eventos', [TarefaController::class, 'eventos'])->middleware('auth');
    Route::post('/tarefas/salvar', [TarefaController::class, 'salvar'])->middleware('auth');
    Route::delete('/tarefas/excluir/{id}', [TarefaController::class, 'excluir'])->middleware('auth');
    Route::post('/tarefas/atualizar/{id}', [TarefaController::class, 'atualizar'])->middleware('auth');
    
    Route::middleware('auth')->group(function () {
        Route::get('/previsao-tempo', [WeatherController::class, 'show'])->middleware(['auth', 'verified'])->name('previsao-tempo');
    });

    Route::get('/mercado', function () {
        return view('mercado');
    })->middleware(['auth', 'verified'])->name('mercado');

    Route::get('/contato', function () {
        return view('contato');
    })->middleware(['auth', 'verified'])->name('contato');
    Route::post('/contato', [App\Http\Controllers\ContatoController::class, 'store'])->middleware(['auth', 'verified'])->name('contato.store');

    Route::get('/politicas', function () {
        return view('politicas');
    })->middleware(['auth', 'verified'])->name('politicas');
});

require __DIR__.'/auth.php';