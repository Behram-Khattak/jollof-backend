<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\BusinessTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessType;
use App\Models\OnboardingFlow;
use App\Models\Payout;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\BusinessReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use libphonenumber\PhoneNumberFormat;

class BusinessController extends Controller
{
    public function create(Request $request)
    {
        $states = json_decode(file_get_contents((base_path('nigeria-state-and-lgas.json'))), true);

        return view('merchant.business.create', [
            'states' => $states,
            'types'  => BusinessType::all(['id', 'name'])->sortBy('name'),
        ]);
    }

    public function store(CreateBusinessRequest $request)
    {
        $business = Business::create([
            'owner_id'         => auth()->id(),
            'business_type_id' => $request->input('business_type'),
            'name'             => $request->input('business_name'),
            'email'            => $request->input('business_email'),
            'telephone'        => phone($request->input('business_phone'), 'NG', PhoneNumberFormat::E164),
            'whatsapp'         => phone($request->input('business_whatsapp'), 'NG', PhoneNumberFormat::E164),
            'description'      => $request->input('business_description'),
        ]);

        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'state'       => $request->input('state'),
            'city'        => $request->input('city'),
            'area'        => $request->input('area'),
            'address'     => $request->input('address'),
            'default'     => true,
        ]);

        if (checkMicrosite($business->id,  'Cuisine')) {
            Restaurant::create([
                'business_id' => $business->id,
                'business_location_id' => $location->id,
            ]);
        }

        return redirect()->route('merchant.business.show', $business)->with([
            'alert-type' => 'success',
            'message'    => 'Business created successfully!',
        ]);
    }

    public function show(Business $business)
    {
        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $text = $onboard->profile ? 'Submit' : 'Next';

        $business->load('locations', 'type');

        $payout = Payout::where('business_id', $business->id)->first();
        if(!$payout){
            $nextPayout = date('Y-m-d', strtotime('+ 30 days'));
                $payoutData = [
                    'frequency' => 'Monthly',
                    'next_payout' => $nextPayout,
                    'business_id' => $business->id,
                ];

                Payout::updateOrCreate(
                    ['business_id' => $business->id],
                    $payoutData
                );
        }

        return view('merchant.business.show', compact(['business', 'text', 'payout']));
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $business->update([
            'name'        => $request->input('business_name'),
            'email'       => $request->input('business_email'),
            'telephone'   => phone($request->input('business_phone'), 'NG')->formatE164(),
            'whatsapp'    => phone($request->input('business_whatsapp'), 'NG')->formatE164(),
            'description' => $request->input('business_description'),
        ]);

        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $frequency = $request->input('payout');
        $frequencyDays = ($frequency == "Weekly") ? 7 : (($frequency == 'Bi-Weekly') ? 14 : 30);
        $nextPayout = date('Y-m-d', strtotime('+ '.$frequencyDays.' days'));
        $payoutData = [
            'frequency' => $frequency,
            'next_payout' => $nextPayout,
            'business_id' => $business->id,
        ];

        Payout::updateOrCreate(
            ['business_id' => $business->id],
            $payoutData
        );

        if ($onboard->profile) {
            return redirect()->back()->with([
                'alert-type' => 'success',
                'message'    => 'Business information updated successfully!',
            ]);
        }
        $onboard->update(['profile' => true]);

        return redirect()->route('merchant.business.kyc.create', $business)->with([
            'alert-type' => 'success',
            'message'    => 'Business information updated successfully!',
        ]);
    }

    public function requestApproval(Request $request, Business $business)
    {
        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $onboard->update(['completed' => true]);

        $admins = User::role('admin')->get();

        Notification::send($admins, new BusinessReviewRequest($business));

        if ($business->type->name == BusinessTypeEnum::FASHION) {
            return redirect()->route('merchant.fashion.create', $business);
        }

        return redirect()->route('merchant.restaurants', $business);
    }
}
