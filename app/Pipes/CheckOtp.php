<?php

namespace App\Pipes;

use Closure;

class CheckOtp
{
    public function handle($user, Closure $next) {
        $codes = request()->input('code');
        $sessionOtp = session('otp');

        session()->forget('otp');

        if (implode('', $codes) != $sessionOtp) {
            return redirect()->back()->withErrors(['code' => 'Invalid OTP. Please try again!']);
        }
        return $next($user);
    }
}
