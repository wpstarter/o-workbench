<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Auth\Events\PasswordReset;
use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Hash;
use WpStarter\Support\Facades\Password;
use WpStarter\Support\Str;
use WpStarter\Validation\Rules;
use WpStarter\Validation\ValidationException;
use WpStarter\View\View;
use Orchestra\Workbench\Http\Controllers\Controller;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return ws_view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                ws_event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? ws_redirect()->route('login')->with('status', ws___($status))
                    : ws_back()->withInput($request->only('email'))
                        ->withErrors(['email' => ws___($status)]);
    }
}
