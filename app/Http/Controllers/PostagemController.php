<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use Illuminate\Http\Request;

class PostagemController extends Controller
{
    public function create()
    {
        return view('postagem');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'tipo_cadastro' => 'required|string',
        'tipo_animal' => 'required|string',
        'tem_nome' => 'required|string',
        'nome_pet' => 'required_if:tem_nome,sim|string|nullable',
        'raca' => 'required|string',
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

    Postagem::create($data);

    return redirect()->route('index')->with('success', 'Pet cadastrado com sucesso!');
}
}
