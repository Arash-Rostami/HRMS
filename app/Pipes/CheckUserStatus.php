<?php

namespace App\Pipes;

use Closure;

class CheckUserStatus
{
    public function handle($user, Closure $next) {
        if ($user->status === 'inactive') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'status' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }
        return $next($user);
    }
}
