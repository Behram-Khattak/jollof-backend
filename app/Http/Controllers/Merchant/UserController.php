<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return view('merchant.profile.show', [
            'user' => auth()->user()->load('roles'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'username'   => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore(auth()->id())],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'telephone'  => ['required', 'string', new PhoneNumber(), Rule::unique('users')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'telephone'  => phone($request->input('telephone'), 'NG')->formatE164(),
        ]);

        return redirect()->route('merchant.profile.show')->with([
            'message'    => 'Profile updated successfully!',
            'alert-type' => 'success',
        ]);
    }
}
