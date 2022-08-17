<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Consumable;
use App\Models\CuisineCategory;
use App\Models\CuisineMenus;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CuisineMenusController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $id
     * @param mixed $slug
     *
     * @return Response
     */
    public function create(Business $business)
    {
        /**
         * create a check if restaurant ID belongs to merchant.
         */

        if ($business->status !== 'approved') {
            return redirect(route('merchant.restaurant.menu', request()->route('business')))->with([
                'message'    => 'Cuisine business has not been approved',
                'alert-type' => 'error',
            ]);
        }

        $business->load('restaurant');

        $locations = BusinessLocation::whereBusinessId($business->id)->get();
        $menus = new CuisineMenus();
        $toppings = $menus->toppings;
        $restaurant = $business->restaurant[0];
        $category = CuisineCategory::whereRestaurantId($restaurant->id)->get();

        return view('merchant.restaurant.create_menu', compact(['menus', 'category', 'restaurant', 'locations', 'toppings']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $id
     * @param mixed $slug
     *
     * @return Response
     */
    public function store(Request $request, Business $business)
    {
        /**
         * :::::TODO:::::
         * check if restaurant belongs to merchant.
         */
        $data = $this->validateData();

        $menu = [
            'restaurant_id' => $business->restaurant[0]->id,
            'type'          => $data['type'],
            'menu'          => $data['menu'],
            'delivery_time' => $data['delivery_time'],
            'description'   => $data['description'],
            'price'         => $data['price'],
            'sales_price'   => $data['sales_price'],
            'in_stock'      => $data['in_stock'],
            'preorder'      => $data['preorder'],
        ];

        if (isset($data['toppings'])) {
            $menu['toppings'] = json_encode($data['toppings']);
        }
        if($data['type'] == 'REGULAR'){
            $menu['sales_price'] = null;
            $data['schedule'] = null;
            $menu['sales_start'] = null;
            $menu['sales_end'] = null;
        }
        // dd($data);
        $menu['cuisine_category_id'] = $data['category'];

        //calculate expiry date
        if (!is_null($data['schedule'])) {
            $date = explode(' - ', $data['schedule']);
            $menu['sales_start'] = date('Y-m-d H:i:s', strtotime($date[0]));
            $menu['sales_end'] = date('Y-m-d H:i:s', strtotime($date[1]));
        }

        $picture = $data['picture'];
        unset($data['picture']);
        //add application data to database
        $cuisineMenu = CuisineMenus::create($menu);
        $cuisineMenu->addMedia($picture)->toMediaCollection('menu');

        //rediret to applications details page
        return redirect(route('merchant.restaurant.menu', request()->route('business')))->with([
            'message'    => 'Cuisine menu created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(Business $business, $id)
    {
        /** @var $menus CuisineMenus*/

        $menus = CuisineMenus::with('restaurant.business')->whereId($id)->first();
        $restaurant = $menus->restaurant;
        $locations = $business->locations;
        $toppings = json_decode($menus->toppings, true);
        $category = CuisineCategory::whereRestaurantId($restaurant->id)->get();
        return view('merchant.restaurant.edit_menu', compact(['menus', 'category', 'restaurant', 'locations', 'toppings']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Business $business, Request $request)
    {
        // dd($request->all());
        $data = $this->validateData();
        // dd($data);
        // dd($data);
        $data['toppings'] =  $data['toppings'] ?? [];
        if(!isset($data['toppings'][0]['items'])){
            unset($data['toppings'][0]);
        }
        if(isset($data['Old_toppings'])){
            foreach ($data['Old_toppings'] as $key => $topping) {
                $topping['items'] = array_values($topping['items']);
                unset($data['Old_toppings'][$key]['items']);
                $data['Old_toppings'][$key]['items'] = $topping['items'];
            }
            $data['toppings'] = array_merge($data['toppings'], $data['Old_toppings']);
        }
        unset($data['Old_toppings']);

        $id = $request->input('id');
        $menu = [
            'restaurant_id' => $business->restaurant[0]->id,
            'type'          => $data['type'],
            'menu'          => $data['menu'],
            'delivery_time' => $data['delivery_time'],
            'description'   => $data['description'],
            'price'         => $data['price'],
            'sales_price'   => $data['sales_price'],
            'in_stock'      => $data['in_stock'],
            'preorder'      => $data['preorder'],
        ];

        if (isset($data['toppings'])) {
            $menu['toppings'] = json_encode($data['toppings']);
        }

        if($data['type'] == 'REGULAR'){
            $menu['sales_price'] = null;
            $data['schedule'] = null;
            $menu['sales_start'] = null;
            $menu['sales_end'] = null;
        }

        $menu['cuisine_category_id'] = $data['category'];

        //calculate expiry date
        if (!is_null($data['schedule'])) {
            $date = explode(' - ', $data['schedule']);
            $menu['sales_start'] = date('Y-m-d H:i:s', strtotime($date[0]));
            $menu['sales_end'] = date('Y-m-d H:i:s', strtotime($date[1]));
        }

        if (isset($data['picture'])) {
            $picture = $data['picture'];
            unset($data['picture']);
        }

        //add application data to database
        //$cuisineMenu = CuisineMenus::create($menu);
        CuisineMenus::where('id', $id)->update($menu);
        //$cuisineMenu->addMedia($picture)->toMediaCollection('menu');

        //rediret to applications details page
        // return redirect("/merchant/restaurant/menu/{$slug}")->with([
        //     'message'    => 'Cuisine menu created successfully',
        //     'alert-type' => 'success',
        // ]);

        // $date = explode(' - ', $data['start_date']);
        // $data['site'] = implode(',', $data['location']);
        // unset($data['location'], $data['start_date']);

        // $data['start'] = date('Y-m-d', strtotime($date[0]));
        // $data['expire'] = date('Y-m-d', strtotime($date[1]));

        // CuisineMenus::where('id', $id)->update($data);

        return redirect(route('merchant.restaurant.menu', request()->route('business')))->with([
            'message'    => 'Menu updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Business $business, $id)
    {
        $menu = CuisineMenus::findorfail($id);

        if ($menu == null) {
            //redirect with message
            return redirect(url()->previous())->with([
                'message'    => 'There was a problem deleting the cuisine menu!',
                'alert-type' => 'error',
            ]);
        }

        CuisineMenus::where('id', $id)->delete();

        return redirect(url()->previous())->with([
            'message'    => 'Cuisine menu deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Validate form data.
     *
     * @param Type $var Description
     *
     * @throws conditon
     *
     * @return type
     */
    public function validateData()
    {
        return request()->validate([
            'type'          => 'required|in:PROMO,REGULAR',
            'category'      => 'required',
            'menu'          => 'required',
            'delivery_time' => 'nullable',
            'description'   => 'nullable',
            'price'         => 'nullable',
            'sales_price'   => 'required_if:type,PROMO',
            'locations.*'   => 'nullable',
            'schedule'      => 'nullable',
            'picture'       => 'mimes:JPEG,jpeg,bmp,jpg,JPG,png,gif,GIF|max:500',
            'toppings'      => 'nullable',
            'Old_toppings'  => 'nullable',
            'in_stock'      => 'required',
            'preorder'      => 'required',
        ]);
    }
}
