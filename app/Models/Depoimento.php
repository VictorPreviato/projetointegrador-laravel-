<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depoimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'depoimento',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}