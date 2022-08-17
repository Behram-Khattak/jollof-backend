<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Flutterwave as ModalFlutterwave;
use App\Models\layaway;
use App\Models\LayawaySetting;
use App\Models\OrderItems;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\Orders;
use App\Models\Review;
use App\Models\Shipping;
use Auth;
use Carbon\Carbon;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function myaccount()
    {
        $categories = array();
        $business = array();
        $orders = Orders::where('user_id', '=', auth()->user()->id)->where('status','=','paid')->count();
        $reviews = Review::where('user_id', '=', auth()->user()->id)->count();
        $layaways = layaway::where('user_id', '=', auth()->user()->id)->where('completed', '=', false)->count();
        $vendors = OrderItems::whereHas('order', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['business','order'])->count();
        return view('user.myaccount', compact(['categories', 'business','orders','reviews','layaways','vendors']));
    }

    public function order()
    {
        $this->deleteUnpaidOrders();
        $orders = Orders::with('items')->where(['user_id' => Auth::id(),'status' => 'paid'])->orderBy('id', 'desc')->paginate(7);
        $wishlist = [];

        return view('user.orders.list', compact(['orders', 'wishlist']));
    }

    public function orderdetails($code)
    {
        $order = Orders::where('user_id', Auth::id())->where('order_code', $code)->first();
        $orderItems = $order->items()->get();
        // dd($order);
        $shipping = Shipping::where('id', $order->shipping_id)->first();

        return view('user.orders.details', compact(['order', 'orderItems', 'shipping']));
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

    public function referafriend()
    {
        return view("user.refer.referFriend");
    }

    public function vendors()
    {
        $orders = OrderItems::whereHas('order', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['business','order'])->take(10)->get();
        return view('user.vendors.index', compact(['orders']));
    }

    public function reviews()
    {
        $reviews = Review::with('order')->where('user_id', Auth::id())->latest()->take(5)->get();
        return view('user.reviews.index', compact('reviews'));
    }

    public function layaway()
    {
        $layaways = layaway::where([
            ['user_id', '=', Auth::id()],
            ['balance', '>', 0],
            ['expire_date', '>', Carbon::now()],
            ])->with('product')->orderBy('created_at', 'desc')->limit(7)->get();
        // return $layaways;
        return view('user.layaways.list', compact(['layaways']));
    }

    public function layawaytopform($order_code)
    {
        $order = Orders::where('order_code', $order_code)->first();
        $layaway = layaway::with('product')->where('order_code', $order_code)->first();
        $layawaysettings = LayawaySetting::first();
        return view('user.layaways.topupform', compact(['order', 'layaway','layawaysettings']));
    }

    public function layawaytopup(Request $request)
    {
        $layaway = Layaway::with('product')->where('id', $request->layaway_id)->first();
        request()->validate([
            'topup' => 'required',
        ]);
        $data = [
            'amount' => $request->topup,
            'product_id' => $layaway->product->id,
        ];
        // $order_code = uniqid('JOLLOF-');
        $tx_ref = uniqid() . '_' . $layaway->order_code . '_' . time();
        $order = Orders::with('user')->where('order_code', $layaway->order_code)->first();
        
        //create if not in DB
        $paystack = new ModalFlutterwave();
        $paystack->order_code = $layaway->order_code;
        $paystack->email = $order->user->email;
        $paystack->amount = $request->topup;
        $paystack->reference = $tx_ref;
        $paystack->save();
        // dd($paystack);


        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $request->topup,
            'email' => $order->user->email,
            'tx_ref' => $tx_ref,
            'currency' => "NGN",
            'redirect_url' => route('layaway.topup.callback', $layaway->order_code),
            'customer' => [
                'email' => $order->user->email,
                "phone_number" => $order->user->telephone,
                "name" => $order->user->last_name . $order->user->first_name,
            ],

            "customizations" => [
                "title" => 'Layaway top-up Payment for '. $layaway->product->name,
                "description" => "Jollof Layaway"
            ]
        ];
        $payment = Flutterwave::initializePayment($data);
        // ::initializePayment($data);
        // dd($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return "Something went wrong!!!";
        }

        return redirect($payment['data']['link']);

        // // dd($tx_ref);
        
        // $order = Orders::where('order_code', $data['order_code'])->first();
        // $layaway = layaway::with('product')->where('order_code', $data['order_code'])->first();
        // // $layaway->amount = $layaway->amount + $data['amount'];
        // // $layaway->save();
        // // $order->status = 'paid';
        // // $order->save();
        // $layaway->update([
        //     'amount' => $layaway->balance + $data['amount'],
        // ]);
        // $order->update([
        //     'status' => 'paid',
        // ]);
        // return redirect()->route('layaway')->with('success', 'Layaway Topup Successful');
    }

    public function layawaytopupcallback($order_code)
    {
        $status = request()->status;
        // return $status;
        if ($status ==  'successful') {
            
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);
            // return $data;
            // $product = FashionProduct::where('id',$data['customer']['product_id'])->first();
            $order = Orders::with('product')->where('order_code', $order_code)->first();
            $layaway = layaway::with('product')->where('order_code', $order_code)->first();
            // return $layaway;
            $balance = $layaway->balance - $data['data']['amount'];
            // return $balance;
            // dd($data['data']['amount']);

            // get status from data
            // get layaway settings

            // $layawaysettings = LayawaySetting::first();
            $layaway->update([
                'balance' => $balance,
                'amount_paid' => $layaway->amount_paid + $data['data']['amount'],
            ]);
            // $layaway->balance = $balance;
            // $layaway->amount_paid = $layaway->amount_paid + $data['data']['amount'];
            // $layaway->save();
            if($balance == 0) 
            {
                $layaway->update([
                    'completed' => true,
                ]);
                // $layaway->completed = true;
                // $layaway->save();
                if($layaway->product->sales_price <= 0){
                    $price = $layaway->product->price;
                }
                else{
                    $price = $layaway->product->sales_price;
                }
                $order->update([
                    'status' => 'paid',
                    'subtotal' =>  $price,
                ]);
                // dd($order);
                // $order->status = 'paid';
                // $order->subtotal = $layaway->product->sales_price;
                // $order->save();

                // Place the order
                OrderItems::create([
                    'order_id'    => $order->id,
                    'business_id' => $order->product->business_id,
                    'name'        => $order->product->name,
                    'description' => $order->product->description,
                    'quantity'    => $order->product->quantity,
                    'unit_price'  => $order->product->price,
                    'total_price' => $order->product->quantity *  $order->product->price,
                    'preorder'    => ( $order->product->preorder) ?  $order->product->preorder : 0,
                    'delivery_on' => ( $order->product->delivery_on) ?  $order->product->delivery_on : null,
                    'img'         =>  $order->product->imgurl,
                    'model'       =>  $order->product->microsite ?? 'fashion',
                    'model_id'    =>  $order->product->product_id,
                    'status'      => 'pending',
                ]);
            return redirect()->action('User\HomeController@index')->with('success', 'You have successfully topped-up this layaway item.');
            }
            return redirect()->action('User\HomeController@index')->with('success', 'You have successfully topped-up this layaway item.');
        }
        elseif($status == 'cancelled')
        {
            return redirect()->action('User\HomeController@index')->with('error', 'You have cancelled the layaway topup.');
        }
        else
        {
            return redirect()->action('User\HomeController@index')->with('error', 'Something went wrong. Try again later');
        }
    }

    public function extendLayaway($layaway_id,$weeks)
    {
        $layaway = layaway::where('id',$layaway_id)->first();
        $newdate = Carbon::parse($layaway->expire_date)->addWeeks($weeks)->format('Y-m-d');
        $layaway->expire_date = $newdate;
        $layaway->extension_used = $layaway->extension_used + 1;
        $layaway->date_extended = now();
        if(!$layaway->save() == true){
            return ['error'];
        }
        return ['success'];
    }

    public function profile()
    {
        $user = Auth::user();
        // return view('')
        return view('user.settings.profile')->with('user', $user);
    }
}
