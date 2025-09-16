<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Depoimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\FormRequestCadastro;

class DotmeController extends Controller
{
    // Cadastro de novo usuário
    public function create(FormRequestCadastro $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            // Criptografa resposta secreta se houver
            $data['resposta_secreta'] = !empty($data['resposta_secreta'])
                ? md5($data['resposta_secreta'])
                : null;

            $data['pergunta'] = $data['pergunta'] ?? null;

            // Upload da foto
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

        // Se veio com redirect_to, ignora o intended
        $redirect = $request->input('redirect_to');
        if ($redirect && Str::startsWith($redirect, url('/'))) {
    // Se o formulário mandou redirect_to, sempre prioriza isso
    $request->session()->forget('url.intended'); 
    return redirect()->to($redirect);
}

// Se não veio redirect_to, tenta o intended → index
return redirect()->intended(route('index'));

    }

    $userExists = User::where('email', $request->email)->exists();
    if (!$userExists) {
        return redirect()->back()->withErrors(['email' => 'E-mail não cadastrado.']);
    } else {
        return redirect()->back()->withErrors(['password' => 'A senha está incorreta.']);
    }
}


    // Logout
    public function logout(Request $request)
    {
        Session::forget(['user', 'user_id']);
        Auth::logout();

        // invalida a sessão e limpa intended
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended');

        return redirect()->route('index');
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

    // Editar perfil (formulário)
    public function editarPerfil()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('log')->with('error', 'Usuário não encontrado.');
        }

        return view('config-perfil', compact('user'));
    }

    // Atualizar perfil
    public function atualizarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,100}$/'
            ],
            'current_password' => $request->filled('password') ? 'required' : 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.regex'     => 'A senha deve ter no mínimo 8 caracteres, incluindo maiúscula, minúscula, número e caractere especial.',
            'current_password.required' => 'Você deve informar sua senha atual para alterá-la.',
        ]);

        // Atualizar senha
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'A senha atual informada está incorreta.']);
            }
            $user->password = Hash::make($request->password);
        }

        // Atualizar campos
        $user->name = $request->name;
        $user->telefone = $request->telefone;
        $user->data_nasc = $request->data_nasc;
        $user->email = $request->email;

        // Atualizar foto
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists('public/fotos/' . $user->foto)) {
                Storage::delete('public/fotos/' . $user->foto);
            }
            $nomeArquivo = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/fotos', $nomeArquivo);
            $user->foto = $nomeArquivo;
        }

        $user->save();
        return redirect()->route('config-perfil')->with('success_config', 'Perfil atualizado com sucesso!');
    }

    // Salvar foto (separado)
    public function salvarFoto(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('log')->with('error', 'Usuário não autenticado.');
        }

        $request->validate([
            'foto' => 'required|image|max:20480'
        ]);

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->foto = $request->file('foto')->store('fotos', 'public');
        $user->save();

        return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
    }

    // Perfil público
    public function perfil()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('log')->with('error', 'Usuário não autenticado.');
        }

        $posts = $user->postagens()->latest()->get();
        $depoimentos = Depoimento::where('user_id', $user->id)->latest()->get();

        return view('perfil', compact('user', 'posts', 'depoimentos'));
    }

    // Excluir conta
    public function excluirConta()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('log')->with('error', 'Usuário não autenticado.');
        }

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        if (method_exists($user, 'postagens')) {
            $user->postagens()->delete();
        }

        if (method_exists($user, 'depoimentos')) {
            $user->depoimentos()->delete();
        }

        Auth::logout();
        Session::forget(['user', 'user_id']);
        $user->delete();

        return redirect()->route('index')->with('succes_deluser', 'Sua conta foi excluída com sucesso.');
    }
}
