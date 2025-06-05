<?php

namespace App\Pipes;

use Closure;

class LoginUser
{
    public function handle($user, Closure $next) {
        auth()->loginUsingId($user->id);
        return $next($user);
    }
}
