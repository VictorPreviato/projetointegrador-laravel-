<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Validação básica
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email',
            'comentario' => ['required', 'string', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        ]);

        // Envia email
        Mail::send('emails.feedback', [
            'name' => $request->name,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'comentario' => $request->comentario,
        ], function($message) use ($request) {
            $message->to(config('mail.from.address')) 
                    ->replyTo($request->email) 
                    ->subject('Novo Feedback do Site');
        });

   session()->flash('success_feed', 'Feedback enviado com sucesso!');

return back();
    }

 public function messages(): array
{
    return [
        'name' => 'Formato de nome inválido.',
        'comentario' => 'Formato de comentário inválido.',       
    ];
}
}
