<?php

use App\Http\Controllers\DotmeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\DepoimentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\FeedbackController;


Route::get('/', function () {
    return view('index');
})->name('index');

// Rotas privadas

Route::middleware('auth')->group(function () {
    Route::get('/config-perfil', function () {
        $user = Auth::user();
        return view('config-perfil', compact('user'));
    })->name('config-perfil');

    Route::get('/perfil', [DotmeController::class, 'perfil'])->name('perfil');

    Route::get('/logout', [DotmeController::class, 'logout'])->name('logout');

    Route::post('/depoimentos', [DepoimentoController::class, 'store'])->name('depoimentos.store');
    Route::delete('/depoimentos/{id}', [DepoimentoController::class, 'destroy'])->name('depoimentos.destroy');

    Route::put('/usuario/update', [DotmeController::class, 'atualizarPerfil'])->name('usuario.update');
    Route::post('/perfil/foto', [DotmeController::class, 'salvarFoto'])->name('perfil.foto');
    Route::post('/perfil/remover-foto', [DotmeController::class, 'removerFoto'])->name('perfil.removerFoto');

    Route::get('/postagem', [PostagemController::class, 'create'])->name('postagem.create');
    Route::post('/postagem', [PostagemController::class, 'store'])->name('postagem.store');

    Route::delete('postagem/{id}', [PostagemController::class, 'destroy'])->name('postagem.destroy');
});

// Rotas públicas
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/', [HomeController::class, 'index'])->name('index');


Route::get('/postagem/{id}', [PostagemController::class, 'show'])->name('postagem.show');

Route::get('/log', function () {
    return view('log');
})->name('log');

// Header
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');
Route::get('/log', function () {
    return view('log');
})->name('log');


Route::get('/desaparecidos', [PostagemController::class, 'desaparecidos'])->name('desaparecidos');
Route::get('/adote', [PostagemController::class, 'adocao'])->name('adote');

// Footer
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');
Route::get('/contato', function () {
    return view('contato');
})->name('contato');
Route::get('/apoie', function () {
    return view('apoie');
})->name('apoie');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/redes', function () {
    return view('redes');
})->name('redes');

 Route::post('dotmelogin', [DotmeController::class,
 'login'])->name('dotmelogin.post');

Route::post('cadastro', [DotmeController::class,
'create'])->name('cadastro.post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// alterar senha
Route::get('/esqueci-senha', function () {
    return view('alterarsenha-email');
})->name('form-esqueci-senha');

// Página para digitar o email
Route::get('/esqueci-senha', function () {
    return view('alterarsenha-email');
})->name('form-esqueci-senha');

// Verificação do email
Route::post('/esqueci-senha', [SenhaController::class, 
'verificaEmail'])->name('verifica-email');



// Página da pergunta secreta
Route::get('/pergunta-secreta/{email}', [SenhaController::class, 
'formPerguntaSecreta'])->name('form-pergunta-secreta');

// Verificação da resposta
Route::post('/verifica-resposta-secreta', [SenhaController::class,
 'verificaRespostaSecreta'])->name('verifica-resposta-secreta');

 


// Página para alterar senha (exibe formulário)
Route::get('/alterar-senha/{email}', [SenhaController::class, 
'formNovaSenha'])->name('form-nova-senha');

// Atualiza senha
Route::post('/alterar-senha', [SenhaController::class, 
'alterar'])->name('alterar-senha'); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
