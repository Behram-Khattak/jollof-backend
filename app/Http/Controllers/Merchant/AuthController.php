<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Routing\Controller;
use Mpociot\Teamwork\Facades\Teamwork;

class AuthController extends Controller
{
    /**
     * Accept the given invite.
     *
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptInvite($token)
    {
        $invite = Teamwork::getInviteFromAcceptToken($token);
        if (!$invite) {
            abort(404);
        }

        if (auth()->check()) {
            Teamwork::acceptInvite($invite);

            return redirect()->route('merchant.teams.index');
        }
        session(['invite_token' => $token]);

        return redirect()->to('login');
    }
}
