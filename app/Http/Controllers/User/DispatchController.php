<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\AdminOrderpaid;
use App\Models\Business;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class DispatchController extends Controller
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
    public function index()
    {
        $orders = OrderItems::with('order.shipping.user')->where('status', '!=', 'delivered')->where('status', '!=', 'pickedup')->orderBy('updated_at', 'desc')->get();

        return view('dispatch.index', compact(['orders']));
    }


    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function completed()
    {
        $orders = OrderItems::with('order.shipping.user')->where('status', 'delivered')->get();

        return view('dispatch.index', compact(['orders']));
    }

    public function pickedup()
    {
        $orders = OrderItems::with('order.shipping.user')->where('status', 'pickedup')->get();

        return view('dispatch.index', compact(['orders']));
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
        $order = Orders::where('order_code', $code)->first();
        $orderItems = $order->items()->get();
        $shipping = Shipping::where('id', $order->shipping_id)->first();

        return view('dispatch.details', compact(['order', 'orderItems', 'shipping']));
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
        $duration = ($status == 'delivered') ? now() : $request->input('duration');

        $data = [
            'status'   => $status,
            'duration' => $duration,
        ];

        if ($status == 'processing') {
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
            $data['process_timestamp'] = now();
        }

        if ($status == 'pickedup') {
            //send notifications to Admin
            $orderItems = OrderItems::whereId($id)->get();
            $order = Orders::with('user')->whereId($orderItems[0]->order_id)->first();
            $business = Business::whereId($orderItems[0]->business_id)->first();
            $admin = User::role('super-admin')->first();
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
            $userData['subject'] = "Your Order Has been picked up";
            $userData['message'] = $order->user->first_name . ", your order has been picked up";
            $userData['message_line2'] = "Your order has been picked up and would be delivered in the next " . $duration . "mins.";
            $userData['recipient'] = $order->user->first_name;
            $userData['recipient_email'] = $order->user->email;
            $userData['recipient_phone'] = $order->user->telephone;

            Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


            $merchantData = $mailData;
            $merchantData['subject'] = "Order has been picked up by " . auth()->user()->first_name;
            $merchantData['message'] = $business->name . " we see that the order is being picked up";
            $merchantData['message_line2'] = "Please ensure it's delivered between the " . $duration . "mins time stipluated";
            $merchantData['recipient'] = $business->name;
            $merchantData['recipient_email'] = $business->email;
            $merchantData['recipient_phone'] = $business->telephone;

            Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

            $adminData = $mailData;
            $adminData['subject'] = "Order for $business->name has been picked up by " . auth()->user()->first_name;;
            $adminData['message'] = $order->user->first_name . " we see that the order is being processed";
            $adminData['message_line2'] = "Please ensure it's delivered between the " . $duration . "mins time stipluated";
            $adminData['recipient'] = $admin->name;
            $adminData['recipient_email'] = $admin->email;
            $adminData['recipient_phone'] = $admin->telephone;

            Mail::to($admin->email)->send(new AdminOrderPaid($adminData));

            $data['pickup_timestamp'] = now();
        }

        if ($status == 'delivered') {
            //send notifications to Admin
            $orderItems = OrderItems::whereId($id)->get();
            $order = Orders::with('user')->whereId($orderItems[0]->order_id)->first();
            $business = Business::whereId($orderItems[0]->business_id)->first();
            $admin = User::role('super-admin')->first();
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
            $userData['subject'] = "Your Order Has been Delivered";
            $userData['message'] = $order->user->first_name . ", your order has been Delivered";
            $userData['message_line2'] = "Your order has been Delivered";
            $userData['recipient'] = $order->user->first_name;
            $userData['recipient_email'] = $order->user->email;
            $userData['recipient_phone'] = $order->user->telephone;

            Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


            $merchantData = $mailData;
            $merchantData['subject'] = "Order has been Delivered by " . auth()->user()->first_name;
            $merchantData['message'] = $business->name . " we see that the order has been delivered";
            $merchantData['message_line2'] = "";
            $merchantData['recipient'] = $business->name;
            $merchantData['recipient_email'] = $business->email;
            $merchantData['recipient_phone'] = $business->telephone;

            Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

            $adminData = $mailData;
            $adminData['subject'] = "Order for $business->name has been delivered by " . auth()->user()->first_name;;
            $adminData['message'] = $order->user->first_name . " we see that the order is being processed";
            $adminData['message_line2'] = "Please ensure it's delivered between the " . $duration . "mins time stipluated";
            $adminData['recipient'] = $admin->name;
            $adminData['recipient_email'] = $admin->email;
            $adminData['recipient_phone'] = $admin->telephone;

            Mail::to($admin->email)->send(new AdminOrderPaid($adminData));

            $data['delivery_timestamp'] = now();
        }
        OrderItems::where('id', $id)->update($data);

        return redirect()->back()->with([
            'message'    => 'Order has been updated successfully!',
            'alert-type' => 'success',
        ]);
    }
}
