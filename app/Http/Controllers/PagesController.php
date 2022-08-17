<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Enums\JollofEmails;
use App\Models\BusinessType;
use App\Models\JollofUser;
use App\Models\Role;
use Newsletter;

class PagesController extends Controller
{
    /**
     * Display the Telescope view.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome($code)
    {
        $user = JollofUser::where('code', $code)->first();
        if (!$user) {
            return redirect()->route('index');
        }

        $role = Role::all(); //whereName($name)->first();
        $states = json_decode(file_get_contents((base_path('nigeria-state-and-lgas.json'))), true);
        $businessTypes = BusinessType::all(['id', 'name'])->sortBy('name');

        return view('pages.welcome', compact(['user', 'businessTypes', 'states', 'role']));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms-and-conditions');
    }

    public function refund()
    {
        return view('pages.refund');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendcontact(Request $request)
    {
        //dd($request->input());
        $messageData = [
            "first_name" => $request->input('firstname'),
            "last_name" => $request->input('lastname'),
            "email" => $request->input('email'),
            "address" => $request->input('address'),
            "message" => $request->input('message')
        ];
        Mail::to(JollofEmails::SUPPORT)->send(new Contact($messageData));

        return redirect(url()->previous())->with('success', 'Message sent successfully');
    }

    public function subscribe(Request $request)
    {

        Newsletter::subscribeOrUpdate($request->user_email, ['FNAME' => $request->user_name]);

        return redirect(url()->previous())->with('success', 'You have successfully subscribed to Jollof newsletter.');
    }

    public function mail(){
        return view('emails.orders.adminOrderPaid');
    }
}
