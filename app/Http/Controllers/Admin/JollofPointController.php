<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JollofPointSetting;
use Illuminate\Http\Request;

class JollofPointController extends Controller
{
    public function settings(Request $request)
    {
        $this->validate($request, [
            'amount_per_point' => 'required|numeric',
        ]);
        $settings = JollofPointSetting::first();
        if($settings == null)
        {
            $settings = JollofPointSetting::create([
                'amount_per_point' => $request->amount_per_point,
            ]);
        }
        else
        {
            $settings->update([
                'amount_per_point' => $request->amount_per_point,
            ]);
        }
        // dd($settings);
        // $settings->update(['amount_per_point' => $request->amount_per_point]);
        return redirect()->back()->with([
            'message'    => 'Jollof point updated successfully',
            'alert-type' => 'success',
        ]);
    }
}
