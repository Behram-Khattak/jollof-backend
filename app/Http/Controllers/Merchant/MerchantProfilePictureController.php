<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\MediaCollectionNames;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MerchantProfilePictureController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(['avatar' => ['required', 'image', 'max:1024']], [
            'max' => 'The uploaded image should not be greater than 1 megabyte.',
        ]);

        try {
            $request->user()->addMedia($request->file('avatar'))
                ->usingName(md5(auth()->id()))
                ->usingFileName(md5(auth()->id()).'.'.$request->file('avatar')->getClientOriginalExtension())
                ->toMediaCollection(MediaCollectionNames::PROFILE);
        } catch (FileDoesNotExist $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        } catch (FileIsTooBig $e) {
            Log::error($e);

            return response()->json(['data' => ['message' => 'Something went wrong']], 500);
        }

        return response()->json(['data' => auth()->user()]);
    }
}
