<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostagemController extends Controller
{
    public function create()
    {
        return view('postagem');
    }

    public function store(Request $request)
{
    // Validação
    $data = $request->validate([
        'tipo_cadastro' => 'required|string',
        'tipo_animal' => 'required|string',
        'tem_nome' => 'required|string',
        'nome_pet' => 'required_if:tem_nome,sim|string|nullable',
        'raca' => 'required|string',
        'porte' => 'required|string',
        'genero' => 'required|string',
        'idade' => 'required|string',
        'contato' => 'required|string',
        'ultima_localizacao' => 'required_if:tipo_cadastro,perdido|string|nullable',
        'informacoes' => 'nullable|string',
        'foto' => 'required|image|max:2048'
    ], [
        'required' => 'O campo :attribute é obrigatório.',
        'required_if' => 'O campo :attribute é obrigatório.',
        'image' => 'A foto deve ser uma imagem.',
        'max' => 'A foto deve ter no máximo 2MB.'
    ]);

    // Upload da imagem
    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('pets', 'public');
    }

    // Adiciona o ID do usuário autenticado
    $data['user_id'] = Auth::id();

    $data['cep'] = $request->cep;

    // Cria o registro no banco
    Postagem::create($data);

    return redirect()->route('index')->with('success', 'Pet cadastrado com sucesso!');
}

    public function desaparecidos(Request $request)
    {
        $query = Postagem::with('user')
            ->where('tipo_cadastro', 'perdido');

        // Filtros
        if ($request->filled('especie')) {
            $query->where('tipo_animal', $request->especie);
        }

        if ($request->filled('sexo')) {
            $query->where('genero', $request->sexo);
        }

        if ($request->filled('idade')) {
            $idadeFiltro = $request->idade;
            $query->where(function ($q) use ($idadeFiltro) {
                if ($idadeFiltro == 'filhote') {
                    $q->where('idade', 'like', '%mes%');
                } elseif ($idadeFiltro == 'adulto') {
                    $q->where('idade', 'like', '%1 ano%')
                      ->orWhere('idade', 'like', '%2 ano%')
                      ->orWhere('idade', 'like', '%3 ano%');
                } elseif ($idadeFiltro == 'idoso') {
                    $q->where('idade', 'like', '%6 ano%')
                      ->orWhere('idade', 'like', '%7 ano%')
                      ->orWhere('idade', 'like', '%8 ano%')
                      ->orWhere('idade', 'like', '%9 ano%')
                      ->orWhere('idade', 'like', '%10 ano%');
                }
            });
        }

        if ($request->filled('porte')) {
            $query->where('porte', $request->porte);
        }

        if ($request->filled('cidade')) {
            $query->where('ultima_localizacao', 'like', '%' . $request->cidade . '%');
        }

        if ($request->filled('estado')) {
            $query->where('ultima_localizacao', 'like', '%' . $request->estado . '%');
        }

        if ($request->filled('cep')) {
    $query->where('cep', 'like', '%' . $request->cep . '%');
}

        $postagens = $query->latest()->get();;

        return view('desaparecidos', compact('postagens'));
    }
}

