<?php


namespace App\Services;


class ReservationMaker
{
    private $reservation;

    public function __construct(ReservationInterface $reservation)
    {
        $this->reservation = $reservation;
    }

    public function confirm()
    {
        return $this->reservation->getArea();
    }

    public function update($number)
    {
        return $this->reservation->update($number);
    }
}
