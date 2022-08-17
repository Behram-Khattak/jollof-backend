<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\RestaurantBooking;
use App\Models\Bookings;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessType;
use App\Models\CuisineCategory;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Restaurant;
use App\Models\Review;
use Auth;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$restaurants = Restaurant::all();
        $business_type = BusinessType::whereSlug('cuisine')->first();
        $business = Business::with('restaurant')->where('business_type_id', $business_type->id)->where('status', 'approved')->get();
        $featured = Restaurant::with('business')->where('featured', 1)->get();
        $restaurants = Business::with('restaurant')->where('business_type_id', 1)->where('status', 'approved')->latest()->take(4)->get();
        $allRestaurants = Business::with('restaurant')->where('business_type_id', 1)->where('status', 'approved')->get();

        return view('user.restaurant.index', compact(['business', 'featured', 'restaurants', 'allRestaurants']));
    }

    /**
     * Display a listing of the resource.
     *
     * @param mixed $slug
     *
     * @return Response
     */
    public function show($slug)
    {
        $business = Business::with('locations')->whereSlug($slug)->first();
        $restaurant = Restaurant::where('business_id', $business->id)->first();
        // dd($restaurant);
        if (!$restaurant) {
            $restaurantDefault = restaurantDefault();
            $restaurantDefault['business_id'] = $business->id;
            Restaurant::create($restaurantDefault);
            $restaurant = Restaurant::where('business_id', $business->id)->first();
        }

        $hours = json_decode($restaurant->hours, true);
        // check if the restaurant is open
        // dd(restaurantOpen($restaurant->hours));
        // if (restaurantOpen($restaurant->hours) == true) {
        //     $is_open = true;
        // } else {
        //     $is_open = false;
        // }
        // return $is_open;
        if (isset($hours['status'])) {
            $isopen = $hours['status'];
            unset($hours['status']);
        } else {
            $isopen = [];
        }

        $groups = ($restaurant) ? CuisineCategory::where('restaurant_id', $restaurant->id)->get() : collect([]);
        $menus = ($restaurant) ? CuisineCategory::where('restaurant_id', $restaurant->id)->with('menus')->get() : collect([]);
        $cartCollection = Cart::getContent();
        $spend = $this->getSpend($business->id);
        $reviews = Review::with('user')->where('model_type', 'cuisine')->where('model_id', $restaurant->id)->where('status', 1)->paginate(7);
        // dd($reviews);
        $hasreview = Review::with('user')->where('model_type', 'cuisine')->where('model_id', $restaurant->id)->where('user_id', Auth::id())->where('status', 1)->get();
        $hasordered = OrderItems::hasOrdered($business->id, Auth::id())->get()->count();

        return view('user.restaurant.show', compact(['restaurant', 'business', 'groups', 'menus', 'cartCollection', 'reviews', 'hasreview', 'hasordered', 'hours', 'isopen', 'spend']));
    }

    /**
     * Display search result.
     */
    public function search(Request $request)
    {
        $restaurants = [];

        if (!$request->missing('restaurant')) {

            $input = $request->validate([
                'restaurant' => 'required'
            ]);
            $searchName = $input['restaurant'];
            if ($searchName == "0") {
                $result = Business::with('locations')->where('status', 'approved')->get();
            } else {
                $result = Business::with('locations')->where('name', 'like', '%' . $searchName . '%')->where('status', 'approved')->get();
            }
            foreach ($result as $res) {
                if (checkMicrosite($res->business_type_id, 'Cuisine')) {
                    foreach ($res->locations as $location) {
                        $location->business = $res;
                        $restaurants[] = $location;
                    }
                }
            }
        } else {
            $input = $request->validate([
                'city' => 'required',
                'state' => 'required',
            ]);

            $city = explode('-', $input['city']);

            $restaurants = BusinessLocation::with(['business' => function ($query) {
                $query->where('business_type_id', 1)->where('status', 'approved');
            }])->where('state', $input['state'])->where('city', trim($city[0]))->get();
        }

        $allRestaurants = Business::with('restaurant')->where('business_type_id', 1)->where('status', 'approved')->get();


        return view('user.restaurant.search', compact(['restaurants', 'input', 'allRestaurants']));
    }

    public function booking(Request $request)
    {
        $mailData = $request->validate([
            'first_name'    => 'required|max:50',
            'last_name'     => 'required|max:50',
            'instructions'  => 'required|max:255',
            'guest'         => 'required',
            'date'          => 'required',
            'time'          => 'required|max:255',
            'phone'         => 'required|max:50',
            'email'         => 'required|max:50',
            'restaurant_id' => 'required|max:50',
        ]);
        //@todo - get admin or manager email and send
        $restaurantLocationEmail = "info@sweetpot.com";

        Bookings::create($mailData);

        Mail::to($restaurantLocationEmail)->send(new RestaurantBooking($mailData));

        return redirect(url()->previous())->with([
            'alertType' => 'success',
            'message' => 'Your restaurant table booking was successful.'
        ]);
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
    public function review(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'review' => ['required'],
            'star' => ['required', 'numeric'],
            'model_type' => ['required'],
            'model_id' => ['required_if:model_type,==,fashion'],
            'order_id' => ['required', 'numeric'],
            'business_id' => ['required', 'numeric'],
        ]);
        // unset request star
        unset($data['star']);
        $data['user_id'] = Auth::id();
        $data['rating'] = $request->star;
        //$data['status'] = '';
        $reviewed = Review::create($data);
        if ($reviewed) {
            // update order to reviewed
            $order = Orders::where('id', $request->order_id)->first();
            $order->reviewed = true;
            $order->save();
        }

        return redirect(url()->previous())->with('success', 'Success! Review created successfully');
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
    public function getSpend($business_id)
    {
        $spend = 0;

        foreach (Cart::getContent() as $item) {

            if ($item->attributes->business_id == $business_id) {
                $spend = $spend + ($item->price * $item->quantity);
            }
        }

        return $spend;
    }
}
