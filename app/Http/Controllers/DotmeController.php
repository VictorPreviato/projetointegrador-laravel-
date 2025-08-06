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
    public function create(FormRequestCadastro $request){
        if($request->method() == "POST"){
            $data = $request->all();
            Dotme::create($data);

            return redirect('log');
        }

        return view('log');
    }

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

}
