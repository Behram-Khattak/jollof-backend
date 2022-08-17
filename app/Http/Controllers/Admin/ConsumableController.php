<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
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

        //rediret to details page
        return redirect("/admin/restaurant/{$consumable->restaurant_id}")->with([
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
        $picture = $data['picture'];
        unset($data['picture']);

        $consumable = Consumable::findorfail($id);
        Consumable::where('id', $id)->update($data);

        if ($request->hasfile('picture')) {
            $consumable->addMedia($picture)->toMediaCollection();
        }

        return redirect("/admin/restaurant/{$restaurant_id}")->with([
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

        return redirect("/admin/restaurant/{$category->restaurant_id}")->with([
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
