<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Shipping;
use Auth;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function list()
    {
        $this->deleteUnpaidOrders();
        $orders = Orders::with('items')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $wishlist = [];

        return view('user.orders.list', compact(['orders', 'wishlist']));
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
        $order = Orders::where('user_id', Auth::id())->where('order_code', $code)->first();
        $orderItems = $order->items()->get();
        $shipping = Shipping::where('id', $order->shipping_id)->first();

        return view('user.orders.details', compact(['order', 'orderItems', 'shipping']));
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
    public function destroy(Request $request, $id)
    {
        //dd($request->input());
        $order = Orders::findorfail($request->input('id'));

        $order->delete();

        return redirect()->route('orders.list')->with('success', 'Order was cancelled successfully.');
    }


    public function deleteUnpaidOrders()
    {
        $deleteDate = date('Y-m-d h:i:s', strtotime('- 2 days'));
        $orders = Orders::with('items')->where('user_id', Auth::id())->where('created_at', '<', $deleteDate)->where('status', '!=',  'paid')->get();
        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $order->items()->delete();
                $order->delete();
            }
        }
    }
}
