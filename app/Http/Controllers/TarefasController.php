<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarefasController extends Controller
{
    public function index()
    {
        return view('tarefas');
    }
}
