<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserEmailController extends Controller
{

    public function show()
    {
        return view('components.user.email-form');
    }
}
