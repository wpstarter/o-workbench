<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Auth;
use WpStarter\Validation\ValidationException;
use WpStarter\View\View;
use Orchestra\Workbench\Http\Controllers\Controller;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return ws_view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => ws___('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return ws_redirect()->intended(ws_route('dashboard', absolute: false));
    }
}
