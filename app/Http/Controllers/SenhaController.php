<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SenhaController extends Controller
{
    public function verificaEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if ($user) {
            return redirect()->route('form-pergunta-secreta', ['email' => $request->email]);
        }

        return back()->withErrors(['email' => 'E-mail não cadastrado.']);
    }




    public function formEmail()
{
    return view('alterarsenha-email');
}



    
    public function formPerguntaSecreta($email)
{
    $user = DB::table('users')->where('email', $email)->first();

    if (!$user || !$user->pergunta) {
        return redirect()->route('form-esqueci-senha')->withErrors(['email' => 'Usuário não possui pergunta secreta cadastrada.']);
    }

      // Adiciona a lógica para pegar o texto da pergunta
    $perguntas = [
        '1' => 'Qual o nome do seu herói favorito?',
        '2' => 'Qual o nome do seu primeiro animal de estimação?',
        '3' => 'Qual o nome da sua mãe?',
        '4' => 'Qual o nome da sua escola primária?',
    ];

     $perguntaTexto = $perguntas[$user->pergunta] ?? 'Pergunta desconhecida';

   
   return view('resposta-secreta', [
    'user' => $user,
    'pergunta' => $perguntaTexto, 
]);



}

public function verificaRespostaSecreta(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'resposta_secreta' => 'required|string',
    ]);

    $user = DB::table('users')->where('email', $request->email)->first();

    if (!$user) {
        return redirect()->route('form-esqueci-senha')->withErrors(['email' => 'Usuário não encontrado.']);
    }

    // Compara resposta md5
    if (md5($request->resposta_secreta) === $user->resposta_secreta) {
        return redirect()->route('form-nova-senha', ['email' => $user->email]);
    }

    return back()->withErrors(['resposta_secreta' => 'Resposta secreta incorreta.']);
}

    public function formNovaSenha($email)
    {
        return view('alterar-senha', compact('email'));
    }

    public function alterar(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'nova_senha' => 'required|min:3|confirmed',
        ]);

        DB::table('users')
    ->where('email', $request->email)
    ->update([
        'password' => Hash::make($request->nova_senha),
    ]);


        return redirect('/log')->with('sucesso', 'Senha alterada com sucesso!');
    }
}