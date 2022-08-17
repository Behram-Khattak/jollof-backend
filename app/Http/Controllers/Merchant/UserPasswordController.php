<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view('merchant.profile.password', [
            'user' => auth()->user()->load('roles'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'password'],
            'new_password'     => ['required', 'string', 'min:6', 'different:current_password'],
            'verify_password'  => ['required', 'same:new_password'],
        ]);

        auth()->user()->update(['password' => Hash::make($request->input('new_password'))]);

        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'))->with('message', [
            'type' => 'success',
            'body' => 'Password changed! Log in with your new password.',
        ]);
    }
}
