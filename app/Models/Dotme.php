<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Dotme extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'cadastro';

    protected $fillable = [
        "nome",
        "data_nasc",
        "cpf",
        "telefone",
        "email",
        "password"
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

}
