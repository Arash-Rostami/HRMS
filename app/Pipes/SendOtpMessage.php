<?php

namespace App\Pipes;

use App\Services\api\SmsOperator;

class SendOtpMessage
{
    public function handle($user) {

        $smsService = new SmsOperator();
        $message = "Your One-Time Login Code: " . session('otp');
        // .' @https://team.persolco.com/otp';

        $smsService->send($user->profile->cellphone, $message);
        return redirect()->back()->with('message', 'OTP sent to your phone.');
    }
}
