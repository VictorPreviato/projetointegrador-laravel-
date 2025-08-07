<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('postagem', function (Blueprint $table) {
        $table->id();
        $table->string('tipo_cadastro');
        $table->string('tipo_animal');
        $table->string('outro_animal')->nullable();
        $table->string('tem_nome');
        $table->string('nome_pet')->nullable();
        $table->string('raca')->nullable();
        $table->string('genero');
        $table->string('idade')->nullable();
        $table->string('contato');
        $table->string('ultima_localizacao')->nullable();
        $table->text('informacoes')->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::dropIfExists('postagem');
    }
};
