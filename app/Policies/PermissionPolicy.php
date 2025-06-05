<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny()
    {
        return $this->hasPermission();
    }

    public function view()
    {
        return $this->hasPermission();
    }

    public function update()
    {
        return $this->hasPermission();
    }

    public function create()
    {
        return $this->hasPermission();
    }

    public function delete()
    {
        return $this->hasPermission();
    }

    private function hasPermission()
    {
        return (auth()->user()->role == 'developer');
    }
}
