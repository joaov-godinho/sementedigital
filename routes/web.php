<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/tarefas', function () {return view('tarefas');});

Route::get('/contato', function () {return view('contato');});

Route::get('/sobre', function () {return view('contato');});

Route::get('/politicas', function () {return view('politicas');});