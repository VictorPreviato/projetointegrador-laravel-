<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{
    protected $table = 'postagem';

    protected $fillable = [
        'tipo_cadastro',
        'tipo_animal',
        'outro_animal',
        'tem_nome',
        'nome_pet',
        'raca',
        'genero',
        'idade',
        'contato',
        'ultima_localizacao',
        'informacoes',
        'foto',
    ];
}