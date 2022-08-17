<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Enums\BusinessTypeEnum;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\CuisineMenus;
use App\Models\FashionProduct;
use App\Models\HomeImage;
use App\Models\OrderItems;
use App\Models\Orders;
use Auth;

class HomeController extends Controller
{
    var $sites = [
        'cuisine' => BusinessTypeEnum::CUISINE,
        'fashion' => BusinessTypeEnum::FASHION,
        'lifestyle' => BusinessTypeEnum::LIFESTYLE,
        'scholar' => BusinessTypeEnum::SCHOLAR,
        'business' => BusinessTypeEnum::BUSINESS,
        'giftportal' => BusinessTypeEnum::GIFT_PORTAL
    ];

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sites = $this->sites;
        $images = HomeImage::with('media')->get();
        $orderItem = [];
        // get all users order
        // if logged in
        if (Auth::check()) {
            $orders = Orders::where([
                'user_id' => Auth::user()->id,
                'status' => 'paid',
                'reviewed' => false,
                ])->latest()->first();
                // dd($orders);
            if(!is_null($orders)) {
                // dd($orders);
                // get order items from the order items
                $orderItem = OrderItems::with('order')->where('order_id',$orders->id)->whereNotNull('delivery_timestamp')->first();
            }
                $orderItem = $orderItem ?? [];
        }
        // return $orderItem;
        return view('welcome', compact(['sites', 'images','orderItem']));
    }

}
