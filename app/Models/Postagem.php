<?php

namespace App\Models;

use App\Models\User;
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
        'porte',
        'genero',
        'idade',
        'contato',
        'ultima_localizacao',
        'informacoes',
        'foto',
        'user_id',
        'cep',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}