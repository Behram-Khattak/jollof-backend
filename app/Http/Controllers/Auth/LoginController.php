<?php

namespace App\Http\Controllers\Auth;

use App\Enums\DefaultRoles;
use App\Enums\TeamRoles;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        if (auth()->user()->hasRole([DefaultRoles::DISPATCH])) {
            return RouteServiceProvider::DISPATCH;
        }

        if (auth()->user()->hasRole([DefaultRoles::MERCHANT,  TeamRoles::MANAGER])) {
            return RouteServiceProvider::MERCHANT;
        }

        if (auth()->user()->hasRole([DefaultRoles::USER])) {
            return RouteServiceProvider::INDEX;
        }

        return RouteServiceProvider::ADMIN;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field     => $request->get($this->username()),
            'password' => $request->input('password'),
        ];
    }
}
