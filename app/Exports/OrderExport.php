<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\OrderItems;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        $user = User::with('business.orderItems.order.shipping.user')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }

        $user->load('manager');
        foreach ($user->manager as $biz) {
            $businessArray[] = $biz->id;
        }
        // dd($businessArray);

        $orders = OrderItems::with(['business', 'order'])->whereIn('business_id', $businessArray)
        ->whereNotNull('paid_on')
        ->latest()
        ->get();
        return view('exports.orders', compact('orders'));
    }
}
