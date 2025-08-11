<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DotmeController extends Controller
{
    // Cadastro de novo usuário
    public function create(FormRequestCadastro $request)
    {
        if ($request->method() == "POST") {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            // Upload de foto se existir
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $data['foto'] = $request->file('foto')->store('fotos', 'public');
            }

            User::create($data);

            return redirect()->route('log')->with('success', 'Usuário cadastrado com sucesso!');
        }
    }

    // Login de usuário
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            Session::put('user', $user);
            Session::put('user_id', $user->id);

            return redirect()->route('index')->with('success', 'Login realizado com sucesso!');
        } else {
            // Verifica se o email existe
            $userExists = User::where('email', $request->email)->exists();

            if (!$userExists) {
                return redirect()->back()->withErrors(['email' => 'E-mail não cadastrado.']);
            } else {
                return redirect()->back()->withErrors(['password' => 'A senha está incorreta.']);
            }
        }
    }

    // Logout
    public function logout()
    {
        Session::forget(['user', 'user_id']);
        Auth::logout();
        return redirect()->route('log')->with('success', 'Você saiu da sua conta.');
    }

    // Exibir página de configuração de perfil
    public function editarPerfil()
    {
        $user = User::find(Session::get('user_id'));
        return view('config-perfil', compact('user'));
    }

    // Atualizar foto de perfil
    public function salvarFoto(Request $request)
    {
        $user = User::find(Session::get('user_id'));

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            // Apaga a foto antiga se existir
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->foto = $request->file('foto')->store('fotos', 'public');
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
    }

    // Remover foto de perfil
    public function removerFoto()
    {
        $user = User::find(Session::get('user_id'));

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil removida com sucesso!');
    }
}
