<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Password;
use WpStarter\Validation\ValidationException;
use WpStarter\View\View;
use Orchestra\Workbench\Http\Controllers\Controller;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return ws_view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? ws_back()->with('status', ws___($status))
                    : ws_back()->withInput($request->only('email'))
                        ->withErrors(['email' => ws___($status)]);
    }
}
