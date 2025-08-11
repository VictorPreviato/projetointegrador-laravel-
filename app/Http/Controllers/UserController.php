<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
  public function editarPerfil()
{
    $user = User::find(Session::get('user_id')); // ou auth()->user()
    
    if (!$user) {
        // Caso o usuário não exista, redireciona para login (opcional)
        return redirect()->route('login')->with('error', 'Usuário não encontrado.');
    }

    return view('config-perfil', compact('user'));
}

    public function atualizarPerfil(Request $request)
    {
        $user = User::find(Session::get('user_id'));

        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Atualiza campos
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Atualiza foto se enviada
        if ($request->hasFile('foto')) {
            // Apaga a foto antiga, se existir
            if ($user->foto && Storage::exists('public/fotos/' . $user->foto)) {
                Storage::delete('public/fotos/' . $user->foto);
            }

            $nomeArquivo = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/fotos', $nomeArquivo);
            $user->foto = $nomeArquivo;
        }

        $user->save();

        return redirect()->route('config.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
}
