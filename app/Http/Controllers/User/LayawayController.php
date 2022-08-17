<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\layaway;
use App\Models\Category;
use App\Models\FashionProduct;
use App\Models\FashionProductSizeValue;
use App\Models\Flutterwave as Modelflutterwave;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\LayawaySetting;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Shipping;
use Carbon\Carbon;
use ourcodeworld\NameThatColor\ColorInterpreter;
use Illuminate\Http\Request;

class LayawayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('childrenCategories')->get();
        $recommended = FashionProduct::with('media')->latest()->take(4)->get();
        $layaways = FashionProduct::with('media')->where('is_layaway',true)->latest()->paginate(12);
        // dd($layaways);
        return view('user.fashion.layaway.index', compact('layaways','categories','recommended'));

    }

    public function show($slug)
    {
        $product = FashionProduct::where('slug',$slug)->first();
        $business = Business::with('media')->where('id', $product->business_id)->first();
        $categories = Category::whereNull('parent_id')->with('childrenCategories')->get();
        $recommended = FashionProduct::with('media')->latest()->take(4)->get();
        $settings = LayawaySetting::first();
        $decodedSize = json_decode($product->size_value_id);
        if(gettype($decodedSize) == 'integer')
        {
            $sizes =FashionProductSizeValue::whereid($product->size_value_id)->pluck('name')->toArray();
            // dd('Integer');
        }
        elseif(gettype($decodedSize) == 'array')
        {
            $sizes = $decodedSize;
        }

        $colors = json_decode($product->color_id) ?? str_split($product->color_id,7);
        $color_by_name = [];
        foreach($colors as $color)
        {
            $instance = new ColorInterpreter();
            $result = $instance->name($color);
            $color_by_name[] = $result['name'];
        }
        $product->color_id = $colors;
        
        $layaway = layaway::where([
            'product_id' => $product->id,
            'user_id' => auth()->user()->id
        ])->first();
        return view('user.fashion.layaway.show', compact('product','categories','recommended','layaway','settings','business','sizes'));
    }

    public function pay(Request $request)
    {
        // dd($request->all());
        $product = FashionProduct::where('id',$request->product_id)->first();
        if($product->sales_price <= 0) {
            $price = $product->price;
        }
        else{
            $price = $product->sales_price;
        }
        $order_code = uniqid('JOLLOF-');
        $order_array = [
            'user_id'     => auth()->user()->id,
            'order_code'  => $order_code,
            'product_id'  => $request->product_id,
            // 'shipping_id' => $shipping->id,
            'subtotal'    => 0,
            'total'       => $price,
            'status'      => 'layaway',
        ];
        //add orders array to db
        $order = Orders::create($order_array);
        $product = FashionProduct::where('id',$request->product_id)->first();
        // $reference = Flutterwave::generateReference();
        $tx_ref = uniqid() . '_' . $order_code . '_' . time();
        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $trn = Modelflutterwave::where('order_code', $order_code)->first();
        // Save shipping details 
        $shipping = Shipping::create([
            'user_id' => auth()->user()->id,
            'order_id' => $order->id,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'state' => $request->state,
            'city' => $request->city,
        ]);

        // dd($shipping->id);

        // update order shipping id
        $order->shipping_id = $shipping->id;
        $order->save();
        // return [$order, $shipping];
        // Layaway order summary

        if ($trn) {
            //update if exist in DB
            $trn->reference = $tx_ref;
            $trn->save();
        } else {
            //create if not in DB
            $paystack = new Modelflutterwave();
            $paystack->order_code = $order_code;
            $paystack->email = $order->user->email;
            $paystack->amount = $request->amount;
            $paystack->reference = $tx_ref;
            $paystack->save();
            // dd($paystack);
        }
        
        // redirect to pay method in cartcontroller
        // return redirect()->action([CartController::class,'pay'],$order_code);

        // Enter the details of the payment

        // $paymentData = [
        //     'tx_ref'          => $tx_ref,
        //     'amount'          => $request->amount,
        //     'currency'        => 'NGN',
        //     'redirect_url'    => route('layaway.callback'),
        //     'payment_options' => 'card',
        //     'meta'            => [
        //         'consumer_id'  => $order->user->id,
        //         'consumer_mac' => '92a3-912ba-1192a',
        //     ],
        //     'customer' => [
        //         'email'       => $order->user->email,
        //         'phonenumber' => $order->user->telephone,
        //         'name'        => $order->user->first_name . ' ' . $order->user->last_name,
        //     ],
        //     'customizations' => [
        //         'title'       => 'Jollof',
        //         'description' => 'Layaway Payment for '. $product->name,
        //         'logo'        => 'https://assets.piedpiper.com/logo.png',
        //     ],
        // ];
        // // dd($paymentData);
        // $curl = curl_init();

        // curl_setopt_array($curl, [
        //     CURLOPT_URL            => 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING       => '',
        //     CURLOPT_MAXREDIRS      => 10,
        //     CURLOPT_TIMEOUT        => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST  => 'POST',
        //     CURLOPT_POSTFIELDS     => json_encode($paymentData),
        //     CURLOPT_HTTPHEADER     => [
        //         'Authorization: Bearer FLWSECK_TEST-42133f3727f55afbf794f0664625ab31-X',
        //         'Content-Type: application/json',
        //     ],
        // ]);

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $process = json_decode($response);

        // dd($process);
        $data = [
            'payment_options' => 'card,banktransfer,ussd',
            'amount' => $request->amount,
            'email' => request()->email,
            'tx_ref' => $tx_ref,
            'currency' => "NGN",
            'redirect_url' => route('layaway.callback', $order_code),
            'customer' => [
                'email' => $order->user->email,
                "phone_number" => $order->user->telephone,
                "name" => $order->user->last_name . $order->user->first_name,
            ],

            "customizations" => [
                "title" => 'Layaway Payment for '. $product->name,
                "description" => "Jollof Layaway"
            ]
        ];
        $payment = Flutterwave::initializePayment($data);
        // dd($payment);
        // ::initializePayment($data);
        // dd($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            abort(401);
            // return "Something went wrong!!!";
        }

        return redirect($payment['data']['link']);

        // dd($tx_ref);
        
    }

    public function callback($order_code)
    {
        $status = request()->status;
        // dd(request()->all());
        //if payment is successful
        if ($status ==  'successful') {
            
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);
            // $product = FashionProduct::where('id',$data['customer']['product_id'])->first();
            $order = Orders::with('product')->where('order_code', $order_code)->first();
            if($order->product->sales_price <= 0){
                $price = $order->product->price;
            }
            else{
                $price = $order->product->sales_price;
            }
            $balance = $price - $data['data']['amount'];
            // $balance = $order->product->sales_price - $data['data']['amount'];
            // dd($balance);
            // dd($data['data']['amount']);

            // get status from data
            // get layaway settings

            $layawaysettings = LayawaySetting::first();

                $layaway = Layaway::create([
                    'order_code' => $order_code,
                    'product_id' => $order->product->id,
                    'user_id' => auth()->user()->id,
                    'amount_paid' => $data['data']['amount'],
                    'expire_date' => Carbon::now()->addWeeks($layawaysettings->period),
                    'balance' => $balance,
                ]);
                $product = FashionProduct::where('id',$order->product->id)->first();
                $product->quantity = $product->quantity - 1;
                $product->save();
                // if($balance == 0) 
                // {
                //     $layaway->completed = true;
                //     $layaway->save();

                //     // Place the order
                //     OrderItems::create([
                //         'order_id'    => $order->id,
                //         'business_id' => $order->product->business_id,
                //         'name'        => $order->product->name,
                //         'description' => $order->product->description,
                //         'quantity'    => $order->product->quantity,
                //         'unit_price'  => $order->product->price,
                //         'total_price' => $order->product->quantity *  $order->product->price,
                //         'preorder'    => ( $order->product->preorder) ?  $order->product->preorder : 0,
                //         'delivery_on' => ( $order->product->delivery_on) ?  $order->product->delivery_on : null,
                //         'img'         =>  $order->product->imgurl,
                //         'model'       =>  $order->product->microsite,
                //         'model_id'    =>  $order->product->product_id,
                //         'status'      => 'pending',
                //     ]);
                // }
                return redirect('fashion/layaway')->with('success', 'You have successfully layaway this item.');
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
            return redirect('fashion/layaway')->with('error', 'Transaction was cancelled');
        }
        else{
            //Put desired action/code after transaction has failed here
            return redirect('fashion/layaway')->with('error', 'Transaction failed, try again later');
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }
}
