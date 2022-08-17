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
                                            {{ ucfirst($team->name) }} Members
                                        </h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-group">
                                            <button type="button"
                                                    class="btn btn-bold btn-upper btn-outline-success btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#addUser"
                                            >
                                                Add User
                                            </button>
                                            <button type="button"
                                                    class="btn btn-brand btn-sm btn-bold btn-upper"
                                                    data-toggle="modal"
                                                    data-target="#editTeam"
                                            >
                                                Edit Team
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <div class="kt-section__content">

                                                <table class="table">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>E-mail</th>
                                                        <th>Telephone</th>
                                                        <th>Role</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($team->users as $user)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>
                                                                @if (auth()->id() === $user->id)
                                                                    <a href="{{ route('merchant.profile.show') }}">
                                                                        {{ ucwords($user->full_name) }}
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('merchant.teams_members.show', [$team, $user->username]) }}">
                                                                        {{ ucwords($user->full_name) }}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->telephone ?? 'Not Available' }}  </td>
                                                            <td>
                                                                {{ $user->roles->pluck('name')->implode(' | ') }}
                                                            </td>
                                                            <td>
                                                                <span>
                                                                    <span
                                                                        class="kt-badge kt-badge--{{ $user->trashed() ? "danger" : "success" }} kt-badge--bold kt-badge--lg kt-badge--inline kt-badge--pill">
                                                                        @if ($user->trashed())
                                                                            {{ ucfirst('deactivated') }}
                                                                        @else
                                                                            {{ ucfirst('active') }}
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if (auth()->id() !== $user->id)
                                                                    <b-link
                                                                        href="{{ route('merchant.teams_members.show', [$team, $user->username]) }}"
                                                                        class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-info"
                                                                        title="Edit"
                                                                    >
                                                                        <i class="fa fa-pen"></i>
                                                                    </b-link>
                                                                    @if ($user->trashed())
                                                                        <form style="display: inline-block;"
                                                                              action="{{ route('merchant.teams_members.restore', [$team, $user->username])}}"
                                                                              method="post">
                                                                            @csrf

                                                                            @method('PATCH')

                                                                            <button
                                                                                type="submit"
                                                                                class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-success"
                                                                                title="Restore"
                                                                            >
                                                                                <i class="fa fa-sync"></i>
                                                                            </button>

                                                                        </form>

                                                                    @else
                                                                        <form style="display: inline-block;"
                                                                              action="{{ route('merchant.teams_members.destroy', [$team, $user])}}"
                                                                              method="post">
                                                                            @csrf

                                                                            @method('DELETE')

                                                                            <button
                                                                                type="submit"
                                                                                class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger js-delete-trigger"
                                                                                title="Deactivate"
                                                                            >
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>

                                                                        </form>
                                                                    @endif
                                                                @endif

                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                    </tbody>

                                                </table>

                                            </div>
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

    <div class="modal fade"
         id="editTeam"
         tabindex="-1" role="dialog"
         aria-labelledby="editTeamLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="editTeamLabel">Edit Team</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--begin::Form-->
                <div class="modal-body">

                    <form method="POST"
                          action="{{ route('merchant.teams.update', [$business, $team]) }}"
                          class="kt-form">
                        @csrf

                        @method('PATCH')

                        <b-form-group id="input-group-22"
                                      label="Team name"
                                      label-for="name"
                        >

                            <b-form-input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $team->name) }}"
                                required
                                :state="{{ $errors->has('name') ? 'false' : 'null' }}"
                            ></b-form-input>

                            @error('name')
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

    <div class="modal fade"
         id="addUser"
         tabindex="-1" role="dialog"
         aria-labelledby="addUserLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="addUserLabel">Add User</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--begin::Form-->
                <div class="modal-body">

                    <form method="POST" action="{{ route('merchant.teams_members.store', $team) }}"
                          class="kt-form">
                        @csrf

                        <input type="hidden" name="team" value="{{ $team->id }}">

                        <div class="form-row">

                            <b-form-group id="input-group-1" label="First Name" label-for="first-name"
                                          class="col-md-6">

                                <b-form-input
                                    name="first_name"
                                    id="first-name"
                                    value="{{ old('first_name') }}"
                                    :state="{{ $errors->has('first_name') ? 'false' : 'null' }}"
                                    required
                                    autofocus
                                    autocomplete="given-name"
                                ></b-form-input>

                                @error('first_name')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                            <b-form-group id="input-group-2" label="Last Name" label-for="last-name"
                                          class="col-md-6">

                                <b-form-input
                                    name="last_name"
                                    id="last-name"
                                    value="{{ old('last_name') }}"
                                    :state="{{ $errors->has('last_name') ? 'false' : 'null' }}"
                                    required
                                    autocomplete="family-name"
                                ></b-form-input>

                                @error('last_name')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                        </div>

                        <div class="form-row">

                            <b-form-group id="input-group-3" label="Username" label-for="username"
                                          class="col-md-6">

                                <b-form-input
                                    name="username"
                                    id="username"
                                    value="{{ old('username') }}"
                                    :state="{{ $errors->has('username') ? 'false' : 'null' }}"
                                    required
                                    autocomplete="username"
                                ></b-form-input>

                                @error('username')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                            <b-form-group id="input-group-4" label="Email" label-for="email" class="col-md-6">

                                <b-form-input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    :state="{{ $errors->has('email') ? 'false' : 'null' }}"
                                    required
                                    autocomplete="email"
                                ></b-form-input>

                                @error('email')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                        </div>

                        <div class="form-row">

                            <b-form-group id="input-group-5" label="Phone Number" label-for="telephone"
                                          class="col-md-6">

                                <b-form-input
                                    id="telephone"
                                    type="tel"
                                    name="telephone"
                                    required
                                    value="{{ old('telephone') }}"
                                    :state="{{ $errors->has('telephone') ? 'false' : 'null' }}"
                                    autocomplete="tel"
                                ></b-form-input>

                                @error('telephone')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                            <div class="form-group col-md-6">
                                <label for="role">Role</label>

                                <select id="role"
                                        name="role"
                                        class="form-control kt_selectpicker @error('roles') is-invalid @enderror"
                                        required
                                >
                                    <option value="" selected disabled hidden>-- Please select an option --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->name ? 'selected' : '' }}
                                        >
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror
                            </div>

                        </div>
                        <div class="form-row">

                            <b-form-group id="input-group-6" label="Password" label-for="password" class="col-md-6">

                                <b-form-input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    :state="{{ $errors->has('password') ? 'false' : 'null' }}"
                                    required
                                ></b-form-input>

                                @error('password')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                            <b-form-group id="input-group-7" label="Confirm Password" label-for="password-confirm"
                                          class="col-md-6">

                                <b-form-input
                                    id="password-confirm"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    :state="{{ $errors->has('password_confirmation') ? 'false' : 'null' }}"
                                    required
                                ></b-form-input>

                                @error('password_confirmation')
                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                @enderror

                            </b-form-group>

                        </div>

                        <b-button type="submit" class="btn btn-success mr-2">
                            Submit
                        </b-button>

                    </form>

                    <!--end::Form-->
                </div>

            </div>
        </div>
    </div>

    @include('merchant.partials.business._logo-modal')

    @include('merchant.partials.business._banner-modal')

@endsection
