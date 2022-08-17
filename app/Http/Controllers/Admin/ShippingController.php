<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Areas;
use App\Models\Business;
use App\Models\Settings;
use App\Models\SettingType;
use App\Models\ShippingGroup;
use App\Models\States;
use Auth;
use Illuminate\Http\Request;


class ShippingController extends Controller
{

    public function index()
    {
        $states = States::with('areas')->where('status', 'active')->get();
        $vat = SettingType::with('settings')->where('slug', 'vat')->first();

        return view('admin.shipping.index', compact(['states', 'vat']));
    }

    public function state($id)
    {
        $state = States::findOrFail($id);
        $areas = Areas::with('shipping')->where('states_id', $id)->get(); //dd($areas);
        $group = new ShippingGroup;
        return view('admin.shipping.state', compact(['state', 'group', 'areas']));
    }


    public function create($id)
    {
        $group = new ShippingGroup;
        $state = States::with('areas')->whereId($id)->first();
        return view('admin.shipping.create', compact(['group', 'state']));
    }


    public function store(Request $request)
    {

        //validate form
        $data = $request->validate([
            'min_shipment_qty' => 'required|numeric',
            'max_shipment_qty' => 'required|numeric',
            'shipment_price'   => 'required|numeric',
            'areas'            => 'required',
            'areas*'           => 'required',
            'state'            => 'required',
        ]);

        // updateorcreate
        foreach ($data['areas'] as $area) {
            $stateArea = [
                "state_id"  => $data['state'],
                "area_id"   => $area
            ];

            $shipping = [
                "min_shipment_qty"  => $data['min_shipment_qty'],
                "max_shipment_qty"  => $data['max_shipment_qty'],
                "shipment_price"    => $data['shipment_price']
            ];

            ShippingGroup::updateOrCreate($stateArea, $shipping);
        }

        return redirect(route('admin.shipping.state', ['id' => $data['state']]))->with('success', 'Shipping added successfully.');
    }


    public function vat(Request $request)
    {

        //validate form
        $data = $request->validate([
            'vat' => 'required|numeric',
        ]);

        $vatData = SettingType::where('name', 'vat')->first();

        if (!$vatData) {
            $vatSetting = SettingType::create([
                "name" => "VAT"
            ]);

            $setting = new Settings([
                "name" => "VAT",
                "value" => $data['vat']
            ]);

            $vatSetting->settings()->save($setting);
        } else {

            $settingData = $vatData->settings()->first();
            $settingData->update(["value" => $data['vat']]);
        }

        return redirect(route('admin.shipping'))->with('success', 'VAT updated successfully.');
    }
}
