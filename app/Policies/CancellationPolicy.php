<?php

namespace App\Policies;

use App\Models\Cancellation;
use App\Models\Desk;
use App\Models\Park;
use App\Models\User;
use App\Services\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CancellationPolicy
{
    use HandlesAuthorization;

    public array $model;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = [
            'parking' => new Park(),
            'office' => new Desk(),
        ];
    }

    public function delete(User $user, Cancellation $cancellation)
    {
        return 1 > $this->model[$cancellation->booking]
                ->isNotDeactivated()
                ->isNotCancelled()
                ->where('user_id', '!=', $cancellation->user_id)
                ->where('number', $cancellation->number)
                ->checkDate($cancellation->start_date, $cancellation->end_date)
                ->count();
    }

    public function suspend(User $user, Cancellation $cancellation)
    {
        $number = $cancellation->number;

        $extensionMessage = "Another suspension for this period already exists. Contact the admin to resolve this.";

        if ($cancellation->isAppended($number) || $cancellation->isPrepended($number)) {
            return Response::deny($extensionMessage);
        }

        return true;
    }

    public function viewAny()
    {
        return AccessLevel::hasPermission('view','Cancellation');
    }

    public function view()
    {
        return AccessLevel::hasPermission('view','Cancellation');
    }

    public function update()
    {
        return AccessLevel::hasPermission('edit','Cancellation');
    }

    public function create()
    {
        return AccessLevel::hasPermission('create','Cancellation');
    }
}
