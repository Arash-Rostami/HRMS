<?php


namespace App\Services;


interface ReservationInterface
{
    public function getArea();

    public function save();

    public function sendText();

    public function update($number);
}
