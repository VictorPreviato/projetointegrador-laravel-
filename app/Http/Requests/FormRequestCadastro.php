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
                'name' => ['required', 'string', 'max:255', 'regex:/^(?!.*(<script|<\/script|<\?|<\s*\/?\s*php)).*$/i'],
                'telefone' => ['required', 'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'],
                'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', 'unique:users,cpf'],
                'email' => ['required', 'email', 'confirmed', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:users,email'],
                'password' => [
                    'required',
                    'max:100',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,100}$/'
                ],

            ];
        }

        return $request;
    }

    public function messages(): array
{
    return [
        'name' => 'O formato do campo de nome não é válido.',
        'cpf.unique' => 'Este CPF já foi cadastrado.',
        'email.unique' => 'Este e-mail já foi cadastrado.',
        'email.confirmed' => 'O campo de confirmação do e-mail não corresponde.',
        'password.confirmed' => 'O campo de confirmação da senha não corresponde.',
        'password.regex' => 'A senha não segue o padrão de segurança.',
       
    ];
}
}
