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

            @include('merchant.partials.merchant._profile-sidebar')

            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Personal Information:
                                <small>update your personal information</small>
                            </h3>
                        </div>
                    </div>
                    <form method="POST"
                          action="{{ route('merchant.profile.update') }}"
                          class="kt-form kt-form--label-right"
                          id="kt_profile_form"
                    >
                        @csrf

                        @method('PATCH')

                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="first-name">
                                            First Name
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control @error('first_name') is-invalid @enderror"
                                                   type="text"
                                                   name="first_name"
                                                   id="first-name"
                                                   value="{{ old('first_name', $user->first_name) }}"
                                                   required
                                            >
                                            @error('first_name')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="last-name">
                                            Last Name
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control @error('last_name') is-invalid @enderror"
                                                   type="text"
                                                   value="{{ old('last_name', $user->last_name) }}"
                                                   name="last_name"
                                                   id="last-name"
                                                   required
                                            >
                                            @error('last_name')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="username">
                                            Username
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control @error('username') is-invalid @enderror"
                                                   type="text"
                                                   value="{{ old('username', $user->username) }}"
                                                   required
                                                   name="username"
                                                   id="username"
                                            >
                                            @error('username')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="telephone">
                                            Telephone
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="tel"
                                                       class="form-control @error('telephone') is-invalid @enderror"
                                                       value="{{ old('telephone', $user->telephone) }}"
                                                       placeholder="Phone"
                                                       required
                                                       id="telephone"
                                                       name="telephone"
                                                >
                                                @error('telephone')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label" for="email">
                                            Email Address
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-at"></i>
                                                    </span>
                                                </div>
                                                <input type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email"
                                                       id="email"
                                                       value="{{ old('email', $user->email) }}"
                                                       placeholder="Email"
                                                       required
                                                >
                                                @error('email')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
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

    @include('merchant.partials.merchant._profile-photo-modal')

@endsection
