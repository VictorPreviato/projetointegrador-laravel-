<?php

use App\Http\Controllers\DotmeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Session;
use App\Models\Dotme;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/config-perfil', function () {
        $user = Auth::user();
        return view('config-perfil', compact('user'));
    })->name('config-perfil');

    Route::put('/usuario/update', [DotmeController::class, 'update'])->name('usuario.update');
    
    Route::post('/perfil/foto', [DotmeController::class, 'salvarFoto'])->name('perfil.foto');

    Route::get('/perfil', function () {
        return view('perfil', ['user' => Auth::user()]);
    })->name('perfil');

    Route::get('/logout', [DotmeController::class, 'logout'])->name('logout');
});

// Header
Route::get('/cadastro', function () {
    return view('cadastro');
});
Route::get('/log', function () {
    return view('log');
})->name('log');
Route::get('/adote', function () {
    return view('adote');
});
Route::get('/desaparecidos', function () {
    return view('desaparecidos');
});

// Footer
Route::get('/sobre', function () {
    return view('sobre');
});
Route::get('/contato', function () {
    return view('contato');
});
Route::get('/apoie', function () {
    return view('apoie');
});
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/redes', function () {
    return view('redes');
});

 Route::post('dotmelogin', [DotmeController::class,
 'login'])->name('dotmelogin.post');

Route::post('cadastro', [DotmeController::class,
'create'])->name('cadastro.post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
