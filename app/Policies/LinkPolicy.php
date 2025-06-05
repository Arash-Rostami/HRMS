<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
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
        return AccessLevel::hasPermission('view', 'Link');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Link');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Link');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Link');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Link');
    }
}
