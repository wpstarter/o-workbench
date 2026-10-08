<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Auth\Events\Verified;
use WpStarter\Foundation\Auth\EmailVerificationRequest;
use WpStarter\Http\RedirectResponse;
use Orchestra\Workbench\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return ws_redirect()->intended(ws_route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            ws_event(new Verified($request->user()));
        }

        return ws_redirect()->intended(ws_route('dashboard', absolute: false).'?verified=1');
    }
}
