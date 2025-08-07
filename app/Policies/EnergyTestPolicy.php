<?php
namespace App\Policies;
use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
class EnergyTestPolicy
{
    use HandlesAuthorization;
    public function __construct()
    {
        //
    }
    public function viewAny()
    {
        return AccessLevel::hasPermission('view', 'EnergyTest');
    }
    public function view()
    {
        return AccessLevel::hasPermission('view', 'EnergyTest');
    }
    public function update()
    {
        return AccessLevel::hasPermission('edit', 'EnergyTest');
    }
    public function create()
    {
        return AccessLevel::hasPermission('create', 'EnergyTest');
    }
    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'EnergyTest');
    }
}
