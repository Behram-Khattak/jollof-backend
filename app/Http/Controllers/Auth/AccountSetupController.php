<?php

namespace App\Http\Controllers\Auth;

use App\Enums\DefaultRoles;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountSetupController extends Controller
{
    /**
     * Finish setting up thr user's account.
     *
     * @param Request $request
     *
     * @throws ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function setup(Request $request)
    {
        $request->validate([
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
            'terms'                 => ['accepted'],
        ]);

        $user = User::find(decrypt($request->input('id')));

        if (!$user || $user->email !== $request->input('email')) {
            throw ValidationException::withMessages(['email' => 'This :attribute does not match our records.']);
        }

        $user->update([
            'password'          => \Hash::make($request->input('password')),
            'email_verified_at' => now(),
        ]);

        auth()->login($user);

        if (auth()->user()->hasRole([DefaultRoles::DISPATCH])) {
            $path = RouteServiceProvider::DISPATCH;
        }
        else{

            $path =  auth()->user()->hasRole([DefaultRoles::USER, DefaultRoles::MERCHANT])
            ? RouteServiceProvider::INDEX
            : RouteServiceProvider::ADMIN;
        }


        return redirect($path);
    }

    /**
     * Path to redirect user to.
     *
     * @return string
     */
    public function redirectTo()
    {
        return auth()->user()->hasRole([DefaultRoles::USER, DefaultRoles::MERCHANT])
            ? RouteServiceProvider::INDEX
            : RouteServiceProvider::ADMIN;
    }

    /**
     * Show the account setup form.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('auth.setup', [
            'id'   => $request->query('user'),
            'user' => User::findOrFail(decrypt($request->query('user'))),
        ]);
    }
}
