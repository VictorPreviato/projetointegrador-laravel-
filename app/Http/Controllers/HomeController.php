<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depoimento;
use App\Models\Postagem;

class HomeController extends Controller
{
   public function index()
{
    // Depoimentos
    $depoimentos = Depoimento::with('user')
        ->latest()
        ->take(4)
        ->get();

    // Pets desaparecidos
    $desaparecidos = Postagem::with('user')
        ->where('tipo_cadastro', 'perdido')
        ->latest()
        ->take(7) // limite de cards do carrossel
        ->get();

    return view('index', compact('depoimentos', 'desaparecidos'));
}
}