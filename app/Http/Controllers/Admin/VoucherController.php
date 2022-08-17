<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vouchers = Voucher::all();

        return view('admin.voucher.index', compact(['vouchers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $voucher = new Voucher();
        $locations = [];

        return view('admin.voucher.create', compact(['voucher', 'locations']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();

        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expire_date'] = date('Y-m-d', strtotime($date[1]));

        $data['location'] = implode(',', $data['location']);

        //add application data to database
        Voucher::create($data);

        //rediret to applications details page
        return redirect('/admin/voucher')->with([
            'message'    => 'Voucher created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $voucher = Voucher::findorfail($id);
        $locations = explode(',', $voucher->location);

        return view('admin.voucher.edit', compact(['voucher', 'locations']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validateData();

        $date = explode(' - ', $data['start_date']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['expire_date'] = date('Y-m-d', strtotime($date[1]));

        $data['location'] = implode(',', $data['location']);

        Voucher::where('id', $id)->update($data);

        return redirect('/admin/voucher')->with([
            'message'    => 'Voucher updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::findorfail($id);
        if ($voucher == null) {
            //redirect with message
            redirect('/admin/voucher')->with([
                'message', 'There was a problem deleting the voucher!',
                'alert-type', 'error',
            ]);
        }

        Voucher::where('id', $id)->delete();

        return redirect('/admin/voucher')->with([
            'message', 'Voucher has been cancelled!',
            'alert-type', 'success',
        ]);
    }

    /**
     * Validate form data.
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData()
    {
        return request()->validate([
            'title'              => 'required',
            'description'        => 'required',
            'redemption_details' => 'required',
            'location'           => 'required',
            'location.*'         => 'required',
            'start_date'         => 'required',
            'status'             => 'required',
        ]);
    }
}
