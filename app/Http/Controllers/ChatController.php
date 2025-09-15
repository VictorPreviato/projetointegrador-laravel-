<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversa;
use App\Models\User;    
use App\Models\Mensagem;

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

    // Identifica o outro usuário
    $outroUser = $conversa->user1_id == $authId ? $conversa->user2 : $conversa->user1;

    return response()->json([
        'conversa_id' => $conversa->id,
        'outro_user' => [
            'id' => $outroUser->id,
            'name' => $outroUser->name,
            'foto' => $outroUser->foto ? asset('storage/' . $outroUser->foto) : asset('images/default-avatar.png'),
        ]
    ]);
}


    // Busca mensagens (incremental)
public function fetch($conversaId)
{
    $lastId = request('last_id', 0);

    // Marca como lidas as mensagens que não são do usuário logado
    Mensagem::where('conversa_id', $conversaId)
        ->where('user_id', '!=', auth()->id()) // mensagens do outro user
        ->where('lida', false)
        ->update(['lida' => true]);

    // Busca mensagens normalmente
    $mensagensQuery = Mensagem::where('conversa_id', $conversaId)
        ->with('user')
        ->orderBy('id');

    if ($lastId > 0) {
        $mensagensQuery->where('id', '>', $lastId);
    }

    $mensagens = $mensagensQuery->get();

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

     $mensagem = Mensagem::create([
    'conversa_id' => $request->conversa_id,
    'user_id' => auth()->id(),
    'conteudo' => $request->conteudo,
    'lida' => false,
]);

    $html = view('partials.mensagem', ['msg' => $mensagem])->render();
    return response($html);
}



}
