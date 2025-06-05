<?php

namespace App\Http\Controllers;

use App\Services\api\SmsOperator;
use App\Services\RandomMessage;
use Illuminate\Http\Request;

class UserSmsController extends Controller
{
    public function send(Request $request, SmsOperator $smsService)
    {
        $validatedData = $request->validate([
            'receptor' => ['required', 'regex:/[^\s]/'],
            'message' => ['required', 'regex:/[^\s]/']
        ]);

        $message = RandomMessage::getCustomizedMessage($validatedData['message']);

        return $smsService->send($validatedData['receptor'], $message);
    }
}
