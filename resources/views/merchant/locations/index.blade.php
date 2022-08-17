@extends('merchant.layouts.master')

@section('title', 'Business Locations | Jollof')

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
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="location-tab">

                        <div class="kt-grid__item kt-grid__item--fluid">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            {{ $business->name }} Locations
                                        </h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-group">
                                            <button type="button" class="btn btn-brand btn-sm btn-bold btn-upper"
                                                    data-toggle="modal" data-target="#exampleModal">
                                                Add New Location
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">

                                    <!--begin::Section-->
                                    <div class="kt-section">
                                        <div class="kt-section__content">
                                            <div class="table-responsive">
                                                <table class="table table-head-noborder table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Address</th>
                                                        <th>City</th>
                                                        <th>State</th>
                                                        <th>Telephone</th>
                                                        <th>WhatsApp</th>
                                                        <th>HQ</th>
{{--                                                        <th>Actions</th>--}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($locations as $location)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $location->address }}</td>
                                                            <td>{{ $location->area }}, {{ $location->city }}</td>
                                                            <td>{{ $location->state }}</td>
                                                            <td>{{ $location->telephone }}</td>
                                                            <td>{{ $location->whatsapp }}</td>
                                                            <td>
                                                    <span>
                                                        <span
                                                            class="kt-badge kt-badge--{{ $location->default ? "brand" : "danger" }} kt-badge--bold kt-badge--lg kt-badge--inline kt-badge--pill">
                                                            {{ $location->default ? 'True' : 'False' }}
                                                        </span>
                                                    </span>
                                                            </td>
{{--                                                            <td>--}}
{{--                                                    <span>--}}
{{--                                                        <span--}}
{{--                                                            class="kt-badge kt-badge--{{ $location->default ? "brand" : "danger" }} kt-badge--bold kt-badge--lg kt-badge--inline kt-badge--pill">--}}
{{--                                                            {{ $location->default ? 'True' : 'False' }}--}}
{{--                                                        </span>--}}
{{--                                                    </span>--}}
{{--                                                            </td>--}}
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <a href="{{ route('merchant.teams.index', $business) }}" class="btn btn-success float-right">Next</a>&nbsp;


                                        <div class="float-right mt-5">
                                            {{ $locations->links() }}
                                        </div>


                                    </div>
                                </div>

                                <!--end::Form-->
                            </div>

                        </div>

                    </div>


                </div>
            </div>

            <!--End:: App Content-->

            <!--End:: App Aside-->

            <!--Begin:: App Content-->

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->

    <div class="modal fade"
         id="exampleModal"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Create New Business Location</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--begin::Form-->
                <div class="modal-body">

                    <form method="POST" action="{{ route('merchant.business.location.store', $business) }}"
                          class="kt-form">
                        @csrf

                        <div class="form-row">

                            <b-form-group id="input-group-20" label="Location Telephone"
                                          label-for="telephone"
                                          class="col-md-6">

                                <b-form-input
                                    id="telephone"
                                    type="tel"
                                    name="telephone"
                                    value="{{ old('telephone') }}"
                                    :state="{{ $errors->has('telephone') ? 'false' : 'null' }}"
                                    autocomplete="tel"
                                ></b-form-input>

                                @error('telephone')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                            <b-form-group id="input-group-20" label="Location WhatsApp"
                                          label-for="whatsapp"
                                          class="col-md-6">

                                <b-form-input
                                    id="whatsapp"
                                    type="tel"
                                    name="whatsapp"
                                    value="{{ old('whatsapp') }}"
                                    :state="{{ $errors->has('whatsapp') ? 'false' : 'null' }}"
                                    autocomplete="tel"
                                ></b-form-input>

                                @error('whatsapp')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                        </div>

                        <state-lga-select
                            :state-prop="{{ json_encode($states)}}"
                            old-state="{{ old('state') }}"
                            state-error="{{ $errors->first('state') }}"
                            old-lga="{{ old('city') }}"
                            lga-error="{{ $errors->first('city') }}"
                        ></state-lga-select>

                        <b-form-group id="input-group-10" label="Address" label-for="address">

                            <b-form-input
                                id="address"
                                name="address"
                                value="{{ old('address') }}"
                                :state="{{ $errors->has('address') ? 'false' : 'null' }}"
                                required
                                autocomplete="street-address"
                            ></b-form-input>

                            @error('address')
                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                            @enderror

                        </b-form-group>

                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

    @include('merchant.partials.business._logo-modal')

    @include('merchant.partials.business._banner-modal')
@endsection
