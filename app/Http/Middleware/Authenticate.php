<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        $path = $request->path();

        // Impede que rotas AJAX do chat virem intended
        if (!preg_match('#^chat($|/)#', $path)) {
    session(['url.intended' => url()->current()]);
}


        return route('log'); // sua rota de login
    }
}

}