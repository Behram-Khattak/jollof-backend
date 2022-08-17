<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayawaySetting;
use Illuminate\Http\Request;

class LayawayController extends Controller
{
    public function settings(Request $request)
    {
        $this->validate($request, [
            'service_fee' => 'required',
            'down_percentage' => 'required',
            'cancellation_fee' => 'required',
            'price_limit' => 'required',
            'period' => 'required|numeric',
        ]);
        // dd($request->all());
        $data = [
            'service_fee' => $request->service_fee,
            'down_percentage' => $request->down_percentage,
            'cancellation_fee' => $request->cancellation_fee,
            'price_limit' => $request->price_limit,
            'period' => $request->period,
            'extension_limit' => $request->extension_limit,
            'number_of_extension' => $request->number_of_extension,
        ];
        // Update settings
        
        $layawaysettings = LayawaySetting::updateOrCreate(['id' => 1], $data);

        if($layawaysettings){
            return redirect()->back()->with([
                'message', 'Layaway settings updated successfully',
                'alert-type', 'success',
            ]);
        }
        else{
            return redirect()->back()->with([
                'message', 'Layaway settings failed to update',
                'alert-type', 'error',
            ]);
        }
    }
}
