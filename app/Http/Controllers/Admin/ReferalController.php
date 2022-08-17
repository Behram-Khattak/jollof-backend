<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GeneralMail;
use App\Models\Refer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferalController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function index()
    {
        $referals = Refer::with('user')->orderBy('gifted')
        ->where('signed_up_at', '!=' , null)
        ->paginate(10);
        // return $referals;
        return view('admin.referal.index', compact(['referals']));
    }


    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function sendReward(Request $request)
    {
        $messageData = [
            "first_name" => "Shaun Wright",
            "subject" => "CONGRATULATION!!! You are a winner",
            "message" => $request->input('message'),
        ];
        //send refer email
        Mail::to($request->input('email'))->send(new GeneralMail($messageData));
        // if mail is successfully sent output success otherwise output error
            Refer::whereCode($request->input('code'))->update([
                'gifted' => true,
            ]);

            return redirect(url()->previous())->with([
            'message', 'Reward Send successfully',
            'alert-type', 'success',
        ]);;
    }
}
