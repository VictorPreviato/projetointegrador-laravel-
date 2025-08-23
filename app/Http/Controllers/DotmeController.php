<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class DotmeController extends Controller
{
    // Cadastro de novo usuário
    public function create(FormRequestCadastro $request)
    {
        if ($request->method() == "POST") {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);         

    // Criptografa a resposta secreta, se tiver
        if (!empty($data['resposta_secreta'])) {
            $data['resposta_secreta'] = md5($data['resposta_secreta']);
        } else {
            $data['resposta_secreta'] = null;       
         }

        // Salva a pergunta secreta
        $data['pergunta'] = $data['pergunta'] ?? null;


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

            return redirect()->route('index');
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


    // Remover foto de perfil
    public function removerFoto()
    {
        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil removida com sucesso!');
    }

    public function update(Request $request)
{
    /** @var \App\Models\Dotme|null $user */
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
        'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
        'email' => ['required', 'email', 'confirmed', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:users,email,' . $user->id],
        'data_nasc' => ['required', 'date'],
    ]);

    $user->name = $request->name;
    $user->telefone = $request->telefone;
    $user->email = $request->email;
    $user->data_nasc = $request->data_nasc;
    $user->save();

    return redirect()->route('config-perfil')->with('success', 'Perfil atualizado com sucesso!');
}

 public function editarPerfil()
{
    $user = Auth::user(); // ou auth()->user()
    
    if (!$user) {
        // Caso o usuário não exista, redireciona para login (opcional)
        return redirect()->route('login')->with('error', 'Usuário não encontrado.');
    }

    return view('config-perfil', compact('user'));
}

    public function atualizarPerfil(Request $request)
    {
        $user = Auth::user();

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
            $user->foto = $nomeArquivo; // só nome do arquivo, sem 'fotos/' na frente

        }

        $user->save();

        return redirect()->route('config-perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function salvarFoto(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Apaga foto antiga, se existir
    if ($user->foto && Storage::disk('public')->exists($user->foto)) {
        Storage::disk('public')->delete($user->foto);
    }

    // Salva nova foto e armazena caminho completo
    $user->foto = $request->file('foto')->store('fotos', 'public');
    $user->save();

    return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
}
}
