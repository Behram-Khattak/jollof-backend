<?php

/**
 * Notification Controller manages (show, edit, delete) the notification messages showing on all the application
 * Available to only the admin (this can change in the future).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuisineCategory;
use Illuminate\Http\Request;

class CuisineCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData();

        //add data to database
        $cc = CuisineCategory::create($data);

        //rediret to details page
        return redirect("/admin/restaurant/{$cc->restaurant_id}")->with([
            'message'    => 'Cuisine Category created successfully',
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

        CuisineCategory::findorfail($id);
        CuisineCategory::where('id', $id)->update($data);

        return redirect("/admin/restaurant/{$restaurant_id}")->with([
            'message'    => 'Cuisine Category updated successfully',
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
        $category = CuisineCategory::findorfail($id);

        if ($category == null) {
            //redirect with message
            redirect('/admin/restaurants')->with([
                'message'    => 'There was a problem deleting the cuisine category!',
                'alert-type' => 'error',
            ]);
        }

        CuisineCategory::where('id', $id)->delete();

        return redirect("/admin/restaurant/{$category->restaurant_id}")->with([
            'message'    => 'Cuisine category deleted successfully!',
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
            'name'          => 'required',
            'restaurant_id' => 'required',
        ]);
    }
}
