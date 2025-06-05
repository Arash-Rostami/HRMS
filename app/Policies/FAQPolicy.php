<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class FAQPolicy
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
        return AccessLevel::hasPermission('view', 'FAQ');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'FAQ');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'FAQ');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'FAQ');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'FAQ');
    }
}
