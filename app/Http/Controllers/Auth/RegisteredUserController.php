<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NotifySignUp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'forename' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]*$/u'],
            'surname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',
                'regex:/@(persolco\.com|persoreco\.com|solsuntrading\.com)$/u'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
            // Customized error messages, instead of 'invalid format'
            [
                'forename.regex' => 'Please write the forename in English.',
                'surname.regex' => 'Please write the surname in English.',
                'email.regex' => 'The e-mail should end with "solsuntrading.com", "persolco.com" or "persoreco.com".',
            ]);

        $user = User::create([
            'forename' => $request->forename,
            'surname' => $request->surname,
            'email' => $request->email,
            'open_password' => Crypt::encryptString($request->password),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user->notify(new NotifySignUp());

        if (isAdminButNotDev($user)) {
            return redirect(RouteServiceProvider::HOME);
        };

        if (isAdmin($user)) {
            return redirect(RouteServiceProvider::ADMIN)->withCookie(Cookie::forget('mode'));
        };

        return redirect(RouteServiceProvider::HOME);
    }
}
