<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\Dotme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class DotmeController extends Controller
{

    function currentUser()
{
    return Auth::user() ?? Session::get('user');
}


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
        $data = $request->only('email', 'password');

        // Tentativa de login usando Auth
        $remember = $request->has('remember'); // checkbox "lembrar de mim"

        if (Auth::guard('web')->attempt($data, $remember)) {
            // Login bem-sucedido
            $user = Auth::user();
            Session::put('user', $user); // mantém compatibilidade com sua lógica atual

            return redirect()->route('index');
        }

        // Caso não logue, tratamos como você já faz
        $user = Dotme::where('email', $data['email'])->first();

        if ($user === null) {
            return redirect()->back()->with('error', 'Usuário não encontrado');
        }

        return redirect()->back()->with('error', 'Senha incorreta');
    }
}

 public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('index');
}



// Inserir e salvar fotos do usuário no banco de dados, processo feito na tela de perfil
public function salvarFoto(Request $request)
{
    $user = Auth::user(); // ou Auth::user() se estiver usando Auth

    if ($request->hasFile('foto')) {
        $arquivo = $request->file('foto');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();

        $salvou = Storage::disk('public')->putFileAs('fotos', $arquivo, $nomeArquivo);

        if ($salvou) {
            $user->foto = $nomeArquivo;
            /** @var \App\Models\Dotme|null $user */
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
    /** @var \App\Models\Dotme|null $user */
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $request->validate([
        'nome' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
        'email' => ['required', 'email', 'confirmed', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:cadastro,email,' . $user->id],
        'data_nasc' => ['required', 'date'],
    ]);

    $user->nome = $request->nome;
    $user->telefone = $request->telefone;
    $user->email = $request->email;
    $user->data_nasc = $request->data_nasc;
    $user->save();

    // Não precisa atualizar a sessão manualmente, o Auth já faz isso

    return redirect()->route('config-perfil')->with('success', 'Perfil atualizado com sucesso!');
}


}
