<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Postagem extends Model
{
    protected $table = 'postagem';

       protected $fillable = [
        'user_id',
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
        'cep',
        'cidade',     // novo campo
        'estado',     // novo campo
        'informacoes',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
