<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('postagem', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('tipo_cadastro');
    $table->string('tipo_animal');
    $table->string('outro_animal')->nullable();
    $table->string('tem_nome');
    $table->string('nome_pet')->nullable();
    $table->string('raca')->nullable();
    $table->string('porte');
    $table->string('genero');
    $table->string('idade')->nullable();
    $table->string('ultima_localizacao')->nullable();
    $table->string('cep')->nullable();
    $table->string('estado')->nullable();
    $table->string('cidade')->nullable();
    $table->string('bairro')->nullable();
    $table->string('informacoes')->nullable();
    $table->string('foto')->nullable();
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postagem');
    }
};
