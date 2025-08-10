<?php

use App\Http\Controllers\DotmeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Session;
use App\Models\Dotme;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostagemController;


Route::post('/perfil/foto', [DotmeController::class, 'salvarFoto'])->name('perfil.foto');

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/config-perfil', function () {
    if (!Session::has('user')) {
        return redirect()->route('login')
            ->with('error', 'Faça login para acessar as configurações do perfil.');
    }

    $user = Session::get('user'); 
    return view('config-perfil', compact('user'));
})->name('config-perfil');

Route::put('/usuario/update', [DotmeController::class, 'update'])->name('usuario.update');

Route::get('/perfil', function () {
    if (!Session::has('user')) {
        return redirect()->route('login')->with('error', 'Faça login para acessar o perfil.');
    }
    return view('perfil');
})->name('perfil');


// Postagem
Route::get('/postagem', [PostagemController::class, 'create'])->name('postagem.create');
Route::post('/postagem', [PostagemController::class, 'store'])->name('postagem.store');

// Header
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');
Route::get('/log', function () {
    return view('log');
})->name('log');
Route::get('/adote', function () {
    return view('adote');
})->name('adote');

Route::get('/desaparecidos', [PostagemController::class, 'desaparecidos'])->name('desaparecidos');

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

// Logoff
Route::get('/logout', [DotmeController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
