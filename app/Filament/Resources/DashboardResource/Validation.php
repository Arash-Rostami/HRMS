<?php


namespace App\Filament\Resources\DashboardResource;


use App\Models\Cancellation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Validation
{

    protected $model;
    protected $data;
    protected $user;
    protected $cancellation;

    /**
     * Validation constructor.
     * @param $model
     * @param $data
     */
    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
        $this->user = new User();
        $this->cancellation = new Cancellation();
    }


    /*    the user has booked within the time frame and is an employee,
    not VIP or guest*/
    public function hasUserBooked()
    {
        $reservation = $this->model
            ->isNotCancelled()
            ->isNotDeactivated()
            ->where('user_id', $this->data->getUser())
            ->where($this->checkTimeFrame())
            ->first();

        return ($reservation) ? ($reservation->user->type == 'employee') : false;
    }


    public function hasUserCancelled()
    {
        return $this->model
            ->where('booking', $this->data->getBooking())
            ->where('number', $this->data->getNumber())
            ->where('user_id', $this->data->getUser())
            ->where($this->checkTimeFrame())
            ->exists();
    }

    /*    the user that has booked within the time frame has privilege*/
    public function isBooking($variable)
    {
        $user = $this->user->find($this->data->getUser());

        return ($user) ? $user->booking == $variable : false;
    }

    public function isCancelled()
    {
        return $this->model
            ->isCancelled()
            ->where('number', $this->data->getNumber())
            ->where($this->checkTimeFrame())
            ->exists();
    }

    public function isPaused($form)
    {
        return $this->cancellation->where(function ($query) use ($form) {
            $query->where('number', $form->getNumber())
                ->where('start_date', '<=', $form->makeStartDate())
                ->where('end_date', '>=', $form->makeStartDate())
                ->where('start_date', '<=', $form->makeEndDate())
                ->where('end_date', '>=', $form->makeEndDate());
        })->exists();
    }

    public function isExtra($form, $number)
    {
        return $this->cancellation
                ->where('number', $number)
                ->where(function ($query) use ($form) {
                    $query->where('start_date', $form->makeEndDate())
                        ->orWhere('end_date', $form->makeStartDate());
                })
                ->exists();
    }

    public function isPlaceBooked()
    {
        return $this->model
            ->isNotCancelled()
            ->isNotDeactivated()
            ->where('number', $this->data->getNumber())
            ->where($this->checkTimeFrame())
            ->exists();
    }


    public function isUserDeactivated()
    {
        return $this->model
            ->isNotCancelled()
            ->isDeactivated()
            ->where('number', $this->data->getNumber())
            ->where($this->checkTimeFrame())
            ->exists();
    }


    public function isUserSuspended()
    {
        $reservation = $this->model
            ->isNotCancelled()
            ->where('number', $this->data->getNumber())
            ->where($this->checkTimeFrame())
            ->first();

        return ($reservation) ? $reservation->user->status === 'suspended' : false;
    }


    protected function checkTimeFrame(): \Closure
    {
        return function ($query) {
            // to check if it sits within the time frame
            $query->whereRaw('start_date <= ? AND end_date >= ?', [
                $this->data->makeStartDate(), $this->data->makeEndDate(),
            ])
                // to check if some part of it starts or ends before or after the time frame
                ->orWhereRaw('
                    CASE WHEN start_date >= ? THEN start_date < ?
                    WHEN end_date <= ? THEN end_date > ? END', [
                    $this->data->makeStartDate(), $this->data->makeEndDate(),
                    $this->data->makeEndDate(), $this->data->makeStartDate()
                ]);
        };
    }
}
