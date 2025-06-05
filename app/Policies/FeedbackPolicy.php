<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
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
        return AccessLevel::hasPermission('view', 'Feedback');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Feedback');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Feedback');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Feedback');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Feedback');
    }
}
