<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Dotme extends Model
{
     use HasFactory;

     protected $table = 'cadastro';

     protected $fillable = [
        "nome",
        "data_nasc",
        "cpf",
        "telefone",
        "email",
        "password"    
     ];

         public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
     
}
