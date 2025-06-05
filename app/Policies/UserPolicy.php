<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return AccessLevel::hasPermission('view', 'User');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'User');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'User');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'User');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'User');
    }
}
