<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusinessStates;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Notifications\BusinessApprovedNotification;
use App\Notifications\BusinessDeclinedNotification;
use App\Notifications\WhatsappBusinessAppprovedNotification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusinessReviewController extends Controller
{
    /**
     * Get all businesses pending approval.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $businesses = Business::with('owner')
            ->where('status', BusinessStates::PENDING)
            ->where('kyc_upload', true)
            ->get();

        return view('admin.business.pending', compact('businesses'));
    }

    /**
     * Approve the business.
     *
     * @param Business $business
     *
     * @return RedirectResponse
     */
    public function approve(Business $business)
    {
        $business->update(['status' => BusinessStates::APPROVED]);
        if ($business->owner) {
            $business->owner->notify(new BusinessApprovedNotification($business));
        } else {
            $business->load('manager');
            $business->manager->notify(new BusinessApprovedNotification($business));
        }
        //$business->notify(new WhatsappBusinessAppprovedNotification());

        return redirect()->back()->with([
            'message'    => 'Business approved successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Decline a business request.
     *
     * @param Business $business
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function decline(Business $business, Request $request)
    {
        $request->validate(['comment' => ['nullable', 'string', 'max:250']]);

        $comment = $request->input('comment');
        $business->update([
            'status'  => BusinessStates::DECLINED,
            'comment' => $comment,
        ]);

        if ($business->owner) {
            $business->owner->notify(new BusinessDeclinedNotification($business, $comment));
        } else {
            $business->load('manager');
            $business->manager->notify(new BusinessDeclinedNotification($business, $comment));
        }

        return redirect()->back()->with([
            'message'    => 'Business declined successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Approve the business.
     *
     * @param Business $business
     *
     * @return RedirectResponse
     */
    public function unapprove(Business $business)
    {
        $business->update(['status' => BusinessStates::PENDING]);

        //$business->notify(new WhatsappBusinessAppprovedNotification());

        return redirect()->back()->with([
            'message'    => 'Business unapproved successfully!',
            'alert-type' => 'success',
        ]);
    }
}
