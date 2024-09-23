<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoMail;


class ContatoController extends Controller
{
    public function create()
    {
        return view('contato');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensagem' => 'required|string|max:500',
        ]);

        // Aqui você pode enviar e-mail ou armazenar no banco de dados
        Mail::to('seu_email@exemplo.com')->send(new ContatoMail($validated));
        
        return back()->with('success', 'Mensagem enviada com sucesso!');
    }
}
