<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class OrdersController extends Controller
{
    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function index()
    {
        $orders = OrderItems::with('order.shipping.user')->latest()
        ->whereNotNull('paid_on')
        ->paginate(10);

        return view('admin.orders.index', compact(['orders']));
    }

    /**
     * Order Details.
     *
     * @param mixed $id
     * @param mixed $microsite
     * @param mixed $code
     */
    public function details($code)
    {
        $order = Orders::with('items.business')->where('order_code', $code)->first();
        $order->load('transaction');
        $orderItems = $order->items()->get();
        $shipping = $order->shipping()->first();

        return view('admin.orders.details', compact(['order', 'orderItems', 'shipping']));
    }

    /**
     * Order Details.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function update(Request $request)
    {
        $id = $request->input('order');
        $status = $request->input('status');
        $duration = $request->input('duration');

        $data = [
            'status'   => $status,
            'duration' => $duration,
        ];

        if ($status == 'processing') {
            $data['process_timestamp'] = now();
        }

        if ($status == 'pickedup') {
            $data['pickup_timestamp'] = now();
        }

        if ($status == 'delivered') {
            $data['delivery_timestamp'] = now();
        }

        OrderItems::where('id', $id)->update($data);

        return redirect('/admin/orders')->with([
            'message'    => 'Order has been updated successfully!',
            'alert-type' => 'success',
        ]);
    }
}
