<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use Orchestra\Workbench\Http\Controllers\Controller;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return ws_redirect()->intended(ws_route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return ws_back()->with('status', 'verification-link-sent');
    }
}
