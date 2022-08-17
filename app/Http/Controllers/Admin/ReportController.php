<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\OrderItems;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function index()
    {
        $businesses = Business::whereStatus('approved')->get();
        $reports = [
            'orders',
        ];
        return view("admin.report.index", compact(['businesses', 'reports']));
    }



    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function filter(Request $request)
    {
        $data = $this->validateData();

        //calculate date
        $date = explode(' - ', $data['duration']);
        $data['start_date'] = date('Y-m-d', strtotime($date[0]));
        $data['end_date'] = date('Y-m-d', strtotime($date[1]));
        unset($data['duration']);

        $businesses = Business::whereStatus('approved')->get();
        $reports = [
            'orders',
        ];

        if ($data['report'] == 'orders') {
            $orders = $this->filterOrders($data);
            $input = $data;
            if ($orders->count() > 0) {
                $orders->load('order', 'business');
                $thisBusiness = $orders[1]->business->name ?? null;
            } else {
                $thisBusiness = '';
            }
            // $thisBusiness = $orders[1]->business->name ?? null;
            return view('admin.report.filter', compact(['orders', 'businesses', 'thisBusiness', 'reports', 'input']));
        }
    }


    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function filterOrders($data)
    {
        $orders = OrderItems::where('business_id', $data['business'])->where('created_at', '>', $data['start_date'])->where('created_at', '<', $data['end_date'])->latest()->get();
        if ($data['payment'] == 'paid') {
            return $orders->whereNotNull('paid_on');
        } elseif ($data['payment'] == 'unpaid') {
            return $orders->whereNull('paid_on');
        } else {
            return $orders;
        }
    }



    /**
     * undocumented function summary.
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData()
    {
        $request_data = [
            'business'  => 'required',
            'report'    => 'required',
            'duration'  => 'required',
            'payment'   => 'required',
        ];

        return request()->validate($request_data);
    }
}
