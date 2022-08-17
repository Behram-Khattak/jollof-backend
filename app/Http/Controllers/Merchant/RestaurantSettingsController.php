<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantSettingsController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function index(Business $business)
    {
        $restaurant = Restaurant::where('business_id', $business->id)->first();
        $hours = json_decode($restaurant->hours, true);

        if (isset($hours['status'])) {
            $isopen = $hours['status'];
            unset($hours['status']);
        } else {
            $isopen = [];
        }
        return view('merchant.restaurant.settings.index', compact(['restaurant', 'hours', 'isopen']));
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
    public function update(Request $request, Business $business)
    {

        if ($request->input('min_order')) {
            $data = $request->validate([
                'min_order' => ['numeric']
            ]);
        }

        if ($request->input('delivery_time')) {
            $data = $request->validate([
                'delivery_time' => ['required']
            ]);
        }

        if ($request->input('hours')) {

            $hourData = [];
            $day = $request->input('day');
            $status = $request->input('status');
            $open = $request->input('open');
            $close = $request->input('close');
            for ($i = 0; $i < 7; $i++) {
                $hourData[$day[$i]] = [$open[$i] . ':00', $close[$i] . ':00'];
                $hourData['status'][$day[$i]] = $status[$i];
            }

            $data = ['hours' => json_encode($hourData)];
        }

        $restaurant = Restaurant::whereBusinessId($business->id)->first();
        if (!$restaurant) {
            return redirect()->route('merchant.restaurant.settings', request()->route('business'))->with('error', 'Restaurant setting update failed');
        }

        $restaurant->update($data);

        return redirect()->route('merchant.restaurant.settings', request()->route('business'))->with('success', 'Restaurant setting updated successfully');
    }
}
