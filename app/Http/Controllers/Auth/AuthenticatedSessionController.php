<?php

namespace App\Http\Controllers\Auth;

use App\Events\UpdateLastSeen;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Theme;
use App\Services\Utility;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }
//     * @return \Illuminate\Http\RedirectResponse

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     */
    public function store(LoginRequest $request)
    {
        $ip = $request->ip();
        $key = "login_attempts:{$ip}";

        // Check if the user has exceeded the max attempts
        if ($this->limiter->tooManyAttempts($key, 10)) {
            throw ValidationException::withMessages([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $this->limiter->availableIn($key),
                ]),
            ]);
        }
        // set dark mode as the default
        if (!request()->cookie('mode')) {
            (new LoginController())->changeTheme();
        }

        $request->authenticate();

        $request->session()->regenerate();

        // Dispatch the event to change the timing
        event(new UpdateLastSeen(auth()->user()));

        // Dispatch the event to change the presence to onsite
        event(new UserLoggedIn(auth()->user()));


        // Reset login attempts after successful login
        $this->limiter->clear($key);

        $user = auth()->user();

        if ($user->status !== 'inactive') {
            if (session()->has('url.intended')) {
                return redirect()->intended();
            }

            if (isAdminButNotDev($user)) {
                return redirect()->intended('user.panel');
            }

            if (isAdmin($user)) {
                return redirect(RouteServiceProvider::ADMIN)->withCookie(cookie('mode'));
            }

            return redirect()->intended('user.panel');
        } else {
            // User is inactive, so log them out
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'status' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Dispatch the  event to change the timing
        event(new UpdateLastSeen(auth()->user()));

        // Dispatch the event to change the presence to onleave
        event(new UserLoggedOut(auth()->user()));

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
