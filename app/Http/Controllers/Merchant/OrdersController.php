<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Mail\AdminOrderpaid;
use App\Models\Business;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            ->paginate(10);



        // dd($orders);
        // return count($orders);
        // $orders = OrderItems::addSelect([
        //     'paid' => Orders::select('status')
        //         ->whereColumn('orders.id', 'order_id')
        //         ->where('status', 'paid')
        // ])->whereIn('business_id', $businessArray)->latest()->paginate(20);
        // $orders->load('business', 'order');

        return view('merchant.orders.index', compact(['orders']));
    }

    // Pending orders

    public function pending()
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
        $orders = OrderItems::with(['business', 'order'])->whereIn('business_id', $businessArray)
            ->whereNotNull('paid_on')
            ->where('preorder', 0)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
        // $orders = OrderItems::addSelect(['paid' => Orders::select('status')
        //     ->whereColumn('orders.id', 'order_id')
        //     ->where('status', 'paid')
        //     ->limit(1)])->where('preorder', 0)->where('status', 'pending')->whereIn('business_id', $businessArray)->orderBy('created_at', 'desc')->paginate(10);

        // $orders->load('business', 'order');

        return view('merchant.orders.index', compact(['orders']));
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function preorders()
    {
        $user = User::with('business')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }

        $user->load('manager');
        foreach ($user->manager as $biz) {
            $businessArray[] = $biz->id;
        }

        $orders = OrderItems::with(['business', 'order'])->whereIn('business_id', $businessArray)
            ->whereNotNull('paid_on')
            ->where('preorder', 1)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        // $orders = $orders = OrderItems::addSelect(['paid' => Orders::select('status')
        //     ->whereColumn('orders.id', 'order_id')
        //     ->where('status', 'paid')
        //     ->limit(1)])->where('preorder', 1)->where('status', 'pending')->whereIn('business_id', $businessArray)->orderBy('created_at', 'desc')->paginate(10);
        // $orders->load('business', 'order');

        return view('merchant.orders.index', compact(['orders']));
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function processed()
    {
        $user = User::with('business')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }

        $user->load('manager');
        foreach ($user->manager as $biz) {
            $businessArray[] = $biz->id;
        }

        $orders = OrderItems::where('status', 'processing')->whereIn('business_id', $businessArray)->latest()->paginate(10);

        $orders->load('business', 'order');

        return view('merchant.orders.orders', compact(['orders']));
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function picked()
    {
        $user = User::with('business')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }

        $user->load('manager');
        foreach ($user->manager as $biz) {
            $businessArray[] = $biz->id;
        }

        $orders = OrderItems::where('status', 'pickedup')->whereIn('business_id', $businessArray)->latest()->paginate(10);
        $orders->load('business', 'order');

        return view('merchant.orders.orders', compact(['orders']));
    }


    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function delivered()
    {
        $user = User::with('business')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }

        $user->load('manager');
        foreach ($user->manager as $biz) {
            $businessArray[] = $biz->id;
        }

        $orders = OrderItems::where('status', 'delivered')->whereIn('business_id', $businessArray)->latest()->paginate(10);
        $orders->load('business', 'order');

        return view('merchant.orders.orders', compact(['orders']));
    }


    /**
     * Order Details.
     *
     * @param mixed $id
     * @param mixed $microsite
     * @param mixed $code
     */
    public function details(Business $business, $code)
    {
        $user = User::with('business')->where('id', Auth::id())->first();
        $businessArray = [];
        foreach ($user->business as $biz) {
            $businessArray[] = $biz->id;
        }
        $order = Orders::with('items')->where('order_code', $code)->first();
        $orderItems = OrderItems::where('order_id', $order->id)
            ->whereIn('business_id', $businessArray)->latest()->paginate(10);
        // $orderItems = $order->items()->get();
        $shipping = $order->shipping()->first();

        return view('merchant.orders.detail', compact(['order', 'orderItems', 'shipping']));
    }

    /**
     * Order Details.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function update(Request $request)
    {
        // return $request->all();
        $id = $request->input('order');
        $status = $request->input('status');
        // check request status
        if($status == 'processing'){
            $duration = $request->input('duration_process');
        }
        if($status == 'pickedup'){
            $duration = $request->input('duration_picked');
        }

        $data = [
            'status'   => $status,
            'duration' => $duration,
        ];

        if ($status == 'processing') {
            $data['process_timestamp'] = now();

            //send notifications to Admin
            $orderItems = OrderItems::whereId($id)->get();
            $order = Orders::with('user')->whereId($orderItems[0]->order_id)->first();
            $business = Business::whereId($orderItems[0]->business_id)->first();
            $admin = User::role('super-admin')->first();
            $dispatch = User::role('dispatch')->first();
            $shipping = $order->shipping()->first();


            $mailData = [
                'order_code'        => $order->order_code,
                'items'             => $orderItems,
                'subtotal'          => "NGN " . number_format($order->subtotal, 2),
                'total'             => "NGN " . number_format($order->total, 2),
                'sender'            => 'Jollof',
                'sender_email'      => 'orders@jollof.com',
                'shipping'          => $shipping
            ];

            $userData = $mailData;
            $userData['subject'] = "Your Order is Processing";
            $userData['message'] = $order->user->first_name . ", your order is now being processed";
            $userData['message_line2'] = "Your order is being processed and would be ready for delivery in the next " . $duration . "mins. We will let you know when it is in transit.";
            $userData['recipient'] = $order->user->first_name;
            $userData['recipient_email'] = $order->user->email;
            $userData['recipient_phone'] = $order->user->telephone;

            Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


            $merchantData = $mailData;
            $merchantData['subject'] = "Order is processing";
            $merchantData['message'] = $order->user->first_name . " we see that the order is being processed";
            $merchantData['message_line2'] = "Please get it ready for delivery in the " . $duration . "mins time stipluated";
            $merchantData['recipient'] = $business->name;
            $merchantData['recipient_email'] = $business->email;
            $merchantData['recipient_phone'] = $business->telephone;

            Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

            $adminData = $mailData;
            $adminData['subject'] = "Order is processing";
            $adminData['message'] = $business->first_name . " we see that the order is being processed";
            $adminData['message_line2'] = "Please get it ready for delivery in the " . $duration . "mins time stipluated";
            $adminData['recipient'] = $admin->first_name;
            $adminData['recipient_email'] = $admin->email;
            $adminData['recipient_phone'] = $admin->telephone;

            Mail::to($admin->email)->send(new AdminOrderPaid($adminData));

            if ($dispatch !== null) {
                $dispatchData = $mailData;
                $dispatchData['subject'] = "You have an order to pickup";
                $dispatchData['message'] = "An order has been placed on " . $business->name;
                $dispatchData['message_line2'] = "";
                $dispatchData['recipient'] = $dispatch->first_name;
                $dispatchData['recipient_email'] = $dispatch->email;
                $dispatchData['recipient_phone'] = $dispatch->telephone;
                //mail dispatch
                Mail::to($dispatch->email)->send(new AdminOrderPaid($dispatchData));
            }
        }

        if ($status == 'pickedup') {
            $data['pickup_timestamp'] = now();
        }

        if ($status == 'delivered') {
            $data['delivery_timestamp'] = now();
        }

        OrderItems::where('id', $id)->update($data);

        return redirect(route('merchant.restaurant.orders', request()->route('business')))->with([
            'message'    => 'Order has been updated successfully!',
            'alert-type' => 'success',
        ]);
    }
}
