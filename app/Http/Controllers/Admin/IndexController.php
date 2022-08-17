<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function reviews()
    {
        // Get all reviews
        $reviews = Review::with('user')->latest()->paginate(10);
        // return $reviews[0];
        return view('admin.review', compact(['reviews']));
    }
    public function deleteReview($id)
    {
        $review = Review::find($id);
        $review->delete();
        return redirect()->back()->with([
            'message'    => 'Review deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
