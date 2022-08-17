<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;

class BusinessLocationController extends Controller
{
    public function index(Business $business)
    {
        $states = json_decode(file_get_contents((base_path('nigeria-state-and-lgas.json'))), true);

        $locations = BusinessLocation::whereBusinessId($business->id)->paginate(15);

        return view('merchant.locations.index', [
            'business'  => $business,
            'locations' => $locations,
            'states'    => $states,
        ]);
    }

    public function store(Business $business, Request $request)
    {
        $request->validate([
            'telephone'      => ['nullable', 'string', new PhoneNumber()],
            'whatsapp'       => ['nullable', 'string', new PhoneNumber()],
            'state'          => ['required', 'string'],
            'city'           => ['required', 'string'],
            'area'           => ['nullable', 'string'],
            'address'        => ['required', 'string', 'max:200'],
        ]);

        BusinessLocation::create([
            'business_id' => $business->id,
            'telephone'   => $request->filled('telephone') ? phone($request->input('telephone'), 'NG')->formatE164() : null,
            'whatsapp'    => $request->filled('whatsapp') ? phone($request->input('whatsapp'), 'NG')->formatE164() : null,
            'state'       => $request->input('state'),
            'city'        => $request->input('city'),
            'area'        => $request->input('area'),
            'address'     => $request->input('address'),
        ]);

        return redirect()->route('merchant.business.location.index', $business)->with([
            'alert-type' => 'success',
            'message'    => 'New business location created successfully!',
        ]);
    }
}
