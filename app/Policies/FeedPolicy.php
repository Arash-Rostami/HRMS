<?php

namespace App\Policies;

use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Feed');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Feed');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Feed');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Feed');
    }

    public function viewAny()
    {
        return AccessLevel::hasPermission('view', 'Feed');
    }
}
