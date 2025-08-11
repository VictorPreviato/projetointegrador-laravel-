<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoadUserFromSession
{
    public function handle($request, Closure $next)
    {
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
            view()->share('user', $user);
        }

        return $next($request);
    }
}
