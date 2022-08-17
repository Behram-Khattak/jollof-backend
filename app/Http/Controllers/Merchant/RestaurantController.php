<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Consumable;
use App\Models\CuisineCategory;
use App\Models\CuisineMenus;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Business $business)
    {
        $business_type = BusinessType::whereSlug('cuisine')->first();
        $business = Business::with('restaurant')->where('owner_id', auth()->user()->id)->where('business_type_id', $business_type->id)->get();

        return view('merchant.restaurant.index', compact(['business']));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int   $id
     * @param mixed $slug
     *
     * @return Response
     */
    public function show($slug)
    {
        $business = Business::with('restaurant')->where('slug', $slug)->first();
        $restaurant = $business->restaurant[0];

        if (!$restaurant->default_setup) {
            //dd('yes');
            $restaurantDefault = restaurantDefault();
            Restaurant::where('id', $restaurant->id)->update($restaurantDefault);
        }

        $restaurant = Restaurant::find($restaurant->id);
        $category = CuisineCategory::where('restaurant_id', $restaurant->id)->get();
        $consumable = Consumable::where('restaurant_id', $restaurant->id)->get();
        $menus = CuisineMenus::with('consumables')->where('restaurant_id', $restaurant->id)->get();


        $pictures = [];

        $images = $restaurant->getMedia();
        if (!empty($images)) {
            foreach ($images as $im) {
                $properties = $im->custom_properties;
                if (isset($properties['type']) && $properties['type'] == 'logo') {
                    $pictures['logo'] = $im->getFullUrl();
                }

                if (isset($properties['type']) && $properties['type'] == 'cover') {
                    $pictures['cover'] = $im->getFullUrl();
                }
            }
        }

        return view('merchant.restaurant.show', compact(['restaurant', 'business', 'category', 'consumable', 'pictures', 'menus']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findorfail($id);

        return view('merchant.restaurant.edit', compact(['restaurant']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validateData('edit');

        //check if id belongs to merchant

        $data['delivery_options'] = implode(',', $data['delivery_options']);
        $data['payment_types'] = implode(',', $data['payment_types']);

        //add data to database
        $restaurant = Restaurant::where('id', $id)->update($data);

        //rediret to details page
        return redirect("/merchant/restaurant/{$id}")->with([
            'message', 'Restaurant updated successfully',
            'alert-type', 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findorfail($id);

        if ($restaurant == null) {
            //redirect with message
            redirect('/merchant/restaurants')->with([
                'message'    => 'There was a problem deleting the restaurant!',
                'alert-type' => 'error',
            ]);
        }

        Restaurant::where('id', $id)->delete();

        return redirect('/merchant/restaurants')->with([
            'message'    => 'Restaurant deleted successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $slug
     *
     * @return Response
     */
    public function category(Business $business)
    {
        $restaurant = $business->restaurant[0];
        $category = CuisineCategory::where('restaurant_id', $restaurant->id)->get();

        return view('merchant.restaurant.category', compact(['restaurant', 'business', 'category']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $slug
     *
     * @return Response
     */
    public function consumable($slug)
    {
        $business = Business::with('restaurant')->where('slug', $slug)->first();
        $restaurant = $business->restaurant[0];
        $consumable = Consumable::where('restaurant_id', $restaurant->id)->get();

        return view('merchant.restaurant.consumable', compact(['restaurant', 'business', 'consumable']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $slug
     *
     * @return Response
     */
    public function menu(Business $business)
    {
        //$business = Business::with('restaurant')->where('slug', $slug)->first();
        $business->load('restaurant');

        if ($business->restaurant->count() == 0) {
            //create restaurant
            Restaurant::create([
                'business_id' => $business->id,
            ]);

            $business->load('restaurant');
        }

        $restaurant = $business->restaurant[0];

        if (!$restaurant->default_setup) {
            $restaurantDefault = restaurantDefault();
            Restaurant::where('id', $restaurant->id)->update($restaurantDefault);

            $res = Restaurant::where('id', $restaurant->id)->first();

            $categories = restaurantCategoryDefault();
            foreach ($categories as $category) {
                CuisineCategory::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $category,
                ]);
            }
        }

        $menus = CuisineMenus::where('restaurant_id', $restaurant->id)->latest()->get();

        return view('merchant.restaurant.menu', compact(['restaurant', 'business', 'menus']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function upload(Request $request, $id)
    {
        $cusine = Restaurant::with('business')->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'picture'    => 'required|min:5|max:1024|mimes:png,jpg,jpeg',
            'image-type' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect("/merchant/restaurant/{$cusine->business->slug}")->with([
                'message', 'Error',
                'alert-type', 'error',
            ]);
        }

        $data = $request->all();

        $image_type = $data['image-type'];
        $picture = $data['picture'];

        $restaurant = Restaurant::findorfail($id);

        $images = $restaurant->getMedia('default', ['type' => $image_type]);

        if (!$images->isEmpty()) {
            foreach ($images as $im) {
                $properties = $im->custom_properties;
                if (isset($properties['type']) && $properties['type'] == $image_type) {
                    $im->delete();
                    $restaurant->addMedia($picture)->withCustomProperties(['type' => $image_type])->toMediaCollection();
                }
            }
        } else {
            if ($image_type == 'logo') {
                $restaurant->addMedia($picture)->withCustomProperties(['type' => 'logo'])->toMediaCollection();
            }

            if ($image_type == 'cover') {
                $restaurant->addMedia($picture)->withCustomProperties(['type' => 'cover'])->toMediaCollection();
            }
        }

        //rediret to details page
        return redirect("/merchant/restaurant/{$cusine->business->slug}")->with([
            'message', 'Upload successful',
            'alert-type', 'success',
        ]);
    }

    /**
     * Validate form data.
     *
     * @param null|mixed $type
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData($type = null)
    {
        $inputs = [
            'name'               => 'required',
            'about'              => 'required',
            'address'            => 'required',
            'state'              => 'required',
            'city'               => 'required',
            'min_order'          => 'required',
            'delivery_fee'       => 'required',
            'disposable'         => 'required',
            'delivery_time'      => 'required',
            'delivery_options'   => 'required',
            'delivery_options.*' => 'required',
            'payment_types'      => 'required',
            'payment_types.*'    => 'required',
            'featured'           => 'required',
            'status'             => 'required',
        ];

        if ($type !== 'edit') {
            $inputs['logo'] = 'required';
            $inputs['logo.*'] = 'required';
            $inputs['cover'] = 'required';
            $inputs['cover.*'] = 'required';
        }

        return request()->validate($inputs);
    }
}
