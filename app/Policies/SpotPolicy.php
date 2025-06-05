<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpotPolicy
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
        return AccessLevel::hasPermission('view', 'Spot');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Spot');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Spot');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Spot');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Spot');
    }
}
