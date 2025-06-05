<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstantMessagePolicy
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
        return AccessLevel::hasPermission('view', 'InstantMessage');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'InstantMessage');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'InstantMessage');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'InstantMessage');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'InstantMessage');
    }
}
