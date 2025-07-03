<?php

namespace App\Policies;

use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\App;
use App\Models\User;

class AppPolicy
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
        return AccessLevel::hasPermission('view', 'App');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'App');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'App');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'App');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'App');
    }
}
