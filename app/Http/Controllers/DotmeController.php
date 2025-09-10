<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Depoimento;


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
        return redirect()->route('index');
    }


    // Remover foto de perfil
    public function removerFoto()
    {
        
        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
            /** @var User|null $user */
            $user->save();
           
        }

        return redirect()->back()->with('success', 'Foto de perfil removida com sucesso!');
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
    'password' => [
        'nullable',
        'confirmed',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,100}$/'
    ],
    'current_password' => $request->filled('password') ? 'required' : 'nullable',
    'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
], [
    'password.confirmed' => 'O campo de confirmação da senha não corresponde.',
    'password.regex' => 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos: 1 letra maiúscula, 1 letra minúscula, 1 número e 1 caractere especial.',
    'current_password.required' => 'Você deve informar sua senha atual para alterá-la.',
]);


     if ($request->filled('password')) {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual informada está incorreta.']);
        }
        $user->password = Hash::make($request->password);
    }


        // Atualiza campos
        $user->name = $request->name;
        $user->telefone= $request->telefone;
        $user->data_nasc = $request->data_nasc;
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
         /** @var User|null $user */
        $user->save();
        return redirect()->route('config-perfil')->with('success_config', 'Perfil atualizado com sucesso!');
    }    

    public function salvarFoto(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $request->validate([
        'foto' => 'required|image|max:20480' // 20 MB
    ]);

    // Apaga foto antiga, se existir
    if ($user->foto && Storage::disk('public')->exists($user->foto)) {
        Storage::disk('public')->delete($user->foto);
    }

    // Salva nova foto e armazena caminho completo
    $user->foto = $request->file('foto')->store('fotos', 'public');
    /** @var User|null $user */ 
    $user->save();
  
    return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
}

public function perfil()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    $posts = $user->postagens()->latest()->get();

    $depoimentos = Depoimento::where('user_id', $user->id)
        ->latest()
        ->get();

    return view('perfil', [
        'user' => $user,
        'posts' => $posts,
        'depoimentos' => $depoimentos
    ]);
}

public function excluirConta()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não autenticado.');
    }

    // Apagar foto de perfil, se existir
    if ($user->foto && Storage::disk('public')->exists($user->foto)) {
        Storage::disk('public')->delete($user->foto);
    }

    // Apagar posts do usuário (se tiver relacionamento)
    if (method_exists($user, 'postagens')) {
        $user->postagens()->delete();
    }

    // Apagar depoimentos relacionados
    if (method_exists($user, 'depoimentos')) {
        $user->depoimentos()->delete();
    }

    // Logout do usuário antes de excluir
    Auth::logout();
    Session::forget(['user', 'user_id']);

    // Excluir usuário do banco
    $user->delete();

    return redirect()->route('index')->with('success', 'Sua conta foi excluída com sucesso.');
}


}