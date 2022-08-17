<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\MediaCollectionNames;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\OnboardingFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class BusinessImageController extends Controller
{
    public function logo(Business $business, Request $request)
    {
        $request->validate(['avatar' => ['required', 'image', 'max:1024']], [
            'max' => 'The uploaded image should not be greater than 1 megabyte.',
        ]);

        try {
            $business->addMedia($request->file('avatar'))
                ->usingName(md5($business->id))
                ->usingFileName(md5($business->id).'.'.$request->file('avatar')->getClientOriginalExtension())
                ->toMediaCollection(MediaCollectionNames::LOGO);
        } catch (FileDoesNotExist $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        } catch (FileIsTooBig $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        }

        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $onboard->update(['logo' => true]);

        return response()->json(['data' => auth()->user()]);
    }

    public function banner(Business $business, Request $request)
    {
        $request->validate(['avatar' => ['required', 'image', 'max:1024']], [
            'max' => 'The uploaded image should not be greater than 1 megabyte.',
        ]);

        try {
            $business->addMedia($request->file('avatar'))
                ->usingName(md5($business->id))
                ->usingFileName(md5($business->id).'.'.$request->file('avatar')->getClientOriginalExtension())
                ->toMediaCollection(MediaCollectionNames::BANNER);
        } catch (FileDoesNotExist $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        } catch (FileIsTooBig $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        }

        $onboard = OnboardingFlow::whereBusinessId($business->id)->first();

        $onboard->update(['banner' => true]);

        return response()->json(['data' => auth()->user()]);
    }
}
