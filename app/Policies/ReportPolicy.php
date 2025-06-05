<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
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
        return AccessLevel::hasPermission('view', 'Report');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Report');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Report');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Report');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Report');
    }
}
