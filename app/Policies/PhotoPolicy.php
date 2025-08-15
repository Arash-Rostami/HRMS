<?php
namespace App\Policies;

use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    public function __construct()
    { }

    public function viewAny()
    {
        return AccessLevel::hasPermission('view', 'Photo');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view', 'Photo');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Photo');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create', 'Photo');
    }

    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Photo');
    }
}
