<?php


namespace App\Filament\Resources\DashboardResource;


use App\Services\Date;
use Carbon\Carbon;

class Model
{
    // fetch data from DESK model {getter | setter}
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    protected function getDate($column, $number): string
    {
        $date = explode('-', explode(' ', Date::convertTimeStamp($this->data[$column]))[0])[$number];

        return ltrim($date, '0');
    }

    public function getStartDay()
    {
        return $this->getDate('start_date', 2);
    }

    public function getStartMonth()
    {
        return $this->getDate('start_date', 1);

    }

    public function getStartYear()
    {
        return $this->getDate('start_date', 0);

    }

    public function getEndDay()
    {
        return $this->getDate('end_date', 2);
    }

    public function getEndMonth()
    {
        return $this->getDate('end_date', 1);
    }

    public function getEndYear()
    {
        return $this->getDate('end_date', 0);
    }

    public function setEndHour()
    {
        return makeDoubleDigit($this->data['end_hour']) . ':59';
    }

    public function setStartHour()
    {
        return makeDoubleDigit($this->data['start_hour']) . ':00';
    }

    public function setEndDate()
    {
        $date = $this->data['end_year'] . '-' . makeDoubleDigit($this->data['end_month']) . '-'
            . makeDoubleDigit($this->data['end_day']);

        return Carbon::createFromFormat('Y-m-d H:i:s', Date::convertIntoLatin($date) . ' ' .
            $this->setEndHour())->timestamp;
    }

    public function setStartDate()
    {
        $date = $this->data['start_year'] . '-' . makeDoubleDigit($this->data['start_month']) . '-'
            . makeDoubleDigit($this->data['start_day']);

        return Carbon::createFromFormat('Y-m-d H:i:s', Date::convertIntoLatin($date) . ' '
            . $this->setStartHour())->timestamp;
    }
}
