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

    // Verifica se o usuário já tem um depoimento
    $existing = Depoimento::where('user_id', Auth::id())->first();
    if ($existing) {
        return redirect()->back()->with('error', 'Você já enviou um depoimento. Exclua o atual para enviar outro.');
    }

    Depoimento::create([
        'user_id' => Auth::id(),
        'titulo' => $request->titulo,
        'depoimento' => $request->depoimento,
    ]);

    return redirect()->back()->with('success_depoi', 'Depoimento enviado com sucesso!');
}


    public function destroy($id)
{
    $depoimento = Depoimento::findOrFail($id);

    // Garantir que só o dono possa apagar
    if ($depoimento->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Você não tem permissão para apagar este depoimento.');
    }

    $depoimento->delete();

    return redirect()->back()->with('success_exdepoi', 'Depoimento excluído!');
}
}