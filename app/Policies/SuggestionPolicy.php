<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuggestionPolicy
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
        return AccessLevel::hasPermission('view', 'Suggestion');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Suggestion');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Suggestion');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Suggestion');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Suggestion');
    }
}
