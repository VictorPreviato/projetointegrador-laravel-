<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversa extends Model
{
     protected $fillable = ['user1_id', 'user2_id'];

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'conversa_id');
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}
