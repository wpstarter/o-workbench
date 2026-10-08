<?php

namespace Orchestra\Workbench\Http\Controllers\Auth;

use WpStarter\Auth\Events\Registered;
use WpStarter\Foundation\Auth\User;
use WpStarter\Http\RedirectResponse;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Auth;
use WpStarter\Support\Facades\Hash;
use WpStarter\Validation\Rules;
use WpStarter\Validation\ValidationException;
use WpStarter\View\View;
use Orchestra\Sidekick\Env;
use Orchestra\Workbench\Http\Controllers\Controller;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return ws_view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $userModel = Env::get('TESTBENCH_USER_MODEL', User::class);

        $user = $userModel::forceCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        ws_event(new Registered($user));

        Auth::login($user);

        return ws_redirect($this->redirectToAfterLoggedIn());
    }
}
