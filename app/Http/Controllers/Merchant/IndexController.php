<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Review;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $businesses = Business::with(['type', 'locations' => function ($query) {
            $query->where('default', true);
        }])
            ->where('owner_id', auth()->id())
            ->orWhere('manager_id', auth()->id())
            ->get();

        return view('merchant.index', ['businesses' => $businesses]);
    }

    public function review(Business $business)
    {
        $type = BusinessType::where('id',$business->business_type_id)->first();
        $reviews = Review::with('order')->where('model_type', $type->name)
            ->where('business_id',$business->id)
            ->latest()->paginate(10);
        // return $reviews;

        return view('merchant.review', compact(['reviews','business']));
    }
}
