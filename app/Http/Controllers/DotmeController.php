<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\Dotme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;

class DotmeController extends Controller
{
    // Criação de novo usuário
    public function create(FormRequestCadastro $request){
        if($request->method() == "POST"){
            $data = $request->all();
            Dotme::create($data);

            return redirect('log');
        }

        return view('log');
    }

    // Login e logout do usuário
     public function login(LoginRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
 
            $user = Dotme::where('email', $data['email'])->first();
 
            if ($user === null) {
                return redirect()->back()->with('error', 'Usuário não encontrado');
            }
 
            if (!password_verify($data['password'], $user->password)) {
                return redirect()->back()->with('error', 'Senha incorreta');
            }
        // Armazena o usuário na sessão
        Session::put('user', $user);

        return redirect()->route('index'); // Redireciona para a home logado
    }
}

     public function logout()
{
    Session::forget('user');
    return redirect()->route('index'); // ou rota de login
}


// Inserir e salvar fotos do usuário no banco de dados, processo feito na tela de perfil
public function salvarFoto(Request $request)
{
    $user = Session::get('user'); // ou Auth::user() se estiver usando Auth

    if ($request->hasFile('foto')) {
        $arquivo = $request->file('foto');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();

        $salvou = Storage::disk('public')->putFileAs('fotos', $arquivo, $nomeArquivo);

        if ($salvou) {
            $user->foto = $nomeArquivo;
            $user->save();

            // Atualiza a sessão para refletir a nova foto
            Session::put('user', $user);
        }
    }

    return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso.');
}


// Método para atualizar dados do usuário na tela config-perfil
public function update(Request $request)
{
    $user = Session::get('user');

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    // Validação (pode usar FormRequest também)
    $request->validate([
        'nome' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
        'email' => ['required', 'email', 'confirmed', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:cadastro,email,' . $user->id],
        'data_nasc' => ['required', 'date'],
    ]);

    // Atualiza no banco
    $user->nome = $request->nome;
    $user->telefone = $request->telefone;
    $user->email = $request->email;
    $user->data_nasc = $request->data_nasc;
    $user->save();

    // Atualiza a sessão
    Session::put('user', $user);

    return redirect()->route('config-perfil')->with('success', 'Perfil atualizado com sucesso!');
}


}
