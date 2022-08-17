@extends('merchant.layouts.master')

@section('title', config('app.name', 'Laravel'))

@section('content')
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
                                            {{ $business->name }} Teams
                                        </h3>
                                    </div>
                                    @if ($locations->count() > 0 )
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="kt-portlet__head-group">
                                                <button type="button" class="btn btn-brand btn-sm btn-bold btn-upper"
                                                        data-toggle="modal" data-target="#exampleModal"
                                                >
                                                    New Team
                                                </button>
                                            </div>
                                        </div>
                                    @endif
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
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Location</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($teams as $team)
                                                        <tr>
                                                            <th scope="row">
                                                                {{ $loop->iteration }}
                                                            </th>
                                                            <td>
                                                                {{ $team->name }}
                                                            </td>
                                                            <td>
                                                                @if(auth()->user()->isOwnerOfTeam($team))
                                                                    <span class="label label-success">Owner</span>
                                                                @else
                                                                    <span class="label label-primary">Member</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $team->location->address }}
                                                            </td>
                                                            <td>
                                                                @if(auth()->user()->isOwnerOfTeam($team))
                                                                    <a href="{{ route('merchant.teams.show', [$business, $team]) }}"
                                                                       class="btn btn-sm btn-outline-success">
                                                                        View Team
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#businessLogo"
                                           class="btn btn-success float-right"
                                        >
                                            Next
                                        </a>&nbsp;


                                        <div class="float-right mt-5">
                                            {{ $teams->links() }}
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end:: Content -->
        </div>

        <!--End::App-->
    </div>
    @if($locations->count() > 0)

        <div class="modal fade"
             id="exampleModal"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Create New Team</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--begin::Form-->
                    <div class="modal-body">

                        <form method="POST" action="{{ route('merchant.teams.store', $business) }}"
                              class="kt-form">
                            @csrf

                            <div class="form-row">

                                <b-form-group id="input-group-22"
                                              label="Team name"
                                              label-for="name"
                                              class="col-md-6">

                                    <b-form-input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        :state="{{ $errors->has('name') ? 'false' : 'null' }}"
                                    ></b-form-input>

                                    @error('name')
                                    <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                    @enderror

                                </b-form-group>

                                <b-form-group id="input-group-20"
                                              label="Team Location"
                                              label-for="location"
                                              class="col-md-6">

                                    <b-form-select id="location"
                                                   name="location"
                                                   required
                                                   class="form-control custom-select"
                                                   :state="{{ $errors->has('location') ? 'false' : 'null' }}"
                                    >
                                        <template v-slot:first>
                                            <b-form-select-option :value="null" disabled>-- Please select an option --
                                            </b-form-select-option>
                                        </template>

                                        @foreach($locations as $location)

                                            <b-form-select-option value="{{ $location->id }}">
                                                {{ $location->address }}
                                            </b-form-select-option>
                                        @endforeach

                                    </b-form-select>

                                    @error('location')
                                    <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                    @enderror

                                </b-form-group>

                            </div>

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

    @endif

    @include('merchant.partials.business._logo-modal')

    @include('merchant.partials.business._banner-modal')


@endsection
