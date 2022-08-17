@extends('merchant.layouts.master')

@push('styles')
<link href="https://releases.transloadit.com/uppy/v1.24.0/uppy.min.css" rel="stylesheet">
@endpush

@section('title', config('app.name', 'Laravel'))

@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::App-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

            <!--Begin:: App Aside Mobile Toggle-->
            <button class="kt-app__aside-close" id="kt_profile_aside_close">
                <i class="la la-close"></i>
            </button>

            <!--End:: App Aside Mobile Toggle-->

            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                <!--begin::Portlet-->
            @include('merchant.partials.business._profile-header')

            <!--end::Portlet-->
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane active" id="ky" role="tabpanel" aria-labelledby="kyc-tab">
                        <div class="kt-grid__item kt-grid__item--fluid">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Business KYC
                                        </h3>
                                    </div>
                                </div>

                                @if ($business->bankAccount()->exists())

                                    <kyc-form-component
                                        :business="{{ json_encode($business) }}"
                                        :banks="{{ json_encode($banks) }}"
                                        :kyc="{{ json_encode($kyc) }}"
                                        :categories="{{ json_encode($categories) }}"
                                        :onboard="{{ json_encode($onboard) }}"
                                        route="{{ route('merchant.business.kyc.store', $business) }}"
                                    />
                                @else

                                    <kyc-form-component
                                        :business="{{ json_encode($business) }}"
                                        :banks="{{ json_encode($banks) }}"
                                        :kyc="{{ json_encode($kyc) }}"
                                        :categories="{{ json_encode($categories) }}"
                                        :onboard="{{ json_encode($onboard) }}"
                                        route="{{ route('merchant.business.kyc.store', $business) }}"
                                    />

                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->

    @include('merchant.partials.business._logo-modal')

    @include('merchant.partials.business._banner-modal')

@endsection
