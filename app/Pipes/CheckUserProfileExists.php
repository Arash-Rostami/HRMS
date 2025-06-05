<?php

namespace App\Pipes;

use App\Models\Profile;
use Closure;

class CheckUserProfileExists
{
    public function handle($phone, Closure $next) {
        $profile = Profile::where('cellphone', $phone)->first();

        if (!$profile || !$profile->user) {
            return redirect()->back()->withErrors(['phone' => 'User not found with this phone number!']);
        }

        return $next($profile->user);
    }
}
