<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
        use HasFactory;

    protected $table = 'mensagens'; // 👈 força o nome certo

    protected $fillable = [
        'conversa_id',
        'user_id',
        'conteudo',
    ];

    public function conversa()
    {
        return $this->belongsTo(Conversa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

