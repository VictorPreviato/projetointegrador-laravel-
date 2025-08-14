<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use Illuminate\Support\Facades\Auth;

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
        //  dd($request->all());   
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
            'idade' => 'nullable|string|max:255',
            'contato' => 'required|string|max:255',
            'ultima_localizacao' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:9',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'informacoes' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Upload da foto (se houver)
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        // Associar usuário logado
        $validated['user_id'] = Auth::id();

        // Criar a postagem
        Postagem::create($validated);

           if (strtolower($validated['tipo_cadastro']) === 'doacao') {
        return redirect()->route('adote')->with('success', 'Postagem de adoção criada com sucesso!');
    } elseif (strtolower($validated['tipo_cadastro']) === 'perdido') {
        return redirect()->route('desaparecidos')->with('success', 'Postagem de desaparecido criada com sucesso!');
    } else {
        // Caso não se encaixe em nenhum, volta pra home ou rota padrão
        return redirect()->route('index')->with('success', 'Postagem criada com sucesso!');
    }
    }

    /**
     * Exibir uma postagem.
     */
    public function show($id)
    {
        $postagem = Postagem::with('user')->findOrFail($id);
        return view('postagens.show', compact('postagem'));
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

        return redirect()->route('home')->with('success', 'Postagem excluída com sucesso!');
    }
}
