<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
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
        return AccessLevel::hasPermission('view', 'Job');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Job');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Job');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Job');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Job');
    }
}
