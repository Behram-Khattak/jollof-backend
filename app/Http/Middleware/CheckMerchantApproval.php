<?php

namespace App\Http\Middleware;

use Closure;

class CheckMerchantApproval
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->kyc_upload) {
            return redirect()->route('merchant.kyc.create')->with([
                'message'    => 'Upload KYC document to unlock other application features!',
                'alert-type' => 'info',
            ]);
        }

        return $next($request);
    }
}
