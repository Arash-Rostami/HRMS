<?php

namespace App\Pipes;

use App\Events\UpdateLastSeen;
use App\Events\UserLoggedIn;

class DispatchUserEvents
{
    public function handle($user) {
        event(new UpdateLastSeen($user));
        event(new UserLoggedIn($user));
    }
}
