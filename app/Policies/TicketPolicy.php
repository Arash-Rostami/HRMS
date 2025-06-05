<?php

namespace App\Policies;

use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;


    public function viewAny()
    {
        return AccessLevel::hasPermission('view', 'Ticket');
    }


    public function view()
    {
        return AccessLevel::hasPermission('view', 'Ticket');
    }


    public function create()
    {
        return AccessLevel::hasPermission('create', 'Ticket');
    }


    public function update()
    {
        return AccessLevel::hasPermission('edit', 'Ticket');
    }


    public function delete()
    {
        return AccessLevel::hasPermission('delete', 'Ticket');
    }

}
