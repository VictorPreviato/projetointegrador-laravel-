<?php

namespace App\Http\Controllers;

use App\Models\Depoimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepoimentoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'depoimento' => 'required|string|max:500',
        ]);

        Depoimento::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'depoimento' => $request->depoimento,
        ]);

        return redirect()->back()->with('success', 'Depoimento enviado com sucesso!');
    }
}