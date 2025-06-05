<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
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
        return AccessLevel::hasPermission('view', 'Profile');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Profile');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Profile');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Profile');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Profile');
    }
}
