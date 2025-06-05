<?php


namespace App\Filament\Resources\DashboardResource;


use App\Services\Date;
use Carbon\Carbon;

class Form
{

    // fetch data from FORM {getter|setter}

    protected $data;
    public $errors;

    /**
     * Form constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data['collection'] = $data;
        $this->errors = [
            'suspension' => 'This user\'s already suspended! First, activate user.',
            'booking' => 'This place already taken!',
            'space' => 'The user has NOT registered for the reservation here!',
            'deactivation' => 'The reservation is deactivated by Admin!',
            'cancellation' => 'The reservation is cancelled by the user! ',
            'reservation' => 'The user has another reservation within this time! ',
            'cancellation_exists' => 'The cancellation for this number has already been made! ',
            'cancellation_conflict' => 'Two cancellations cannot come right after each other! Make a longer one. ',
        ];
    }

    public function getBooking()
    {
        return $this->data['collection']('booking');
    }

    public function getCollection()
    {
        return $this->data['collection'];
    }

    public function getEndDay(): string
    {
        return makeDoubleDigit($this->data['collection']('end_day'));
    }

    public function getEndMonth(): string
    {
        return makeDoubleDigit($this->data['collection']('end_month'));
    }

    public function getEndYear(): string
    {
        return $this->data['collection']('end_year');
    }

    public function getEndDate(): string
    {
        return $this->getEndYear() . '-' . $this->getEndMonth() . '-' . $this->getEndDay();
    }

    public function getHour($type)
    {
        return explode(':', $this->getTime($type))[0];
    }

    public function getMinute($type)
    {
        return explode(':', $this->getTime($type))[1];
    }

    public function getNumber()
    {
        return $this->data['collection']('number');
    }

    public function getState()
    {
        return $this->data['collection']('state');
    }

    public function getStartDay(): string
    {
        return makeDoubleDigit($this->data['collection']('start_day'));
    }

    public function getStartMonth(): string
    {
        return makeDoubleDigit($this->data['collection']('start_month'));
    }

    public function getStartYear(): string
    {
        return $this->data['collection']('start_year');
    }

    public function getStartDate(): string
    {
        return $this->getStartYear() . '-' . $this->getStartMonth() . '-' . $this->getStartDay();
    }

    public function getTime($type)
    {
        return explode(' ', $this->data['collection']($type))[1];
    }

    public function getUser()
    {
        return $this->data['collection']('user_id');
    }

    public function makeStartDate(): float|int|string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',
            Date::convertIntoLatin($this->getStartDate()) . ' ' . $this->getHour('start_hour') .
            ':' . $this->getMinute('start_hour') . ':00')
            ->timestamp;
    }

    public function makeEndDate(): float|int|string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',
            Date::convertIntoLatin($this->getEndDate()) . ' ' . $this->getHour('end_hour') .
            ':' . $this->getMinute('end_hour') . ':00'
        )->timestamp;
    }
}
