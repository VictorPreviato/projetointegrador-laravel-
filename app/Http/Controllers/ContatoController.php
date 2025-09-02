<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    /**
     * Exibe o formulário de contato.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('contato'); // resources/views/contato.blade.php
    }

    /**
     * Processa os dados do formulário de contato.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'nome' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
            'email' => 'required|email|max:255',
            'mensagem' => ['required', 'string', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        ]);

        // 2. Envia o e-mail
        Mail::send('emails.contato', [
            'nome' => $request->nome,
            'email' => $request->email,
            'mensagem' => $request->mensagem,
        ], function($message) use ($request) {
            $message->to(config('mail.from.address')) // seu email configurado no .env
                    ->replyTo($request->email)
                    ->subject('Novo Contato do Site');
        });

        // 3. Redireciona com sucesso
        return redirect()->route('contato')->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Mensagens de validação customizadas
     */
    public function messages(): array
    {
        return [
            'nome.regex' => 'Formato de nome inválido.',
            'mensagem.regex' => 'Formato de mensagem inválido.',
        ];
    }
}
