<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessType;
use App\Models\Consumable;
use App\Models\CuisineCategory;
use App\Models\CuisineMenus;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumberFormat;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $restaurants = Restaurant::get();
        // dd($restaurants);
        return view('admin.restaurant.index', compact(['restaurants']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $restaurant = new Restaurant();

        return view('admin.restaurant.create', compact(['restaurant']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();
        //convert array to string
        $data['delivery_options'] = implode(',', $data['delivery_options']);
        $data['payment_types'] = implode(',', $data['payment_types']);
        $logo = $data['logo'];
        $cover = $data['cover'];
        unset($data['logo'], $data['cover']);

        $business_type_id = BusinessType::where('slug', $data['business_type'])->first()->id;

        $business = Business::create([
            'owner_id'         => auth()->id(),
            'business_type_id' => $business_type_id,
            'name'             => $request->input('name'),
            'email'            => $request->input('business_email'),
            'telephone'        => phone($request->input('business_phone'), 'NG', PhoneNumberFormat::E164),
            'whatsapp'         => phone($request->input('business_whatsapp'), 'NG', PhoneNumberFormat::E164),
            'description'      => $request->input('about'),
        ]);

        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'state'       => $request->input('state'),
            'city'        => $request->input('city'),
            'area'        => $request->input('area') ?? null,
            'address'     => $request->input('address'),
            'default'     => true,
        ]);
        //add data to database
        $restaurant = Restaurant::create([
            'business_id' => $business->id,
            'business_location_id' => $location->id,
            'min_order' => $request->input('min_order'),
            'disposable' => $request->input('disposable'),
            'delivery_fee'        => $request->input('delivery_fee'),
            'delivery_time'       => $request->input('delivery_time'),
            'delivery_options'    => $data['delivery_options'],
            'payment_types'       => $data['payment_types'],
            'featured'            => $request->input('featured'),
            'status'              => $request->input('status'),
        ]);

        //upload and add file to media
        $restaurant->addMedia($logo)->withCustomProperties(['type' => 'logo'])->toMediaCollection();
        $restaurant->addMedia($cover)->withCustomProperties(['type' => 'cover'])->toMediaCollection();

        //rediret to details page
        return redirect("/admin/restaurant/{$restaurant->id}")->with([
            'message', 'Restaurant created successfully',
            'alert-type', 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        $business = Business::where('id', $restaurant->business_id)->first();
        $location = BusinessLocation::where('id', $restaurant->business_location_id)->first();
        $category = CuisineCategory::where('restaurant_id', $id)->get();
        $consumable = Consumable::where('restaurant_id', $id)->get();
        $menus = CuisineMenus::with('consumables')->where('restaurant_id', $id)->get();
        // dd($menus);

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

        return view('admin.restaurant.show', compact(['restaurant', 'category', 'consumable', 'pictures', 'menus','business', 'location']));
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

        return view('admin.restaurant.edit', compact(['restaurant']));
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

        // $logo = $data['logo'];
        // $cover = $data['cover'];
        // unset($data['logo']);
        // unset($data['cover']);

        //add data to database
        $restaurant = Restaurant::where('id', $id)->update($data);

        // //upload and add file to media
        // $restaurant->addMedia($logo)->withCustomProperties(['type' => 'logo'])->toMediaCollection();
        // $restaurant->addMedia($cover)->withCustomProperties(['type' => 'cover'])->toMediaCollection();

        //rediret to details page
        return redirect("/admin/restaurant/{$id}")->with([
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
            redirect('/admin/restaurants')->with([
                'message'    => 'There was a problem deleting the restaurant!',
                'alert-type' => 'error',
            ]);
        }

        Restaurant::where('id', $id)->delete();

        return redirect('/admin/restaurants')->with([
            'message'    => 'Restaurant deleted successfully!',
            'alert-type' => 'success',
        ]);
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
        $validator = Validator::make($request->all(), [
            'picture'    => 'required|min:5|max:1024|mimes:png,jpg,jpeg',
            'image-type' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect("/admin/restaurant/{$id}")->with([
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
        return redirect("/admin/restaurant/{$restaurant->id}")->with([
            'message', 'Upload successful',
            'alert-type', 'success',
        ]);
    }

    /**
     * Validate form data.
     *
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
            'business_type'      => 'required',
            'business_email'     => 'required',
            'business_phone'     => 'required',
            'business_whatsapp'  => 'required',
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
