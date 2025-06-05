<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopHomePageController extends Controller
{
    public function index()
    {
        if (auth()->user()->forename !== 'Arash') abort(403, 'You are not authorized to access this page.');

        return view('components.shop.home');
    }
}
