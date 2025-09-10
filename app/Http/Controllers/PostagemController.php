<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class PostagemController extends Controller
{
    /**
     * Exibir formulário de criação.
     */
    public function create()
    {
        return view('postagem');
    }

    /**
     * Salvar nova postagem no banco.
     */
    public function store(Request $request)
    {

        
         $user = Auth::user();

          // Verifica quantas postagens o usuário já tem
    if ($user->postagens()->count() >= 5) {
    return redirect()->back()->with('error', 'Você já atingiu o limite de 5 postagens.');
}
        // dd($request->all());   
        // Validação dos campos
        $validated = $request->validate([
            'tipo_cadastro' => 'required|string|max:255',
            'tipo_animal' => 'required|string|max:255',
            'outro_animal' => 'nullable|string|max:255',
            'tem_nome' => 'required|string|max:255',
            'nome_pet' => 'nullable|string|max:255',
            'raca' => 'nullable|string|max:255',
            'porte' => 'required|string|max:255',
            'genero' => 'required|string|max:255',
            'idade' => 'required|string|max:255',
            'ultima_localizacao' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:9|regex:/^\d{5}-\d{3}$/',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'informacoes' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' 
        ]);
        

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        
        $validated['user_id'] = Auth::id();

    
        Postagem::create($validated);

           if (strtolower($validated['tipo_cadastro']) === 'doacao') {
        return redirect()->route('adote')->with('success_doacao', 'Postagem de adoção criada com sucesso!');
    } elseif (strtolower($validated['tipo_cadastro']) === 'perdido') {
        return redirect()->route('desaparecidos')->with('success_perdido', 'Postagem de desaparecido criada com sucesso!');
    } else {
        // Caso não se encaixe em nenhum, volta pra home ou rota padrão
        return redirect()->route('index')->with('success', 'Postagem criada com sucesso!');
    }
    }

    // Exibir formulário de edição
public function edit($id)
{
    $postagem = Postagem::findOrFail($id);

    // Verifica se pertence ao usuário logado
    if ($postagem->user_id !== Auth::id()) {
        return redirect()->route('perfil')->with('error', 'Você não tem permissão para editar esta postagem.');
    }

    return view('postagem-edit', compact('postagem'));
}

// Atualizar postagem no banco
public function update(Request $request, $id)
{
    $postagem = Postagem::findOrFail($id);

    if ($postagem->user_id !== Auth::id()) {
        return redirect()->route('perfil')->with('error', 'Você não tem permissão para editar esta postagem.');
    }

    $validated = $request->validate([
    'tipo_cadastro' => 'required|string|max:255',
    'tipo_animal'   => 'required|string|max:255',
    'nome_pet'      => 'nullable|string|max:255',
    'raca'          => 'nullable|string|max:255',
    'porte'         => 'required|string|max:255',
    'genero'        => 'required|string|max:255',
    'idade'         => 'required|string|max:255',
    'informacoes'   => 'nullable|string',
    'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
]);

    // Atualizar foto (se o usuário enviar outra)
    if ($request->hasFile('foto')) {
        if ($postagem->foto && Storage::disk('public')->exists($postagem->foto)) {
            Storage::disk('public')->delete($postagem->foto);
        }
        $validated['foto'] = $request->file('foto')->store('fotos', 'public');
    }

    $postagem->update($validated);

    return redirect()->route('perfil')->with('success', 'Postagem atualizada com sucesso!');
}



     public function desaparecidos(Request $request)
{
    $query = Postagem::with('user')
        ->where('tipo_cadastro', 'perdido'); // deve bater com o value do select do formulário

    // Filtros opcionais
    if ($request->filled('especie')) {
        $query->where('tipo_animal', $request->especie);
    }
    if ($request->filled('sexo')) {
        $query->where('genero', $request->sexo);
    }
    if ($request->filled('idade')) {
        $query->where('idade', $request->idade);
    }
    if ($request->filled('porte')) {
        $query->where('porte', $request->porte);
    }
    if ($request->filled('cep')) {
        $query->where('cep', $request->cep);
    }
    if ($request->filled('cidade')) {
        $query->where('cidade', $request->cidade);
    }
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }
    if ($request->filled('bairro')) {
        $query->where('bairro', $request->bairro);
    }

    $postagens = $query->latest()->get();

    return view('desaparecidos', compact('postagens'));
}

public function adocao(Request $request)
{
    $query = Postagem::with('user')
        ->where('tipo_cadastro', 'doacao'); // Filtra só doações

    // Filtros opcionais
    if ($request->filled('especie')) {
        $query->where('tipo_animal', $request->especie);
    }
    if ($request->filled('sexo')) {
        $query->where('genero', $request->sexo);
    }
    if ($request->filled('idade')) {
        $query->where('idade', $request->idade);
    }
    if ($request->filled('porte')) {
        $query->where('porte', $request->porte);
    }
    if ($request->filled('cep')) {
        $query->where('cep', $request->cep);
    }
    if ($request->filled('cidade')) {
        $query->where('cidade', $request->cidade);
    }
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    if ($request->filled('bairro')) {
        $query->where('bairro', $request->bairro);
    }

    $postagens = $query->latest()->get();

    return view('adote', compact('postagens'));
}


    /**
     * Deletar postagem.
     */
    public function destroy($id)
    {
        $postagem = Postagem::findOrFail($id);

        // Verifica se a postagem pertence ao usuário
        if ($postagem->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Você não tem permissão para excluir esta postagem.');
        }

        $postagem->delete();

        return redirect()->route('perfil')->with('success_delpost', 'Postagem excluída com sucesso!');
    }

    public function show($id)
{
    $post = Postagem::with('user')->findOrFail($id);

    return view('descricao', compact('post'));
}
}
