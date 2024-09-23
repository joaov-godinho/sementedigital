<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    public function eventos()
    {
        $tarefas = Tarefa::all();

        $eventos = [];
        foreach ($tarefas as $tarefa) {
            $eventos[] = [
                'id' => $tarefa->id,
                'title' => $tarefa->titulo,
                'start' => $tarefa->data_inicio,
                'end'   => $tarefa->data_fim,
            ];
        }

        return response()->json($eventos);
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
        ]);
    
        $tarefa = new Tarefa();
        $tarefa->titulo = $request->input('title');
        $tarefa->data_inicio = $request->input('start');
        $tarefa->data_fim = $request->input('end');
        $tarefa->save();
    
        return response()->json([
            'status' => true,
            'id' => $tarefa->id,
            'message' => 'Tarefa salva com sucesso!',
        ]);
    }
    public function excluir($id)
    {
        $tarefa = Tarefa::find($id);

        if ($tarefa) {
            $tarefa->delete();
            return response()->json(['status' => 'Tarefa excluída com sucesso!']);
        }

        return response()->json(['status' => 'Tarefa não encontrada!'], 404);
    }

    public function atualizar(Request $request, $id)
    {
        \Log::info('Atualizando tarefa:', [
            'id' => $id,
            'request_data' => $request->all(),
        ]);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
        ]);

        $tarefa = Tarefa::find($id);

        if ($tarefa) {
            $tarefa->titulo = $request->input('title');
            $tarefa->data_inicio = $request->input('start');
            $tarefa->data_fim = $request->input('end');
            $tarefa->save();

            return response()->json(['status' => true, 'message' => 'Tarefa atualizada com sucesso!']);
        }

        return response()->json(['status' => false, 'message' => 'Tarefa não encontrada!'], 404);
    }

}
