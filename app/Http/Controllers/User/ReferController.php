<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Refer;
use Auth;
use Illuminate\Http\Request;

class ReferController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function index()
    {
        $totalReferals = Refer::where('user_id', Auth::user()->id)->get();
        $totalSignups = Refer::where('user_id', Auth::user()->id)->where('signed_up_at', '!=', NULL)->get();

        return view('user.refer.index', compact(['totalReferals', 'totalSignups']));
    }
}
