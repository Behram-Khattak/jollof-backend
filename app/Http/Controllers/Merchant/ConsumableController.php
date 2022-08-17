<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();

        $picture = $data['picture'];
        unset($data['picture']);

        //add data to database
        $consumable = Consumable::create($data);
        $consumable->addMedia($picture)->toMediaCollection();

        $restaurant = Restaurant::with('business')->where('id', $consumable->restaurant_id)->first();

        //rediret to details page
        return redirect("/merchant/restaurant/consumable/{$restaurant->business->slug}")->with([
            'message'    => 'Consumable created successfully',
            'alert-type' => 'success',
        ]);
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
        $restaurant_id = $data['restaurant_id'];
        unset($data['restaurant_id']);

        if (isset($data['picture'])) {
            $picture = $data['picture'];
            unset($data['picture']);
        }

        $consumable = Consumable::findorfail($id);
        Consumable::where('id', $id)->update($data);

        if ($request->hasfile('picture')) {
            $consumable->addMedia($picture)->toMediaCollection();
        }

        $restaurant = Restaurant::with('business')->where('id', $restaurant_id)->first();

        return redirect("/merchant/restaurant/consumable/{$restaurant->business->slug}")->with([
            'message'    => 'Consumable updated successfully',
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
        $category = Consumable::findorfail($id);

        if ($category == null) {
            //redirect with message
            redirect('/admin/restaurants')->with([
                'message'    => 'There was a problem deleting the cuisine category!',
                'alert-type' => 'error',
            ]);
        }

        Consumable::where('id', $id)->delete();

        $restaurant = Restaurant::with('business')->where('id', $category->restaurant_id)->first();

        return redirect("/merchant/restaurant/consumable/{$restaurant->business->slug}")->with([
            'message'    => 'Consumable deleted successfully!',
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
            'type'          => 'required',
            'name'          => 'required',
            'restaurant_id' => 'required',
            'price'         => 'required',
            'picture'       => 'nullable|mimes:jpeg,bmp,png|min:5|max:512',
        ]);
    }
}
