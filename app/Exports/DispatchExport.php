<?php

namespace App\Exports;

use App\Models\OrderItems;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DispatchExport implements FromView
{
    /**
    * @return View
    */
    public function view(): View
    {
        $orders = OrderItems::with('order.shipping.user')->whereStatus('delivered')->orderBy('updated_at','desc')->get();
        return view('exports.orders', compact('orders'));
    }
}
