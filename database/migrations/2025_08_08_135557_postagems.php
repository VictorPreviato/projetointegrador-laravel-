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
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('tipo_cadastro');
        $table->string('tipo_animal');
        $table->string('outro_animal')->nullable();
        $table->string('tem_nome');
        $table->string('nome_pet')->nullable();
        $table->string('raca')->nullable();
        $table->string('porte');
        $table->string('genero');
        $table->string('idade')->nullable();
        $table->string('contato');
        $table->string('ultima_localizacao')->nullable();
        $table->string('cep', 9)->nullable()->after('ultima_localizacao');
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
    

         Schema::table('postagem', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
        $table->dropColumn('cep');
    });

    }

     public function user()
{
    return $this->belongsTo(User::class);
}
};