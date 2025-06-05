<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeatPolicy
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
        return AccessLevel::hasPermission('view', 'Seat');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Seat');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Seat');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Seat');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Seat');
    }
}
