<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Hash;
use WpStarter\Validation\Rules\Password;
use Orchestra\Workbench\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return ws_back()->with('status', 'password-updated');
    }
}
