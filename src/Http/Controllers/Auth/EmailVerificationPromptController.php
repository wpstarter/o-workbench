<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\View\View;
use Orchestra\Workbench\Http\Controllers\Controller;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? ws_redirect()->intended(ws_route('dashboard', absolute: false))
                    : ws_view('auth.verify-email');
    }
}
