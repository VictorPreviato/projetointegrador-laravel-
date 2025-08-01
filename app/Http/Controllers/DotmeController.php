<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Models\Dotme;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DotmeController extends Controller
{
    public function create(FormRequestCadastro $request){
        if($request->method() == "POST"){
            $data = $request->all();
            Dotme::create($data);

            return redirect('log');
        }

        return view('log');
    }

     public function login(LoginRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
 
            $user = Dotme::where('email', $data['email'])->first();
 
            if ($user === null) {
                return redirect()->back()->with('error', 'Usuário não encontrado');
            }
 
           //aqui chamar a autenticação pra validar a senha
           return view('index');
        }  
    }
}
