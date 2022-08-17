<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payout;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public $monthStart;
    public $monthEnd;

    public function __construct()
    {
        $this->monthStart = date('Y/m/01', strtotime('today'));
        $this->monthEnd = date('Y/m/t', strtotime('today'));
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
    public function index()
    {
        $dateStart = $this->monthStart;
        $dateEnd = $this->monthEnd;

        $orders = Orders::where('created_at', '>=', $dateStart)->where('created_at', '<=', $dateEnd)->get();
        $sales = Orders::where('created_at', '>=', $dateStart)->where('created_at', '<=', $dateEnd)->where('status', 'paid')->get();
        $businesses = Business::with('payout')->where('status', 'approved')->get();
        return view('admin.billing.index', compact(['orders', 'sales', 'businesses', 'dateStart', 'dateEnd']));
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
    public function show(Request $request, Business $business)
    {
        $range = explode('-', $request->input('duration'));
        $data = [
            'business' => $business,
            'start' => str_replace('/', '-', $range[0]),
            'end' => str_replace('/', '-', $range[1]),
        ];

        $payout = Payout::with('requests')->where('business_id', $business->id)->first();
        $request = $payout->requests()->orderBy('id', 'desc')->first();

        $this->monthStart = date('Y-m-d', strtotime($range[0]));
        $this->monthEnd = date('Y-m-d', strtotime($range[1]));
        $payoutdate = ($request) ? $request->payout_date : date('Y-m-d', strtotime($range[0]));

        $orders = OrderItems::with('order.shipping.user')
            ->where('business_id', $business->id)
            ->where('created_at', '>=', $this->monthStart)
            ->where('created_at', '<=', $this->monthEnd)
            ->addSelect([
                'order_status' => Orders::select('status')
                    ->whereColumn('order_id', 'orders.id')
                    ->limit(1)
            ])
            ->latest()->get();

        $sales = OrderItems::with('order.shipping.user')
            ->where('business_id', $business->id)
            ->where('paid_on', '>=', $payoutdate)
            ->where('paid_on', '<=', $this->monthEnd)
            ->latest()->get();

        return view('admin.billing.details', compact(['orders', 'sales', 'business', 'payout', 'request', 'data']));
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
    public function update(Request $request)
    {
        // dd($request->input());
        $data = $request->validate([
            "percentage" => "required|numeric",
            "business_id" => "required|numeric",
        ]);

        $payout = Payout::where("business_id", $data['business_id'])->firstorfail();
        $payout->update($data);

        return redirect()->route('admin.billing')->with([
            'alertType' => 'success',
            'message' => 'Payout percentage updated successfully.'
        ]);
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
    public function history(Business $business)
    {
        $dateStart = $this->monthStart;
        $dateEnd = $this->monthEnd;
        $history = Payout::with('requests')->where('business_id', $business->id)->first();
        return view('admin.billing.history', compact(['history', 'business', 'dateStart', 'dateEnd']));
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
    public function payout(Request $request, Business $business)
    {
        //check payout amount and last payout date
        $payout = Payout::where('business_id', $business->id)->firstorfail();
        //add payout to payout request table
        PayoutRequest::create([
            'payout_id' => $payout->id,
            'amount' => $request->input('amount'),
            'payout_date' => now(),
        ]);

        //calculate next payout date
        $frequencyDays = ($payout->frequency == "Weekly") ? 7 : (($payout->frequency == 'Bi-Weekly') ? 14 : 30);
        $nextPayout = date('Y-m-d', strtotime('+ ' . $frequencyDays . ' days'));
        //update payout table
        $payout->next_payout = $nextPayout;
        $payout->save();

        return redirect()->route('admin.billing.payout.completed', ['business' => $business])->with([
            'alertType' => 'success',
            'message' => 'Payout completed successfully.'
        ]);
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
    public function completed(Business $business)
    {
        $dateStart = $this->monthStart;
        $dateEnd = $this->monthEnd;
        return view('admin.billing.completed', compact(['business', 'dateStart', 'dateEnd']));
    }
}
