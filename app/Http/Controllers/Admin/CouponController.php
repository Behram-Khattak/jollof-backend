<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $coupons = Coupon::withTrashed()
            ->orderBy('deleted_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.coupon.index', compact(['coupons']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $coupon = new Coupon();

        return view('admin.coupon.create', compact(['coupon']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $this->validateData();

        $date = explode(' - ', $data['date_range']);
        unset($data['date_range']);
        $data['start'] = date('Y-m-d', strtotime($date[0]));
        $data['expire'] = date('Y-m-d', strtotime($date[1]));
        $data['remains'] = $data['number_of_usage'];

        $status = $this->getCouponStatus($data['start'], $data['expire']);
        $data['status'] = $status;

        //add application data to database
        Coupon::create($data);

        //rediret to applications details page
        return redirect('/admin/coupon')->with([
            'message'    => 'Coupon created successfully',
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
        $coupon = Coupon::findorfail($id);
        $coupon->date_range = date('m-d-Y', strtotime($coupon->start)) . ' - ' . date('m-d-Y', strtotime($coupon->expire));

        return view('admin.coupon.edit', compact(['coupon']));
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
        $date = explode(' - ', $data['date_range']);
        unset($data['date_range']);

        $data['start'] = date('Y-m-d', strtotime($date[0]));
        $data['expire'] = date('Y-m-d', strtotime($date[1]));

        $coupon = Coupon::whereId($id)->first();
        $data['remains'] = $data['number_of_usage'] - $coupon->number_of_uses;

        $status = $this->getCouponStatus($data['start'], $data['expire']);
        $data['status'] = $status;

        Coupon::where('id', $id)->update($data);

        return redirect('/admin/coupon')->with([
            'message'    => 'Coupon updated successfully!',
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
        $coupon = Coupon::findorfail($id);
        if ($coupon == null) {
            //redirect with message
            redirect('/admin/coupon')->with([
                'message'    => 'There was a problem deleting the coupon!',
                'alert-type' => 'error',
            ]);
        }

        Coupon::where('id', $id)->delete();

        return redirect('/admin/coupon')->with([
            'message'    => 'Coupon deleted successfully!',
            'alert-type' => 'success',
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
            'name'        => 'required',
            'type' => 'required',
            'min_price' => 'nullable|numeric|lt:max_price',
            'max_price' => 'nullable|required_if:min_price,>0|numeric|gt:min_price',
            'number_of_usage' => 'required|numeric',
            'description' => 'required',
            'code'        => 'required',
            'receivers_name'  => 'required_if:type,private',
            'receivers_email'  => 'required_if:type,private',
            'percentage'  => 'required',
            'date_range'  => 'required',
        ]);
    }

    public function getCouponStatus($start = null, $end = null, $coupon_id = null)
    {
        $now = strtotime(now());
        if (is_null($coupon_id)) {
            if ($now >= strtotime($start) && $now <= strtotime($end)) {
                return 'active';
            } else {
                return 'inactive';
            }
        }
    }
}
