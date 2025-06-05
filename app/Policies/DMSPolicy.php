<?php

namespace App\Policies;

use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class DMSPolicy
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
        return AccessLevel::hasPermission('view', 'DMS');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'DMS');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'DMS');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'DMS');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'DMS');
    }
}
