<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

     
}
