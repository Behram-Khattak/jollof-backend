<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusinessCategories;
use App\Enums\MediaCollectionNames;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $businesses = Business::with('owner', 'type')->latest()->get();
        $types = BusinessType::all();

        return view('admin.business.index', [
            'businesses' => $businesses,
            'types'      => $types,
        ]);
    }

    public function show(Business $business)
    {
        $business->load('locations', 'type', 'owner', 'manager', 'media');

        $types = BusinessType::all();

        return view('admin.business.show', [
            'categories' => BusinessCategories::choices(),
            'business'   => $business,
            'types'      => $types,
            'kyc'        => $business->getMedia(MediaCollectionNames::KYC),
        ]);
    }
}
