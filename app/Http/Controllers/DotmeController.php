<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DotmeController extends Controller
{
    // Criação de novo usuário
   public function create(FormRequestCadastro $request){
    if($request->method() == "POST"){
        $data = $request->all();

    
        // Certifique-se que cpf está no array
        if (!isset($data['cpf'])) {
            // tratar o erro, ou setar algum valor padrão (não recomendado)
            return back()->withErrors(['cpf' => 'O CPF é obrigatório.']);
        }

        $data['password'] = bcrypt($data['password']);
        
        User::create($data);

        return redirect()->route('log');
    }

    return view('log');
}

    // Login e logout do usuário
     public function login(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');

     $remember = $request->filled('remember');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('index'));
    }

    return back()->with('error', 'E-mail ou senha incorretos.');
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
    $user = Auth::user();

    if ($request->hasFile('foto')) {
        $arquivo = $request->file('foto');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();

        $salvou = $arquivo->storeAs('fotos', $nomeArquivo, 'public');

        if ($salvou) {
            $user->foto = $nomeArquivo;
            $user->save();
        }
    }

    return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso.');
}


// Método para atualizar dados do usuário na tela config-perfil
public function update(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
        'email' => ['required', 'email', 'confirmed', 'unique:users,email,' . $user->id],
        'data_nasc' => ['required', 'date'],
    ]);

    $user->update([
        'name' => $request->name,
        'telefone' => $request->telefone,
        'email' => $request->email,
        'data_nasc' => $request->data_nasc,
    ]);

    return redirect()->route('config-perfil')->with('success', 'Perfil atualizado com sucesso!');
}



}
