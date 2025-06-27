<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestCadastro extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{
        $request = [];

        if($this->method() == 'POST'){
            $request = [
                'nome' => 'required|string|max:255',
                'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
                'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/'],
                'email' => ['required', 'email', 'regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
                'password' => 'required|max:100',
            ];
        }

        return $request;
    }
}
