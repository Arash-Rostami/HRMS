<?php

namespace App\Policies;

use App\Models\Desk;
use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DeskPolicy
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

    /**
     * Determine if the given desk can be reserved by the user.
     * @param User $user
     * @param Desk $desk
     * @return Response|bool
     */
    public function store(User $user, Desk $desk)
    {
        if (!isUserActive($user)) {
            return Response::deny("User account is deactivated.");
        }

        if (!canReserveSeat($user)) {
            return Response::deny("User is not allowed to reserve a desk in the office.");
        }

        if ($desk->isReservedByUser($user) >= 1) {
            return Response::deny("User already has a reservation within this time frame.");
        }

        if ($desk->isReservedByOthers($user) >= 1) {
            return Response::deny("Another reservation exists within this time frame.");
        }

        return true;
    }

    public function viewAny()
    {
        return AccessLevel::hasPermission('view', 'Desk');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Desk');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Desk');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Desk');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Desk');
    }
}
