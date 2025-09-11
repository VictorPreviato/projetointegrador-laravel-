<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversa;
use App\Models\User;

class ChatController extends Controller
{
    // Inicia conversa ou retorna existente
    public function start($userId)
    {
        $authId = auth()->id();

        if ($authId == $userId) {
            return response()->json(['error' => 'Você não pode iniciar conversa consigo mesmo.'], 400);
        }

        $conversa = Conversa::where(function($q) use ($authId, $userId) {
                $q->where('user1_id', $authId)->where('user2_id', $userId);
            })
            ->orWhere(function($q) use ($authId, $userId) {
                $q->where('user1_id', $userId)->where('user2_id', $authId);
            })
            ->first();

        if (!$conversa) {
            $conversa = Conversa::create([
                'user1_id' => $authId,
                'user2_id' => $userId,
            ]);
        }

        return response()->json([
            'conversa_id' => $conversa->id
        ]);
    }

    // Busca mensagens (incremental)
    public function fetch(Request $request, $conversaId)
    {
        $conversa = Conversa::findOrFail($conversaId);

        $lastId = $request->query('last_id', 0);

        $mensagens = $conversa->mensagens()
            ->with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('components.chat-messages', compact('mensagens'));
    }

  
    // Envia mensagem
public function send(Request $request)
{
    $request->validate([
        'conversa_id' => 'required|exists:conversas,id',
        'conteudo' => 'required|string',
    ]);

    $conversa = Conversa::findOrFail($request->conversa_id);

    $mensagem = $conversa->mensagens()->create([
        'user_id' => auth()->id(),
        'conteudo' => $request->conteudo,
    ]);

    $mensagem->load('user');

    return view('components.chat-message', ['msg' => $mensagem]);
}

}
