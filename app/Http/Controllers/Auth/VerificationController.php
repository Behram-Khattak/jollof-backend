<?php

namespace App\Http\Controllers\Auth;

use App\Enums\DefaultRoles;
use App\Enums\TeamRoles;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Where to redirect users when verification expires.
     *
     * @var string
     */
    protected $verificationExpireRedirect = "email/verify";

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('resend');
        //$this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|Response
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));
        if (!auth()->check()) {
            auth()->login($user);
        }

        if (!hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException();
        }

        if (!hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            //throw new AuthorizationException();

            return redirect($this->verificationExpireRedirect)->with(
                'expverify',
                'Your e-mail link has expired. Request another verification link to be sent to your e-mail and complete e-mail verification.'
            );
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath())->with('message', [
                    'type' => 'warning',
                    'body' => 'Your e-mail address is already verified.',
                ]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        $msg = "Your e-mail address has been verified.";
        if ($request->user()->hasRole([DefaultRoles::MERCHANT, TeamRoles::MANAGER])) {
            $business = Business::whereOwnerId($request->user()->id)
                ->orWhere('manager_id', $request->user()->id)
                ->first();

            return redirect()->route('merchant.business.show', $business)->with([
                'alert-type' => 'success',
                'message'    => $msg,
            ]);
        }


        return redirect($this->redirectPath())->with('message', [
            'type' => 'success',
            'body' => $msg,
        ]);
    }
}
