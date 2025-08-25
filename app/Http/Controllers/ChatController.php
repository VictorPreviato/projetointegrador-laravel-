<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
     public function send(Request $request)
{

    
    try {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => $message
        ]);
    } catch (\Exception $e) {
        \Log::error("Erro ao enviar mensagem: ".$e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
        
    }
}

}
