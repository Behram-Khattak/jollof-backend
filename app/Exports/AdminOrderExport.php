<?php

namespace App\Exports;

use App\Models\OrderItems;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminOrderExport implements fromView
{
    /**
    * @return View
    */
    public function view(): View
    {
        $orders = OrderItems::with('order.shipping.user')->latest()
        ->whereNotNull('paid_on')
        ->paginate(10);

        return view('exports.orders', compact('orders')); 
    }
}
