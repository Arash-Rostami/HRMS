<?php

namespace App\Services\api;


use Kavenegar;
use App\Services\RandomMessage;

class SmsOperator
{
    protected string $phoneNumber;

    public function __construct()
    {
        $this->phoneNumber = "90006727";
    }

    public function send(string|array $receptor, string $message)
    {
        try {

            $result = Kavenegar::Send($this->phoneNumber, $receptor, $message);

            if ($result) return true;

        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Exceptions $ex) {
            // در صورت بروز خطایی دیگر
            echo $ex->getMessage();
        }
    }

}
