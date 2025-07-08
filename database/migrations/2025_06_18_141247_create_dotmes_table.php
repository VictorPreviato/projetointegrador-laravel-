<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cadastro', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nasc');
            $table->string('cpf')->unique();
            $table->string('telefone');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

        public function down(): void
    {
        Schema::dropIfExists('cadastro');
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('dotme');
    // }
};
