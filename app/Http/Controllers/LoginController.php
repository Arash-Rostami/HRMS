<?php

namespace App\Http\Controllers;

use App\Services\Theme;
use App\Services\Utility;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * @param $selectedTheme
     *
     * @return RedirectResponse
     */
    public function changeTheme($selectedTheme = null): RedirectResponse
    {
        list($cookieName, $selectedMode) = Theme::setDefaultMode($selectedTheme);

        Cookie::queue(
        // Name the cookie according to dark mode or theme
            Utility::nameCookie($cookieName),
            // Get the hex color
            Theme::changeColor($selectedMode),
            // Time
            config('app.cookie_time')
        );
        return back();
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('main', [
            'themes' => Theme::getTheme() ?? ' '
        ]);
    }


    public function show()
    {
        return view('dashboard')->with('type', request()->get('type'));
    }
}
