<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\CuisineCategory;
use App\Models\CuisineMenus;
use App\Models\CuisineMenusExtras;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CuisineMenusController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function create($id)
    {
        /**
         * create a check if restaurant ID belongs to merchant.
         */
        $menus = new CuisineMenus();
        $restaurant = Restaurant::findorfail($id);
        $category = CuisineCategory::where('restaurant_id', $id)->get();
        $consumables = Consumable::where('restaurant_id', $id)->get();

        return view('merchant.restaurant.create_menu', compact(['menus', 'consumables', 'category', 'restaurant']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function store(Request $request, $id)
    {
        /**
         * :::::TODO:::::
         * check if restaurant belongs to merchant.
         */
        $data = $this->validateData();

        $menu = [
            'restaurant_id'       => $id,
            'cuisine_category_id' => $data['category'],
            'consumable_id'       => $data['menu'],
        ];

        //add application data to database
        $cuisineMenu = CuisineMenus::create($menu);

        $extra = [];
        foreach ($data['extra'] as $ex) {
            $extra = [
                'cuisine_menus_id' => $cuisineMenu->id,
                'consumables_id'   => $ex,
            ];

            CuisineMenusExtras::create($extra);
        }

        //rediret to applications details page
        return redirect("/admin/restaurant/{$id}")->with([
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
    public function edit($id)
    {
        $coupon = CuisineMenus::findorfail($id);
        $coupon->start_date = date('m-d-Y', strtotime($coupon->start)).' - '.date('m-d-Y', strtotime($coupon->start));

        return view('admin.coupon.edit', compact(['coupon']));
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
        $data = $this->validateData();

        $date = explode(' - ', $data['start_date']);
        $data['site'] = implode(',', $data['location']);
        unset($data['location'], $data['start_date']);

        $data['start'] = date('Y-m-d', strtotime($date[0]));
        $data['expire'] = date('Y-m-d', strtotime($date[1]));

        CuisineMenus::where('id', $id)->update($data);

        return redirect('/admin/coupon')->with([
            'message'    => 'Coupon updated successfully!',
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
    public function destroy($id)
    {
        $coupon = CuisineMenus::findorfail($id);
        if ($coupon == null) {
            //redirect with message
            redirect('/admin/coupon')->with([
                'message'    => 'There was a problem deleting the coupon!',
                'alert-type' => 'error',
            ]);
        }

        CuisineMenus::where('id', $id)->delete();

        return redirect('/admin/coupon')->with([
            'message'    => 'Coupon deleted successfully!',
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
            'menu'     => 'required',
            'category' => 'required',
            'extra'    => 'required',
            'extra.*'  => 'required',
        ]);
    }
}
