<?php

namespace App\Pipes;

use Closure;

class GenerateOtp
{
    public function handle($user, Closure $next) {
        $otp = rand(1000, 9999);
        session(['otp' => $otp, 'user_id' => $user->id]);
        return $next($user);
    }
}
