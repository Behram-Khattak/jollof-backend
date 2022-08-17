<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function profile()
    {

        $user = Auth::user();

        return view('user.settings.profile', compact(['user']));
    }


    public function updateProfile(Request $request)
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

        return redirect()->route('user.settings.update.profile')->with([
            'success'    => 'Profile updated successfully!'
        ]);
    }

    public function password()
    {
        return view('user.settings.password');
    }

    public function updatePassword(Request $request)
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


    public function shipping()
    {

        $shipping = ShippingAddress::whereUserId(Auth::id())->get();

        $addressTypes = [];


        return view('user.settings.shipping', compact(['shipping']));
    }


    public function storeShipping(Request $request)
    {

        $validatedData = $request->validate([
            "type.*"      => "required",
            "address.*"   => "required",
            "city.*"      => "required",
            "state.*"     => "required",
        ]);

        //dd(count($validatedData['type']));
        for ($i = 0; $i < count($validatedData['type']); $i++) {
            $hasAddress = ShippingAddress::where("user_id", Auth::id())->where("type", $validatedData['type'][$i])->first();
            if (!$hasAddress) {
                ShippingAddress::create([
                    'user_id'   => Auth::id(),
                    'type'      => $validatedData['type'][$i],
                    'address'   => $validatedData['address'][$i],
                    'city'      => $validatedData['city'][$i],
                    'state'     => $validatedData['state'][$i],
                ]);
            } else {
                ShippingAddress::where("user_id", Auth::id())->where("type", $validatedData['type'][$i])->update([
                    'user_id'   => Auth::id(),
                    'type'      => $validatedData['type'][$i],
                    'address'   => $validatedData['address'][$i],
                    'city'      => $validatedData['city'][$i],
                    'state'     => $validatedData['state'][$i],
                ]);
            }
        }

        return redirect(url()->previous())->with([
            'alertType' => 'success',
            'message' => 'Addres updated successfully'
        ]);
    }
}
