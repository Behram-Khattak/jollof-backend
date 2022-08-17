@extends('merchant.layouts.master')

@section('title', 'Business Profile | Jollof')

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
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="kt-grid__item kt-grid__item--fluid">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Business Information
                                        </h3>
                                    </div>
                                </div>
                                <form class="kt-form kt-form--label-right"
                                      id="kt_profile_form"
                                      action="{{ route('merchant.business.update', $business) }}"
                                      method="POST"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <div class="kt-portlet__body">
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-section__body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="name">
                                                        Business Name
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input
                                                            class="form-control @error('business_name') is-invalid @enderror"
                                                            type="text"
                                                            name="business_name"
                                                            id="name"
                                                            value="{{ old('business_name', $business->name) }}"
                                                            required
                                                        >
                                                        @error('business_name')
                                                        <x-invalid-feedback message="{{ $message }}"/>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="description">
                                                        Business Description
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <textarea id="description"
                                                                  name="business_description"
                                                                  class="form-control w-100 @error('business_description') is-invalid @enderror"
                                                                  rows="4"
                                                                  required
                                                        >{{ old('business_description', $business->description) }}</textarea>
                                                        @error('business_description')
                                                        <x-invalid-feedback message="{{ $message }}"/>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-xl-3"></label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <h3 class="kt-section__title kt-section__title-sm">
                                                            Contact Info
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="telephone">
                                                        Business Telephone
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-phone"></i>
                                                                </span>
                                                            </div>
                                                            <input type="tel"
                                                                   class="form-control @error('business_phone') is-invalid @enderror"
                                                                   value="{{ old('business_phone', $business->telephone) }}"
                                                                   placeholder="Phone"
                                                                   required
                                                                   id="telephone"
                                                                   name="business_phone"
                                                            >
                                                            @error('business_phone')
                                                            <x-invalid-feedback message="{{ $message }}"/>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="whatsapp">
                                                        Business WhatsApp
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-whatsapp"></i>
                                                                </span>
                                                            </div>
                                                            <input type="tel"
                                                                   class="form-control @error('business_whatsapp') is-invalid @enderror"
                                                                   value="{{ old('business_whatsapp', $business->whatsapp) }}"
                                                                   placeholder="Phone"
                                                                   required
                                                                   id="whatsapp"
                                                                   name="business_whatsapp"
                                                            >
                                                            @error('business_whatsapp')
                                                            <x-invalid-feedback message="{{ $message }}"/>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="email">
                                                        Business E-mail
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            <input type="email"
                                                                   class="form-control @error('business_email') is-invalid @enderror"
                                                                   name="business_email"
                                                                   id="email"
                                                                   value="{{ old('business_email', $business->email) }}"
                                                                   placeholder="Email"
                                                                   required
                                                            >
                                                            @error('business_email')
                                                            <x-invalid-feedback message="{{ $message }}"/>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-xl-3"></label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <h3 class="kt-section__title kt-section__title-sm">
                                                            Payout Info
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="telephone">
                                                        Payout Frequency
                                                    </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group">
                                                            <select class="form-control @error('payout') is-invalid @enderror"
                                                                   required
                                                                   name="payout"
                                                            >
                                                                <option value="Weekly" {{ (!$payout) ? '' : (($payout->frequency == 'Weekly') ? 'selected' : '') }}>Weekly</option>
                                                                <option value="Bi-Weekly" {{ (!$payout) ? '' : (($payout->frequency == 'Bi-Weekly') ? 'selected' : '') }}>Bi-Weekly</option>
                                                                <option value="Monthly" {{ (!$payout) ? '' : (($payout->frequency == 'Monthly') ? 'selected' : '') }}>Monthly</option>
                                                            </select>
                                                            @error('payout')
                                                            <x-invalid-feedback message="{{ $message }}"/>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-3 col-xl-3">
                                                </div>
                                                <div class="col-lg-9 col-xl-9">
                                                    <button type="submit" class="btn btn-success">{{ $text }}</button>&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

{{--                        <div class="kt-grid__item kt-grid__item--fluid">--}}

{{--                            <merchant-welcome-component></merchant-welcome-component>--}}

{{--                        </div>--}}

                    </div>
                </div>
            </div>

            <!-- end:: Content -->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->

    @include('merchant.partials.business._logo-modal')

    @include('merchant.partials.business._banner-modal')
@endsection
