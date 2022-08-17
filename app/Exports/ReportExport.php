<?php

namespace App\Exports;

use App\Models\OrderItems;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    /**
     * @return View
     */
    protected $start;
    protected $end;
    protected $business;
    protected $payment;

    function __construct($start, $end,$business, $payment)
    {
        $this->start = $start;
        $this->end = $end;
        $this->business = $business;
        $this->payment = $payment;
    }

    public function view(): View
    {
        $user = User::with('business')->whereId(Auth::id())->first();
        $businesses = $user->business;
        $reports = [
            'orders',
        ];
        $data = [
            'start_date' => $this->start,
            'end_date' => $this->end,
            'business' => $this->business,
            'payment' => $this->payment,
        ];

        $orders = $this->filterOrders($data);

        // if ($orders->count() > 0) {
        //     $orders->load('order', 'business');
        //     $thisBusiness = $orders[1]->business->name ?? null;
        // } else {
        //     $thisBusiness = '';
        // }
        return view('exports.report', compact(['orders']));
        // if ($data['report'] == 'orders') {
        // }
    }

    public function filterOrders($data)
    {
        $orders =  OrderItems::where('business_id', $data['business'])->where('created_at', '>', $data['start_date'])->where('created_at', '<', $data['end_date'])->latest()->get();

        if ($data['payment'] == 'paid') {
            return $orders->whereNotNull('paid_on');
        } elseif ($data['payment'] == 'unpaid') {
            return $orders->whereNull('paid_on');
        } else {
            return $orders;
        }
    }
}
