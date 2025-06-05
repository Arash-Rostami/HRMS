<?php

namespace App\Policies;

use App\Models\Park;
use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ParkPolicy
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
     * @param Park $park
     * @return Response|bool
     */
    public function store(User $user, Park $park)
    {
        if (!isUserActive($user)) {
            return Response::deny("User account is deactivated.");
        }

        if (!canReserveSpot($user)) {
            return Response::deny("User is not allowed to reserve a parking spot.");
        }

        if (hasCancelledMore($user)) {
            return Response::deny("You have exceeded the allowed cancellations in the past 30 days. Please try again later.");
        }

        if (isMaxedOut($user, $park)) {
            return Response::deny("User has reached the maximum reservations for this month.");
        }

        if ($park->isReservedByUser($user) > 0) {
            return Response::deny("User already has a reservation within this time frame.");
        }

        if ($park->isReservedByOthers($user) > 0) {
            return Response::deny("Another reservation exists for this spot and time frame.");
        }

        return true;
    }

    public function viewAny()
    {
        return AccessLevel::hasPermission('view','Park');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view','Park');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit','Park');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create','Park');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete','Park');
    }
}
