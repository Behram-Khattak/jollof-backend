<?php

namespace App\Http\Controllers\User;

use App\Enums\DefaultRoles;
use App\Http\Controllers\Controller;
use App\Mail\AdminOrderpaid;
use App\Mail\PayForMe;
use App\Models\Areas;
use App\Models\Business;
use App\Models\CuisineMenus;
use App\Models\Flutterwave;
use App\Models\PaystackPayment;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Restaurant;
use App\Models\Shipping;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Mail\GuestWelcome;
use App\Services\GuzzleService;
use Auth;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Coupon;
use App\Models\FashionProduct;
use App\Models\JollofPointSetting;
use App\Models\ShippingAddress;
use App\Models\ShippingGroup;
use App\Models\States;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Log as GlobalLog;
use Redirect;
use Paystack;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(GuzzleService $guzzleClient)
    {
        $this->guzzle = $guzzleClient;
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function getToppings($id)
    {
        $menu = CuisineMenus::whereId($id)->first();
        $restaurant = $menu->restaurant;
        $toppings = $menu->extra;
        return view('cart.toppings', compact(['menu', 'toppings', 'restaurant']));
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function getCart()
    {
        $cartItems = $this->groupCart();
        $cartSubTotal = Cart::getSubTotal();
        $cartTotal = Cart::getTotal();
        $conditions = Cart::getConditions();
        $shippingCost = Cart::getCondition('Shipping/Delivery Cost');
        $vat = Cart::getCondition('Value Added Tax');
        return view('cart.show', compact(['cartItems', 'cartSubTotal', 'cartTotal', 'conditions', 'shippingCost', 'vat']));
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function addCart($id)
    {
        Cart::update($id, [
            'quantity' => 1
        ]);

        //return message
        $cart = Cart::getContent();
        $cart['message'] = 'Cart item added successfully';
        $cart['items']   = Cart::getTotalQuantity();

        return $cart;
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function postCart(Request $request)
    {
        if($request->microsite == 'cuisine' && $request->preorder == 1){
            if($request->preorder && $request->delivery_on == null){
                return redirect(url()->previous())->with('error', 'Oops!!! Please select delivery date and time');
            }
            // return $request->delivery_on;
            // get day from date
            $menu = CuisineMenus::whereId($request->productID)->first();
            $restaurant = $menu->restaurant;
            $hours = json_decode($restaurant->hours, true);
            $deliveryDay = Carbon::parse($request->delivery_on)->format('l');
            // check is restaurant is open on that day
            if($hours['status'][$deliveryDay] == '0'){
                return redirect(url()->previous())->with('error', 'Oops!!! Restaurant is not open on '.$deliveryDay);
            }
            $openHour = explode(':', $hours[$deliveryDay][0])[0];
            $closeHour = explode(':', $hours[$deliveryDay][1])[0];
            $deliveryTime = explode(' ', $request->delivery_on)[1];
            $deliveryHour = explode(':', $deliveryTime)[0];
            // check if restaurant is open at that time
            if($deliveryHour < $openHour || $deliveryHour > $closeHour){
                return redirect(url()->previous())->with('error', 'Oops!!! Restaurant is not open at '.$deliveryTime);
            }
            // return $deliveryHour;

            // return [$deliveryHour, $openHour];
            // $deliveryDay = Carbon::parse($request->delivery_on)->format('l');
            // if($today == $deliveryDay && $deliveryHour <= $openHours[0]){
            //     return redirect(url()->previous())->with('error', 'Please pick a different date and time as restaurant would not be open at that time. Pick between '.$openHours[0].' and '.$openHours[1]);
            // }
            // if($today == $deliveryDay && $deliveryHour >= $openHours[1]){
            //     return redirect(url()->previous())->with('error', 'Please pick a different date and time as restaurant would not be open at that time. Pick between '.$openHours[0].' and '.$openHours[1]);
            // }
        }
        // if ($request->preorder && $request->delivery_on == null) {
        //     return redirect(url()->previous())->with('error', 'Oops!!! Please select delivery date and time');
        // }
        // validate delivery on is 3 hours from delivery day
        if ($request->delivery_on) {
            $delivery_on = Carbon::parse($request->delivery_on);
            $now = Carbon::now();
            $diff = $delivery_on->diffInHours($now);
            if ($diff < 3) {
                return redirect(url()->previous())->with('error', 'Oops!!! Please select delivery date and time at least 3 hours from now');
            }
        }
        $data = $request->input();
        $addMainMenu = (isset($data['addmainmenu'])) ? 1 : 0;
        $product_id = $data['productID'];
        $business_id = $data['businessID'];
        $menu_id = $data['menuid'];
        $microsite = $data['microsite'];
        $preorder = (isset($data['preorder'])) ? $data['preorder'] : 0;
        $delivery = ($data['delivery_on'] == 'null') ?  null : $data['delivery_on'];
        unset($data['_token'], $data['productID'], $data['businessID'], $data['microsite'],  $data['menuid'], $data['addmainmenu'], $data['preorder'], $data['delivery_on']);

        //get business details
        $business = Business::findorfail($business_id);

        //get product details
        $menu = ($addMainMenu) ? CuisineMenus::whereId($product_id)->first() : 0;
        if (empty($data) && !$menu) {
            return redirect(url()->previous())->with('error', 'Oops!!! No menu item was selected');
        }

        $toppings_cost = 0;
        $topping_string = '';
        //calculate toppings and make string for attribute
        foreach ($data as $item => $cost) {
            $toppings_cost += $cost;
            $topping_string .= $item . ' - N' . $cost . ', ';
        }

        if ($addMainMenu) {
            $today = Carbon::today();
            if ($menu->sales_start != null && $menu->end_sales != null || $menu->type == 'PROMO') {
                $start_sales = Carbon::parse($menu->sales_start) ?? null;
                $end_sales = Carbon::parse($menu->sales_end) ?? null;
                $price = (now()->between(now()->parse($start_sales), now()->parse($end_sales))) ? $menu->sales_price : $menu->price;
            } else {
                $price = $menu->price;
            }
            //($start_sales->lte($today) && $end_sales->gte($today)) ? $menu->sales_price : $menu->price;
            $total_price = $price + $toppings_cost;
        } else {
            $total_price = $toppings_cost;
        }
        $toppings = ($topping_string) ? rtrim($topping_string, ', ') : '';

        if (!empty($menu_id)) {
            Cart::remove($menu_id);
        }

        Cart::add([
            'id'         => (empty($menu_id)) ? uniqid() : $menu_id,
            'name'       => ($addMainMenu) ? $menu->menu : 'Extras',
            'price'      => $total_price,
            'quantity'   => 1,
            'attributes' => [
                'imgurl'      => ($addMainMenu) ? $menu->getFirstMediaUrl('menu') : env('APP_URL') . "/images/extras.jpg",
                'business_id' => $business_id,
                'merchant' => $business->name,
                'menu_id' => ($addMainMenu) ? $menu->id : 0,
                'main_price' => ($addMainMenu) ? $price : $total_price,
                'toppings'    => $toppings,
                'topping_price' => $toppings_cost,
                'microsite'    => $microsite,
                'preorder'    => $preorder,
                'delivery_on'    => ($delivery) ? date('Y-m-d H:i', strtotime($delivery)) : null,
            ],
        ]);

        //return message
        $cart = Cart::getContent();
        $cart['message'] = 'Cart item added successfully';
        $cart['items']   = Cart::getTotalQuantity();

        return redirect(url()->previous())->with('success', 'Cart item updated successfully');
    }

    /**
     * remove cart.
     *
     * @param mixed $id
     */
    public function reduceCart($id)
    {
        $cart = Cart::get($id);
        if (!$cart) {
            return ['message' => 'No Item in cart'];
        }

        if ($cart->quantity == 1) {
            Cart::remove($id);
        } else {
            Cart::update($id, [
                'quantity' => -1,
            ]);
        }

        //return message
        $cart = Cart::getContent();
        $cart['message'] = 'CartItem reduced successfully';
        $cart['items']   = Cart::getTotalQuantity();

        return $cart;
    }

    public function updateCart(Request $request)
    {
        $quantity = $request->input('quantity');
        if (isset($quantity)) {
            $id = $request->input('id');
            $qty = $request->input('quantity');
            for ($i = 0; $i < count($id); $i++) {
                Cart::update($id[$i], [
                    'quantity' => array(
                        'relative' => false,
                        'value' => $qty[$i]
                    )
                ]);
            }
        }

        Cart::removeConditionsByType("VAT");
        Cart::removeConditionsByType("shipping");

        return redirect(url()->previous())->with('success', 'Cart item updated successfully');
    }




    /**
     * remove cart.
     *
     * @param mixed $id
     */
    public function removeCart($id)
    {
        Cart::remove($id);

        //return message
        $cart = Cart::getContent();
        $cart['message'] = 'CartItem removed from cart successfully';
        $cart['items']   = Cart::getTotalQuantity();

        return $cart;
    }

    /**
     * Checkout.
     */
    public function checkout()
    {
        if (Auth::check()) {
            return redirect()->route('cart.shipping.review');
        }

        $cartCollection = Cart::getContent();
        $cartItems = $cartCollection;

        $cartSubTotal = Cart::getSubTotal();
        $cartTotal = Cart::getTotal();

        return view('cart.checkout', compact(['cartItems', 'cartSubTotal', 'cartTotal']));
    }

    /**
     * Checkout.
     */
    public function checkout_review()
    {
        $this->checkMinOrder();

        Cart::removeConditionsByType("VAT");
        Cart::removeConditionsByType("shipping");

        $cartItems = Cart::getContent();

        $cartSubTotal = Cart::getSubTotal();
        $cartTotal = Cart::getTotal();

        return view('cart.checkoutReview', compact(['cartItems', 'cartSubTotal', 'cartTotal']));
    }

    public function shipping_review()
    {
        //check if cart is empty
        if (Cart::getContent()->isEmpty()) {
            return redirect()->route('index');
        }

        $this->checkMinOrder();

        Cart::removeConditionsByType("VAT");
        Cart::removeConditionsByType("shipping");

        $groupCart = $this->groupCart();
        $type = 'home'; //default
        if (Auth::user()) {

            $user = User::with('shippingAddress')->whereId(Auth::id())->first();
            $shipping = $this->shippingArray($user->shippingAddress);
            // return $shipping;
            //dd($this->groupCart());
            //Checking if shipping added
            $hasShipping = Cart::getCondition('Shipping/Dilivery Cost');
            // return $shipping;
            // return $hasShipping;
            if (!$hasShipping && !empty($shipping)) {
                $type = array_keys($shipping)[count($shipping) - 1];
                $groupship = 0;

                $shippingCost = ShippingGroup::where('state_id', $shipping[$type]['stateId'])->where('area_id', $shipping[$type]['cityId'])->first();
                // return $shippingCost;
                $totalShippingCost = 0;

                for ($i = 0; $i < count($groupCart); $i++) {
                    if ($shippingCost) {
                        //$cartQty = Cart::getTotalQuantity();
                        $tsCost = $groupship + $shippingCost->shipment_price; //($cartQty / $shippingCost->max_shipment_qty) *
                    } else {
                        $tsCost = $groupship + 1000;
                    }

                    $totalShippingCost = $totalShippingCost + $tsCost;
                }

                //add shipping cost to cart
                $condition = new CartCondition(array(
                    'name' => 'Shipping/Delivery Cost',
                    'type' => 'shipping',
                    'target' => 'total',
                    'value' => $totalShippingCost,
                    'order' => 1,
                    'attributes' => array( // attributes field is optional
                        'address' => $shipping[$type]['address'],
                        'city' => $shipping[$type]['city'],
                        'state' => $shipping[$type]['state'],

                    )
                ));
                Cart::condition($condition);
            }
        } else {
            $user = null;
            $shipping = null;
        }

        // return 'test';
        //add shipping cost to cart
        $subtotal = Cart::getSubTotal();
        $condition = new CartCondition(array(
            'name' => 'Value Added Tax',
            'type' => 'VAT',
            'target' => 'total',
            'value' => $subtotal * 0.075,
            'order' => 1
        ));
        Cart::condition($condition);

        $cartItems = $groupCart;
        $cartSubTotal = Cart::getSubTotal();
        $cartTotal = Cart::getTotal();
        $conditions = Cart::getConditions();
        $shippingCost = Cart::getCondition('Shipping/Delivery Cost');
        $vat = Cart::getCondition('Value Added Tax');
        $shipping = $shipping[$type] ?? [];

        return view('cart.shipping', compact(['cartItems', 'cartSubTotal', 'cartTotal', 'user', 'shipping', 'conditions', 'shippingCost', 'vat']));
    }

    public function getShippingCost(Request $request)
    {
        $input = $request->all();

        $area = Areas::whereArea($input['area'])->first();
        $state = States::whereState($input['state'])->first();

        $groupCart = $this->groupCart();

        $shippingCost = ShippingGroup::where('state_id', $state->id)->where('area_id', $area->id)->first();

        $totalShippingCost = 0;
        $groupship = 0;

        foreach ($groupCart as $bizCart) {
            if ($shippingCost) {

                $cartQty = count($bizCart);
                $shipmentCount = ceil($cartQty / $shippingCost->max_shipment_qty);
                $tsCost = $groupship + ($shippingCost->shipment_price * $shipmentCount);
            } else {
                $tsCost = $groupship + 1000;
            }

            $totalShippingCost = $totalShippingCost + $tsCost;
        }

        //add shipping cost to cart
        $condition = new CartCondition([
            'name' => 'Shipping/Delivery Cost',
            'type' => 'shipping',
            'target' => 'total',
            'value' => $totalShippingCost,
            'order' => 1,
            'attributes' => array(
                'address' => '',
                'city' => $area->area,
                'state' => $state->state,

            )
        ]);
        Cart::condition($condition);

        $shipArray = [
            'name' => 'Shipping/Delivery Cost',
            'city' => $area->area,
            'state' => $state->state,
            'value' => $totalShippingCost,
            'cartTotal' => Cart::getTotal()
        ];

        return response()->json(['status' => 'success', 'shipment' => $shipArray]);
    }

    public function place_order(Request $request)
    {
        // dd($request->all());
        //check if cart is empty
        if (Cart::getContent()->isEmpty()) {
            return redirect()->route('index');
        }

        // Validate
        $data = $this->validateShipping();

        // Start transaction!
        //DB::beginTransaction();
        $isNewUser = 0;
        $user_id = $data['user_id'];
        if (!$user_id) {
            if ($request->filled('phone')) {
                $telephone = phone($data['phone'], 'NG')->formatE164();
            }

            if ($isRegistered = User::whereEmail($data['email'])->first()) {
                $user_id = $isRegistered->id;
            } elseif ($isRegistered = User::whereTelephone($telephone)->first()) {
                $user_id = $isRegistered->id;
            } else {
                //$request->validateNewUser();
                $username = $data['first_name'] . Str::random(5);
                $password = Str::random(12);
                $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                    'username'   => $username,
                    'address'    => $data['address'],
                    'telephone'  => $telephone,
                    'email'      => $data['email'],
                    'password'   => Hash::make($password),
                ]);

                $user_id = $user->id;

                // Assign role to user here
                $user->assignRole(DefaultRoles::USER);
                $isNewUser = 1;
            }
        }

        //create array for shipping
        $shipping_array = [
            'user_id'    => $user_id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'address'    => $data['address'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'city'       => $data['city'],
            'state'      => $data['state'],
        ];

        //add shipping address to db
        $shipping = Shipping::create($shipping_array);

        //add order items
        $orderItems = Cart::getContent();

        //create orders array
        $order_code = uniqid('JOLLOF-');
        $order_array = [
            'user_id'     => $user_id,
            'order_code'  => $order_code,
            'shipping_id' => $shipping->id,
            'subtotal'    => Cart::getSubTotal(),
            'total'       => Cart::getTotal(),
            'status'      => 'new',
            'product_id' => 0,
        ];
        // dd($order_array);
        //add orders array to db
        $order = Orders::create($order_array);

        //Add order ID to shipping
        $shipping->order_id = $order->id;
        $shipping->save();

        // return $orderItems;
        $couponPrice = 0;
        $couponValue = 0;
        foreach ($orderItems as $item) {
            if (!empty($item['conditions'])) {
                foreach ($item['conditions'] as $condition) {
                    $code = explode('-', $condition->getName())[1];
                    $coupon = Coupon::whereCode($code)->firstOrFail();
                    $couponValue = $coupon->percentage;
                    $couponPrice = $item->price - $order->subtotal;
                }
            }

            OrderItems::create([
                'order_id'    => $order->id,
                'business_id' => $item->attributes->business_id,
                'name'        => $item->name,
                'description' => $item->attributes->toppings,
                'quantity'    => $item->quantity,
                'size'        => $item->attributes->size,
                'unit_price'  => $item->price,
                'total_price' => $item->quantity * $item->price,
                'preorder'    => ($item->attributes->preorder) ? $item->attributes->preorder : 0,
                'delivery_on' => ($item->attributes->delivery_on) ? $item->attributes->delivery_on : null,
                'img'         => $item->attributes->imgurl,
                'model'       => $item->attributes->microsite,
                'model_id'    => $item->attributes->product_id,
                'status'      => 'pending',
            ]);
        }
        $order->coupon_deduction = $couponPrice;
        $order->coupon_value = $couponValue;
        $order->save();

        //add/update user's shipping address
        $addressType = $data['addresstype'];
        if ($addressType !== "other") {
            $hasAddress = ShippingAddress::where("user_id", $user_id)->where("type", $addressType)->first();
            if (!$hasAddress) {
                ShippingAddress::create([
                    'user_id'   => $user_id,
                    'type'      => $addressType,
                    'address'   => $data['address'],
                    'city'      => $data['city'],
                    'state'     => $data['state'],
                ]);
            } else {
                ShippingAddress::where("user_id", $user_id)->where("type", $addressType)->update([
                    'user_id'   => $user_id,
                    'type'      => $addressType,
                    'address'   => $data['address'],
                    'city'      => $data['city'],
                    'state'     => $data['state'],
                ]);
            }
        }

        if ($isNewUser) {
            //send welcome email
            $data['password'] = $password;
            Mail::to($data['email'])->send(new GuestWelcome($data));
        }

        //redirect to payment
        return redirect()->route('cart.order.summary', ['code' => $order_code]);
    }

    /**
     * Prepare paystack payment link.
     *
     * @param Type  $var        Description
     * @param mixed $order_code
     *
     * @throws conditon
     *
     * @return type
     */
    public function summary($order_code)
    {
        // dd('here');
        // try {
        //     return Paystack::getAuthorizationUrl()->redirectNow();
        // } catch (\Exception $e) {
        //     return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        // }
        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $orderItems = $order->items()->get();
        $shipping = Shipping::where('id', $order->shipping_id)->first();
        $tx_ref = uniqid() . '_' . $order_code . '_' . time();

        $trn = Flutterwave::where('order_code', $order_code)->first();
        if ($trn) {
            //update if exist in DB
            $trn->reference = $tx_ref;
            $trn->save();
        } else {
            //create if not in DB
            $paystack = new Flutterwave();
            $paystack->order_code = $order_code;
            $paystack->email = $order->user->email;
            $paystack->amount = $order->total;
            $paystack->reference = $tx_ref;
            $paystack->save();
        }

        return view('cart.summary', compact(['order', 'orderItems', 'shipping', 'tx_ref']));
    }

    /**
     * Prepare paystack payment link.
     *
     * @param Type  $var        Description
     * @param mixed $order_code
     *
     * @throws conditon
     *
     * @return type
     */
    public function pay($order_code)
    {
        //get application details
        $order = Orders::with('user')->where('order_code', $order_code)->first();

        //build json data for flutter
        $tx_ref = uniqid() . '_' . $order_code . '_' . time();
        $paymentData = [
            'tx_ref'          => $tx_ref,
            'amount'          => $order->total,
            'currency'        => 'NGN',
            'redirect_url'    => 'http://jollof.test/cart/order/completed/' . $tx_ref,
            'payment_options' => 'card',
            'meta'            => [
                'consumer_id'  => $order->user,
                'consumer_mac' => '92a3-912ba-1192a',
            ],
            'customer' => [
                'email'       => $order->user->email,
                'phonenumber' => $order->user->phone,
                'name'        => $order->user->first_name . ' ' . $order->user->last_name,
            ],
            'customizations' => [
                'title'       => 'Jollof',
                'description' => "Middleout isn't free. Pay the price",
                'logo'        => 'https://assets.piedpiper.com/logo.png',
            ],
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($paymentData),
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . env('FLUTTERWAVE_API_SECRET'),
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $process = json_decode($response);

        //generate paystack payment URL
        //$process = $this->guzzle->post("https://api.flutterwave.com/v3/payments", $options);

        if (isset($process->status) && $process->status !== 'error') {
            //check if payment ws done in the past
            $trn = Flutterwave::where('order_code', $order_code)->first();

            if ($trn) {
                //add payment details to database
                $trn->reference = $paymentData['tx_ref'];
                $trn->save();
            } else {
                //add payment details to database
                $paystack = new Flutterwave();
                $paystack->order_code = $order_code;
                $paystack->email = $paymentData['customer']['email'];
                $paystack->amount = $paymentData['amount'];
                $paystack->reference = $paymentData['tx_ref'];
                $paystack->save();
            }

            //redirect to paystack payment page
            return redirect($process->data->link);
        }
        dd($process);
    }


    public function checkOrder($order_code)
    {
        $order = Orders::with('user')->where('order_code', $order_code)->first();
        if ($order->status == 'paid') {
            // Clear Shopping Cart
            Cart::clear();
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }

    public function processing(Request $request, $order_code)
    {
        $tx_ref = $request->query('tx_ref');
        $tx_id = $request->query('transaction_id');
        $status = $request->query('status');
        $flwref = $request->query('flwref');
        $cancelled = $request->query('cancelled');

        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $txn = Flutterwave::where('reference', $tx_ref)->first();

        if ($txn) {
            //add payment details to database
            $txn->flutterwave_reference = $tx_id;
            $txn->save();
        } else {
            //add payment details to database
            $flw = new Flutterwave();
            $flw->order_code = $order_code;
            $flw->email = $order->user->email;
            $flw->amount = $order->total;
            $flw->reference = $tx_ref;

            $flw->save();
        }

        $order = Orders::where('order_code', $order_code)->first();
        // No need querying the database again
        // $txn = Flutterwave::where('reference', $tx_ref)->first();
        if ($status == 'failed') {
            $txn->flutterwave_reference = $tx_id;
            $txn->status = $status;
            $txn->save();

            $order->status = $status;
            $order->save();
        } elseif ($cancelled == 'true') {
            $txn->status = 'cancelled';
            $txn->save();
        } else {
            //verify transaction
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/" . $tx_id . "/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . env('FLUTTERWAVE_API_SECRET')
                ),
            ));

            $jsonResponse = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($jsonResponse);

            if ($response->status == 'success') {
                //updated paid on orders table
                $txn->flutterwave_reference = $flwref;
                $txn->ip_address = $response->data->ip;
                $txn->card_type = $response->data->card->type ?? null;
                $txn->last4 = $response->data->card->last_4digits ?? null;
                $txn->narration = $response->data->narration;
                $txn->status = $response->data->processor_response;
                $txn->expiry = $response->data->card->expiry ?? null;
                $txn->channel = $response->data->payment_type;
                $txn->bank = $response->data->card->issuer ?? null;
                $txn->authorization_code = $response->data->card->token ?? null;
                $txn->raw_response = $jsonResponse;

                $txn->save();

                $order->status = 'paid';
                $order->save();
                // Assign point to user
                // Get points from total orders
                $amount_per_point = JollofPointSetting::first()->amount_per_point;
                $points = round($response->data->amount / $amount_per_point, 1);
                // Check decimal number
                $decimal = explode('.', $points);
                if ($decimal[1] ?? $decimal[0] < 5) {
                    $points = $decimal[0];
                }
                // Get user existing points
                $user = User::where('id', $order->user_id)->first();
                // Add new points to exixting points
                $new_points = $user->points + $points;
                // Update data with new points
                $user->points = $new_points;
                $user->save();
                //update paid_on date on order_items
                $orderItems = OrderItems::where('order_id', $order->id)->get();
                foreach ($orderItems as $oitem) {
                    $oitem->paid_on = now();
                    $oitem->save();

                    if ($oitem->model == 'fashion') {
                        $product = FashionProduct::findorfail($oitem->model_id);
                        $order->product_id = $product->id;
                        $order->save();
                        $product->quantity = ($product->quantity == 0) ? $product->quantity : $product->quantity - $oitem->quantity;
                        $product->save();
                    }
                }

                // Clear Shopping Cart
                Cart::clear();

                //send notifications to Admin
                $order = Orders::with('user')->where('order_code', $order_code)->first();
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
                $userData['subject'] = "Order Placed successfully";
                $userData['message'] = "Your order has been placed";
                $userData['message_line2'] = "";
                $userData['recipient'] = $order->user->first_name;
                $userData['recipient_email'] = $order->user->email;
                $userData['recipient_phone'] = $order->user->telephone;
                //mail user
                Log::info("Logging email");
                Log::info($order->user->email);
                Log::info($business->email);
                Log::info($admin->email);
                Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


                $merchantData = $mailData;
                $merchantData['subject'] = "ORDER:: " . $order->user->first_name . " You have an order from ";
                $merchantData['message'] = "You have an order from " . $order->user->first_name;
                $merchantData['message_line2'] = "Please start processing the order.";
                $merchantData['recipient'] = $business->name;
                $merchantData['recipient_email'] = $business->email;
                $merchantData['recipient_phone'] = $business->telephone;
                //mail merchant
                Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

                $adminData = $mailData;
                $adminData['subject'] = "ORDER - " . $business->name . " An order has been placed on ";
                $adminData['message'] = "An order has been placed on " . $business->name;
                $adminData['message_line2'] = "";
                $adminData['recipient'] = $admin->first_name;
                $adminData['recipient_email'] = $admin->email;
                $adminData['recipient_phone'] = $admin->telephone;
                //mail admin
                Mail::to($admin->email)->send(new AdminOrderPaid($adminData));
            }
        }

        return redirect()->route('cart.order.complete', ['code' => $order_code]);
    }

    public function complete($order_code)
    {
        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $orderItems = $order->items()->get();
        $shipping = Shipping::where('id', $order->shipping_id)->first();

        return view('cart.complete', compact(['order', 'orderItems', 'shipping']));
    }


    public function show()
    {
        $cartCollection = Cart::getContent();
        return view('user.partials._cuisineCart', compact(['cartCollection']));
    }


    public function seemail($order_code)
    {
        return view('emails.base');
        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $orderItems = $order->items()->get();
        $business = Business::where('id', $orderItems[0]->business_id)->first();
        dd($business);
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

        $adminData = $mailData;
        $adminData['message'] = "Your order has been placed";
        $adminData['message_line2'] = "Please start processing the order.";
        $adminData['recipient'] = $order->user->first_name;
        $adminData['recipient_email'] = $order->user->email;
        $adminData['recipient_phone'] = $order->user->telephone;

        Mail::to($order->user->email)->send(new AdminOrderPaid($adminData));
    }

    public function payforme(Request $request)
    {
        if ($request->medium == 'email' && $request->recipient_email == '') {
            return redirect(url()->previous())->with('error', 'You selected medium as email, therefore an email is required');
        }
        $mailData = $request->validate([
            'recipient'       => 'required|max:50',
            'recipient_email' => 'required_if:medium,email|max:255',
            'message'         => 'required|max:255',
            'url'             => 'required|max:255',
            'sender'          => 'required|max:50',
            'sender_email'    => 'required|max:50',
            'medium'            => 'required'
        ]);

        if ($mailData['medium'] == 'whatsapp') {
            $msg = nl2br("Hi " . $mailData['recipient'] . ', ' . $mailData['message'] . ' , ' . "Click on the link to pay for me: " . '  ' . $mailData['url']); //Can't have new lines cos whatsapp api wont accept
            Cart::clear();
            return redirect()->away('https://api.whatsapp.com/send?text=' . $msg);
        } else {
            Mail::to($mailData['recipient_email'])->send(new PayForMe($mailData));
            Cart::clear();
            return redirect(url()->previous())->with('success', 'Your pay for me request has been sent.');
        }
    }

    public function coupon(Request $request)
    {
        $data = $request->input();
        $couponCode = $data["coupon"];
        // dd($couponCode);
        unset($data['_token']);

        $today = date('Y-m-d');

        //check for active coupon for the request
        // $coupon = Coupon::whereCode($couponCode)
        //     ->where('start', '<=', $today)
        //     ->where('expire', '>=', $today)
        //     ->where('status', 'active')
        //     ->where('receivers_email',auth()->user()->email)
        //     ->where('used',false)
        //     ->first();


        /** @var Coupon $coupon */
        $cartItems = Cart::getContent();
        // if($coupon->receivers_email != auth()->user()->email){
        //     return redirect(url()->previous())->with('error', 'You are not allowed to use this coupon');
        // }
        $coupon = Coupon::whereCode($couponCode)
            ->whereUsed(false)
            ->where('start', '<=', $today)
            ->where('expire', '>=', $today)
            ->where('status', 'active')
            ->first();
        //if none, return error
        if (!$coupon) {
            return redirect(url()->previous())->with('error', 'No coupon found for the code');
        }
        if (isset($coupon->min_price)) {
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->price * $item->quantity;
            }
            if ($total < $coupon->min_price) {
                return redirect(url()->previous())->with('error', 'The minimum order amount for this coupon is NGN ' . number_format($coupon->min_price, 2));
            }
        }
        if (isset($coupon->max_price)) {
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->price * $item->quantity;
            }
            if ($total > $coupon->max_price) {
                return redirect(url()->previous())->with('error', 'The maximum order amount for this coupon is NGN ' . number_format($coupon->max_price, 2));
            }
        }

        if ($coupon->type == 'private') {
            if ($coupon->receivers_email != auth()->user()->email) {
                return redirect(url()->previous())->with('error', 'No coupon found for the code');
            } else {
                if ($coupon->remains < 1) {
                    return redirect(url()->previous())->with('error', 'The Coupon has been used up');
                }
            }
        } else {
            if ($coupon->remains < 1 || $coupon->used = 0) {
                return redirect(url()->previous())->with('error', 'The Coupon has been used up');
            }
        }
        //else apply coupon to cart
        $cartArray = $cartItems->toArray();
        foreach ($cartArray as $key => $item) {
            //get spending for cuisine and fashion
            if ($item['attributes']['microsite'] == 'cuisine' || $item['attributes']['microsite'] == 'fashion') {
                // if ($coupon->type == "SPENDING") {
                //     $totalSpending = Cart::getTotal();
                //     if ($totalSpending < $coupon->type_value) {
                //         return redirect(url()->previous())->with('error', 'Your spending is below coupon requirements');
                //     }
                // }

                // if ($coupon->type == "SIGNUP") {
                //     if (Carbon::now()->diffInDays(Auth::user()->created_at) < $coupon->type_value) {
                //         return redirect(url()->previous())->with('error', 'Your signup date does not match coupon requirements');
                //     }
                // }

                // if ($coupon->type == "LOYALTY") {
                //     if (Carbon::now()->diffInDays(Auth::user()->created_at) < $coupon->type_value) {
                //         return redirect(url()->previous())->with('error', 'Your signup date does not match coupon requirements');
                //     }
                // }

                //check if coupon exist
                if (empty($item['conditions'])) {
                    //check type value
                    $itemCondition = new CartCondition([
                        'name' => $coupon->name . '-' . $coupon->code,
                        'type' => 'Coupon',
                        'value' => '-' . $coupon->percentage . '%',
                    ]);

                    Cart::addItemCondition($key, $itemCondition);
                    // Mark the coupon as used
                    $coupon->number_of_uses = $coupon->number_of_uses + 1;
                    $coupon->remains = $coupon->remains - 1;
                    if ($coupon->remains < 1) {
                        $coupon->used = true;
                    }
                    $coupon->save();

                    return redirect(url()->previous())->with('success', 'Coupon added successfully');
                    // $cartArray = [
                    //     'status' => 'success',
                    //     'message' => 'Coupon added successfully',
                    //     'items' => Cart::getContent(),
                    //     'conditions' => [[
                    //             'name' => $coupon->name,
                    //             'value' => $coupon->value,
                    //             'code' => $coupon->code,
                    //             'microsite' => $item['attributes']['microsite'],
                    //         ]]

                    // ];

                } else {
                    return redirect(url()->previous())->with('error', 'Coupon already added to cart');
                    // $couponCount = 0;

                    // foreach ($item['conditions'] as $condition) {
                    //     if ($condition->getName() == $coupon->name . '-' . $coupon->code) {
                    //         $couponCount = $couponCount + 1;
                    //     }
                    // }

                    // if ($couponCount == 0) {
                    //     $itemCondition = new CartCondition([
                    //         'name' => $coupon->name . '-' . $coupon->code,
                    //         'type' => 'Coupon',
                    //         'target' => 'subtotal',
                    //         'value' => '-' . $coupon->percentage . '%',
                    //     ]);
                    //     Cart::addItemCondition($key, $itemCondition);
                    //     $coupon->number_of_uses = $coupon->number_of_uses + 1;
                    //     $coupon->remains = $coupon->remains - 1;
                    //     if ($coupon->remains < 1) {
                    //         $coupon->used = true;
                    //     }
                    //     $coupon->save();
                    //     return redirect(url()->previous())->with('success', 'Coupon added successfully');
                    //     // $cartArray = [
                    //     //     'status' => 'success',
                    //     //     'message' => 'Coupon added successfully',
                    //     //     'items' => Cart::getContent(),
                    //     //     'conditions' => [[
                    //     //         'name' => $coupon->name,
                    //     //         'value' => $coupon->value,
                    //     //         'code' => $coupon->code,
                    //     //         'microsite' => $item['attributes']['microsite'],
                    //     //     ]]
                    //     // ];
                    // } else {
                    //     return redirect(url()->previous())->with('error', 'Coupon already added to cart');
                    //     // $cartArray = [
                    //     //     'status' => 'error',
                    //     //     'message' => 'Coupon already added to cart'
                    //     // ];
                    // }
                }
            }
        }

        return $cartArray;
    }

    /**
     * remove cart.
     *
     * @param mixed $id
     */
    public function removeCoupon($itemId, $conditionName)
    {
        Cart::removeItemCondition($itemId, $conditionName);

        //return message
        $cart = Cart::getContent();
        $cart = [
            'status' => 'error',
            'message' => 'Coupon removed from cart successfully'
        ];

        return $cart;
    }

    public function validateShipping()
    {
        return request()->validate([
            'user_id'    => '',
            'first_name' => 'required',
            'last_name'  => 'required',
            'address'    => 'required',
            'phone'      => 'required',
            'email'      => 'required',
            'city'       => 'required',
            'state'      => 'required',
            'addresstype' => 'required',
        ]);
    }

    private function shippingArray($shipping)
    {
        $shippingArray = [];

        if (empty($shipping)) {
            return $shippingArray;
        }

        foreach ($shipping as $ship) {
            $city = Areas::whereArea($ship->city)->first();
            $state = States::whereState($ship->state)->first();
            $shippingArray[$ship->type] = [
                'type' => $ship->type,
                'address' => $ship->address,
                'cityId' => $city->id,
                'city' => $ship->city,
                'stateId' => $state->id,
                'state' => $ship->state,
            ];
        }

        return $shippingArray;
    }


    public function validateNewUser()
    {
        return request()->validate([
            'user_id'    => '',
            'first_name' => 'required',
            'last_name'  => 'required',
            'address'    => 'required',
            'phone'      => 'required',
            'email'      => 'required',
        ]);
    }

    public function groupCart()
    {
        $group = [];
        foreach (Cart::getContent() as $item) {

            $group[$item->attributes->business_id][] = $item;
        }

        return $group;
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
    public function checkMinOrder()
    {
        $spend = [];
        foreach (Cart::getContent() as $item) {
            if ($item->attributes->microsite == 'cuisine') {
                $restaurant = Restaurant::where('business_id', $item->attributes->business_id)->first();
                $spend[$item->attributes->business_id]['min'] = $restaurant->min_order;
                $spend[$item->attributes->business_id]['spend'][] = $item->price * $item->quantity;
            }
        }

        if (!empty($spend)) {
            foreach ($spend as $business_id => $s) {
                if ($s['min'] > array_sum($s['spend'])) {
                    $error = 'You need a minimium order of NGN' . $s['min'];
                    $biz = Business::findorfail($business_id);

                    return redirect()->route('restaurant.show', ['any' => $biz->slug])->with('error', $error)->send();
                }
            }
        }
    }

    public function paystackVerify($reference){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".config('app.paystack.secret'),
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response,true);
            if ($response['data']['status'] == 'success') {
                return $response;
            //     //updated paid on orders table
            //     $txn->flutterwave_reference = $flwref;
            //     $txn->ip_address = $response->data->ip;
            //     $txn->card_type = $response->data->card->type ?? null;
            //     $txn->last4 = $response->data->card->last_4digits ?? null;
            //     $txn->narration = $response->data->narration;
            //     $txn->status = $response->data->processor_response;
            //     $txn->expiry = $response->data->card->expiry ?? null;
            //     $txn->channel = $response->data->payment_type;
            //     $txn->bank = $response->data->card->issuer ?? null;
            //     $txn->authorization_code = $response->data->card->token ?? null;
            //     $txn->raw_response = $jsonResponse;

            //     $txn->save();

            //     $order->status = 'paid';
            //     $order->save();
            //     // Assign point to user
            //     // Get points from total orders
            //     $amount_per_point = JollofPointSetting::first()->amount_per_point;
            //     $points = round($response->data->amount / $amount_per_point, 1);
            //     // Check decimal number
            //     $decimal = explode('.', $points);
            //     if ($decimal[1] ?? $decimal[0] < 5) {
            //         $points = $decimal[0];
            //     }
            //     // Get user existing points
            //     $user = User::where('id', $order->user_id)->first();
            //     // Add new points to exixting points
            //     $new_points = $user->points + $points;
            //     // Update data with new points
            //     $user->points = $new_points;
            //     $user->save();
            //     //update paid_on date on order_items
            //     $orderItems = OrderItems::where('order_id', $order->id)->get();
            //     foreach ($orderItems as $oitem) {
            //         $oitem->paid_on = now();
            //         $oitem->save();

            //         if ($oitem->model == 'fashion') {
            //             $product = FashionProduct::findorfail($oitem->model_id);
            //             $order->product_id = $product->id;
            //             $order->save();
            //             $product->quantity = ($product->quantity == 0) ? $product->quantity : $product->quantity - $oitem->quantity;
            //             $product->save();
            //         }
            //     }

            //     // Clear Shopping Cart
            //     Cart::clear();

            //     //send notifications to Admin
            //     $order = Orders::with('user')->where('order_code', $order_code)->first();
            //     $business = Business::whereId($orderItems[0]->business_id)->first();
            //     $admin = User::role('super-admin')->first();
            //     $shipping = $order->shipping()->first();


            //     $mailData = [
            //         'order_code'        => $order->order_code,
            //         'items'             => $orderItems,
            //         'subtotal'          => "NGN " . number_format($order->subtotal, 2),
            //         'total'             => "NGN " . number_format($order->total, 2),
            //         'sender'            => 'Jollof',
            //         'sender_email'      => 'orders@jollof.com',
            //         'shipping'          => $shipping
            //     ];

            //     $userData = $mailData;
            //     $userData['subject'] = "Order Placed successfully";
            //     $userData['message'] = "Your order has been placed";
            //     $userData['message_line2'] = "";
            //     $userData['recipient'] = $order->user->first_name;
            //     $userData['recipient_email'] = $order->user->email;
            //     $userData['recipient_phone'] = $order->user->telephone;
            //     //mail user
            //     Log::info("Logging email");
            //     Log::info($order->user->email);
            //     Log::info($business->email);
            //     Log::info($admin->email);
            //     Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


            //     $merchantData = $mailData;
            //     $merchantData['subject'] = "ORDER:: " . $order->user->first_name . " You have an order from ";
            //     $merchantData['message'] = "You have an order from " . $order->user->first_name;
            //     $merchantData['message_line2'] = "Please start processing the order.";
            //     $merchantData['recipient'] = $business->name;
            //     $merchantData['recipient_email'] = $business->email;
            //     $merchantData['recipient_phone'] = $business->telephone;
            //     //mail merchant
            //     Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

            //     $adminData = $mailData;
            //     $adminData['subject'] = "ORDER - " . $business->name . " An order has been placed on ";
            //     $adminData['message'] = "An order has been placed on " . $business->name;
            //     $adminData['message_line2'] = "";
            //     $adminData['recipient'] = $admin->first_name;
            //     $adminData['recipient_email'] = $admin->email;
            //     $adminData['recipient_phone'] = $admin->telephone;
            //     //mail admin
            //     Mail::to($admin->email)->send(new AdminOrderPaid($adminData));
            }
        }
    }

    public function verifyWithPaystack(Request $request,$reference,$trans_id,$status,$message,$order_code)
    {
        $tx_ref = $reference;
        $tx_id = $trans_id;
        $status = $status;
        $flwref = $request->query('flwref');
        $cancelled = $request->query('cancelled');
        // return response()->json([
        //     $tx_ref,
        //     $tx_id,
        //     $status,
        //     $flwref,
        //     $order_code
        // ]);

        $order = Orders::with('user')->where('order_code', $order_code)->first();
        $txn = Flutterwave::where('reference', $tx_ref)->first();
        // return $txn;

        if ($txn) {
            //add payment details to database
            $txn->flutterwave_reference = $tx_id;
            $txn->save();
        } else {
            //add payment details to database
            $flw = new Flutterwave();
            $flw->order_code = $order_code;
            $flw->email = $order->user->email;
            $flw->amount = $order->total;
            $flw->reference = $tx_ref;

            $flw->save();
        }
        // $txn = Flutterwave::where('reference', $tx_ref)->first();
        if ($status == 'failed') {
            $txn->flutterwave_reference = $tx_id;
            $txn->status = $status;
            $txn->save();

            $order->status = $status;
            $order->save();
        } elseif ($cancelled == 'true') {
            $txn->status = 'cancelled';
            $txn->save();
        } else {
            //verify transaction
            // return $status;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . config('app.paystack.secret'),
                    "Cache-Control: no-cache",
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response, true);
                if ($response['data']['status'] == 'success')
                {
                    // return $response['data'];
                    //     //updated paid on orders table
                        $txn->flutterwave_reference = $flwref;
                        $txn->ip_address = $response['data']['ip_address'];
                        $txn->card_type = $response['data']['authorization']['card_type'] ?? null;
                        $txn->last4 = $response['data']['authorization']['last4'] ?? null;
                        $txn->narration = $response['data']['message'] ?? null;
                        $txn->status = $response['data']['gateway_response'];
                        $txn->expiry = $response['data']['authorization']['exp_month'].'/'. $response['data']['authorization']['exp_year'] ?? null;
                        $txn->channel = $response['data']['channel'];
                        $txn->bank = $response['data']['authorization']['bank'] ?? null;
                        $txn->authorization_code = $response['data']['authorization']['authorization_code'] ?? null;
                        $txn->raw_response = json_encode($response);

                        $txn->save();

                        $order->status = 'paid';
                        $order->save();
                        // Assign point to user
                        // Get points from total orders
                        $amount_per_point = JollofPointSetting::first()->amount_per_point;
                        $points = round($response['data']['amount'] / $amount_per_point, 1);
                        // Check decimal number
                        $decimal = explode('.', $points);
                        if ($decimal[1] ?? $decimal[0] < 5) {
                            $points = $decimal[0];
                        }
                        // Get user existing points
                        $user = User::where('id', $order->user_id)->first();
                        // Add new points to exixting points
                        $new_points = $user->points + $points;
                        // Update data with new points
                        $user->points = $new_points;
                        $user->save();
                        //update paid_on date on order_items
                        $orderItems = OrderItems::where('order_id', $order->id)->get();
                        foreach ($orderItems as $oitem) {
                            $oitem->paid_on = now();
                            $oitem->save();

                            if ($oitem->model == 'fashion') {
                                $product = FashionProduct::findorfail($oitem->model_id);
                                $order->product_id = $product->id;
                                $order->save();
                                $product->quantity = ($product->quantity == 0) ? $product->quantity : $product->quantity - $oitem->quantity;
                                $product->save();
                            }
                        }

                        // Clear Shopping Cart
                        Cart::clear();

                        //send notifications to Admin
                        $order = Orders::with('user')->where('order_code', $order_code)->first();
                        $business = Business::whereId($orderItems[0]->business_id)->first();
                        $admin = User::first();
                    // $admin = User::role('super-admin')->first();
                        $shipping = $order->shipping()->first();

                        // return $admin;
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
                        $userData['subject'] = "Order Placed successfully";
                        $userData['message'] = "Your order has been placed";
                        $userData['message_line2'] = "";
                        $userData['recipient'] = $order->user->first_name;
                        $userData['recipient_email'] = $order->user->email;
                        $userData['recipient_phone'] = $order->user->telephone;
                        //mail user
                        Log::info("Logging email");
                        Log::info($order->user->email);
                        Log::info($business->email);
                        Log::info($admin->email);
                        Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


                        $merchantData = $mailData;
                        $merchantData['subject'] = "ORDER:: " . $order->user->first_name . " You have an order from ";
                        $merchantData['message'] = "You have an order from " . $order->user->first_name;
                        $merchantData['message_line2'] = "Please start processing the order.";
                        $merchantData['recipient'] = $business->name;
                        $merchantData['recipient_email'] = $business->email;
                        $merchantData['recipient_phone'] = $business->telephone;
                        //mail merchant
                        Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

                        $adminData = $mailData;
                        $adminData['subject'] = "ORDER - " . $business->name . " An order has been placed on ";
                        $adminData['message'] = "An order has been placed on " . $business->name;
                        $adminData['message_line2'] = "";
                        $adminData['recipient'] = $admin->first_name;
                        $adminData['recipient_email'] = $admin->email;
                        $adminData['recipient_phone'] = $admin->telephone;
                        //mail admin
                        Mail::to($admin->email)->send(new AdminOrderPaid($adminData));
                }

                return redirect()->route('cart.order.summary', ['code' => $order_code]);
            }

            // Old
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/" . $tx_id . "/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . env('FLUTTERWAVE_API_SECRET')
                ),
            ));

            $jsonResponse = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($jsonResponse);

            if ($response->status == 'success') {
                //updated paid on orders table
                $txn->flutterwave_reference = $flwref;
                $txn->ip_address = $response->data->ip;
                $txn->card_type = $response->data->card->type ?? null;
                $txn->last4 = $response->data->card->last_4digits ?? null;
                $txn->narration = $response->data->narration;
                $txn->status = $response->data->processor_response;
                $txn->expiry = $response->data->card->expiry ?? null;
                $txn->channel = $response->data->payment_type;
                $txn->bank = $response->data->card->issuer ?? null;
                $txn->authorization_code = $response->data->card->token ?? null;
                $txn->raw_response = $jsonResponse;

                $txn->save();

                $order->status = 'paid';
                $order->save();
                // Assign point to user
                // Get points from total orders
                $amount_per_point = JollofPointSetting::first()->amount_per_point;
                $points = round($response->data->amount / $amount_per_point, 1);
                // Check decimal number
                $decimal = explode('.', $points);
                if ($decimal[1] ?? $decimal[0] < 5) {
                    $points = $decimal[0];
                }
                // Get user existing points
                $user = User::where('id', $order->user_id)->first();
                // Add new points to exixting points
                $new_points = $user->points + $points;
                // Update data with new points
                $user->points = $new_points;
                $user->save();
                //update paid_on date on order_items
                $orderItems = OrderItems::where('order_id', $order->id)->get();
                foreach ($orderItems as $oitem) {
                    $oitem->paid_on = now();
                    $oitem->save();

                    if ($oitem->model == 'fashion') {
                        $product = FashionProduct::findorfail($oitem->model_id);
                        $order->product_id = $product->id;
                        $order->save();
                        $product->quantity = ($product->quantity == 0) ? $product->quantity : $product->quantity - $oitem->quantity;
                        $product->save();
                    }
                }

                // Clear Shopping Cart
                Cart::clear();

                //send notifications to Admin
                $order = Orders::with('user')->where('order_code', $order_code)->first();
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
                $userData['subject'] = "Order Placed successfully";
                $userData['message'] = "Your order has been placed";
                $userData['message_line2'] = "";
                $userData['recipient'] = $order->user->first_name;
                $userData['recipient_email'] = $order->user->email;
                $userData['recipient_phone'] = $order->user->telephone;
                //mail user
                Log::info("Logging email");
                Log::info($order->user->email);
                Log::info($business->email);
                Log::info($admin->email);
                Mail::to($order->user->email)->send(new AdminOrderPaid($userData));


                $merchantData = $mailData;
                $merchantData['subject'] = "ORDER:: " . $order->user->first_name . " You have an order from ";
                $merchantData['message'] = "You have an order from " . $order->user->first_name;
                $merchantData['message_line2'] = "Please start processing the order.";
                $merchantData['recipient'] = $business->name;
                $merchantData['recipient_email'] = $business->email;
                $merchantData['recipient_phone'] = $business->telephone;
                //mail merchant
                Mail::to($business->email)->send(new AdminOrderPaid($merchantData));

                $adminData = $mailData;
                $adminData['subject'] = "ORDER - " . $business->name . " An order has been placed on ";
                $adminData['message'] = "An order has been placed on " . $business->name;
                $adminData['message_line2'] = "";
                $adminData['recipient'] = $admin->first_name;
                $adminData['recipient_email'] = $admin->email;
                $adminData['recipient_phone'] = $admin->telephone;
                //mail admin
                Mail::to($admin->email)->send(new AdminOrderPaid($adminData));
            }
        }

        return redirect()->route('cart.order.complete', ['code' => $order_code]);
    }
}
