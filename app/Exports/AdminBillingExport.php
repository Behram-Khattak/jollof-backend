<?php

namespace App\Exports;

use App\Models\Business;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payout;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminBillingExport implements FromView
{
    /**
    * @return View
    */
    protected $business;
    protected $start;
    protected $end;
    protected $monthEnd;
    protected $monthStart;

    public function __construct($business,$start,$end)
    {
        $this->business = $business;
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        $business = Business::where('id', $this->business)->first();
        $orders = OrderItems::with('order.shipping.user')
        ->where('business_id', $business->id)
            ->where('created_at', '>=', $this->start)
            ->where('created_at', '<=', $this->end)
            ->addSelect([
                'order_status' => Orders::select('status')
                    ->whereColumn('order_id', 'orders.id')
                    ->limit(1)
            ])
            ->get();

        return view('exports.billing', compact(['orders']));
    }
}
