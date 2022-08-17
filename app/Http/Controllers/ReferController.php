<?php

namespace App\Http\Controllers;

use App\Mail\ReferFriend;
use App\Models\Refer;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReferController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view("user.refer.referFriend");
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function sendrefer(Request $request)
    {
        $referalCode = Auth::user()->username . '-' . Str::random(20);
        $referal_url = env('APP_URL') . '/user/register/' . $referalCode;
        $messageData = [
            "first_name" => $request->input('firstname'),
            "last_name" => $request->input('lastname'),
            "email" => $request->input('email'),
            "referer" => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            "username" => Auth::user()->username,
            "code" => $referal_url
        ];


        //store refer data in db
        Refer::create([
            "user_id" => Auth::user()->id,
            "first_name" => $request->input('firstname'),
            "last_name" => $request->input('lastname'),
            "email" => $request->input('email'),
            "code" => $referalCode
        ]);

        //send refer email
        Mail::to($request->input('email'))->send(new ReferFriend($messageData));

        return redirect(url()->previous())->with('success', 'Invite sent successfully');
    }
}
