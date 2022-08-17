@extends('merchant.layouts.master')

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

            <!--Begin:: App Aside-->
            @include('merchant.partials.merchant._settings-sidebar')

            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Change Password:
                                <small>change your account password</small>
                            </h3>
                        </div>
                    </div>
                    <form method="POST"
                          action="{{ route('merchant.password.update') }}"
                          class="kt-form kt-form--label-right"
                          id="kt_profile_form"
                    >
                        @csrf
                        @method('PATCH')
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div
                                        class="alert alert-solid-info alert-bold fade show kt-margin-t-20 kt-margin-b-40"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="fa fa-exclamation-triangle"></i></div>
                                        <div class="alert-text">
                                            You will be logged out after a successful password change
                                        </div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="la la-close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="current-password">Current
                                            Password</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   class="form-control @error('current_password') is-invalid @enderror"
                                                   id="current-password"
                                                   name="current_password"
                                                   placeholder="Current password"
                                            >
                                            @error('current_password')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="new-password">New
                                            Password</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   class="form-control @error('new_password') is-invalid @enderror"
                                                   id="new-password"
                                                   name="new_password"
                                                   placeholder="New password"
                                            >
                                            @error('new_password')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="verify-password">Verify
                                            Password</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   class="form-control @error('verify_password') is-invalid @enderror"
                                                   id="verify-password"
                                                   name="verify_password"
                                                   placeholder="Verify password"
                                            >
                                            @error('verify_password')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
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
                                        <button type="submit" class="btn btn-success">Submit</button>&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->

@endsection
