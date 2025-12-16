<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\MarketController; // <--- Adicionei a importação aqui
use App\Http\Controllers\PostalCodeTestController;

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

    // Rotas de Tarefas (Lógica)
    Route::get('/tarefas/eventos', [TarefaController::class, 'eventos']);
    Route::post('/tarefas/salvar', [TarefaController::class, 'salvar']);
    Route::delete('/tarefas/excluir/{id}', [TarefaController::class, 'excluir']);
    Route::post('/tarefas/atualizar/{id}', [TarefaController::class, 'atualizar']);
    
    // Previsão do Tempo
    Route::get('/previsao-tempo', [WeatherController::class, 'show'])
        ->middleware(['auth', 'verified'])
        ->name('previsao-tempo');

    // --- ROTA DE MERCADO (Alterada para usar o Controller) ---
    Route::get('/mercado', [MarketController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('mercado');

    // Contato
    Route::get('/contato', function () {
        return view('contato');
    })->middleware(['auth', 'verified'])->name('contato');
    
    Route::post('/contato', [ContatoController::class, 'store'])
        ->middleware(['auth', 'verified'])
        ->name('contato.store');

    // Políticas
    Route::get('/politicas', function () {
        return view('politicas');
    })->middleware(['auth', 'verified'])->name('politicas');
});

require __DIR__.'/auth.php';