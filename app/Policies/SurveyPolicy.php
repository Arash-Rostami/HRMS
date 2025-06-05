<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
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
        return AccessLevel::hasPermission('view', 'Survey');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Survey');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Survey');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Survey');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Survey');
    }
}
