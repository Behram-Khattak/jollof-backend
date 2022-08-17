@extends('admin.layouts.master')

@section('title', 'Create New User | Jollof')

@section('content')

    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                @if (isset($role))
                                    <h3 class="kt-portlet__head-title">Create New {{ ucfirst($role->name) }}</h3>
                                @else
                                    <h3 class="kt-portlet__head-title">Create New User</h3>
                                @endif
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin::Form-->
                            <form method="POST" action="{{ route('admin.users.store') }}" class="kt-form">
                                @csrf

                                @isset($role)

                                    <input type="hidden" name="role" value="{{ $role->name }}">

                                @endisset

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

                                    @isset($role)


                                        @if ($role->name === 'merchant')


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


                                        @endif

                                    @endisset

                                    @isset($roles)

                                        <div class="form-group col-md-6">
                                            <label for="roles">Role(s)</label>

                                            <select id="roles"
                                                    name="roles[]"
                                                    class="form-control kt_selectpicker @error('roles') is-invalid @enderror"
                                                    {{ $roles->count() > 1 ? 'multiple' : '' }}
                                                    required
                                            >
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('roles')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror
                                        </div>

                                    @endisset

                                </div>

                                @isset($role)

                                    @if ($role->name === 'merchant')
                                        <div class="text-capitalize font-weight-bold mt-3">
                                            <p>Business Information</p>
                                            <hr/>
                                        </div>

                                        <div class="form-row">
                                            <b-form-group id="input-group-11" label="Business Type"
                                                          label-for="business-type"
                                                          class="col-md-6">

                                                <select id="business-type"
                                                        name="business_type"
                                                        class="form-control custom-select @error('business_type') is-invalid @enderror"
                                                        required
                                                >
                                                    <option value="" selected disabled>-- Please select an option --
                                                    </option>
                                                    @foreach($businessTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ old('business_type') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('business_type')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                @enderror

                                            </b-form-group>

                                            <b-form-group id="input-group-8" label="Business Name"
                                                          label-for="business-name"
                                                          class="col-md-6">

                                                <b-form-input
                                                    id="business-name"
                                                    name="business_name"
                                                    value="{{ old('business_name') }}"
                                                    :state="{{ $errors->has('business_name') ? 'false' : 'null' }}"
                                                    required
                                                ></b-form-input>

                                                @error('business_name')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                @enderror

                                            </b-form-group>
                                        </div>

                                        <b-form-group id="input-group-9" label="Business Description"
                                                      label-for="business-description">

                                            <b-form-textarea
                                                id="textarea"
                                                name="business_description"
                                                rows="3"
                                                max-rows="6"
                                                :state="{{ $errors->has('business_description') ? 'false' : 'null' }}"
                                                value="{{ old('business_description') }}"
                                                required
                                            ></b-form-textarea>

                                            @error('business_description')
                                            <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                            @enderror

                                        </b-form-group>

                                        <div class="form-row">
                                            <b-form-group id="input-group-19" label="Business Email" label-for="business-email"
                                                          class="col-md-6">

                                                <b-form-input
                                                    id="business-email"
                                                    type="email"
                                                    name="business_email"
                                                    value="{{ old('business_email') }}"
                                                    autocomplete="email"
                                                    :state="{{ $errors->has('business_email') ? 'false' : 'null' }}"
                                                    required
                                                ></b-form-input>

                                                @error('business_email')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                @enderror

                                            </b-form-group>


                                            <b-form-group id="input-group-20" label="Business Phone" label-for="business-phone"
                                                          class="col-md-6">

                                                <b-form-input
                                                    id="business-phone"
                                                    type="tel"
                                                    name="business_phone"
                                                    required
                                                    value="{{ old('business_phone') }}"
                                                    :state="{{ $errors->has('business_phone') ? 'false' : 'null' }}"
                                                    autocomplete="tel"
                                                ></b-form-input>

                                                @error('business_phone')
                                                <x-invalid-feedback message="{{ $message }}"></x-invalid-feedback>
                                                @enderror

                                            </b-form-group>

                                            <b-form-group id="input-group-5" label="Business WhatsApp" label-for="whatsapp"
                                                          class="col-md-6">

                                                <b-form-input
                                                    id="whatsapp"
                                                    type="tel"
                                                    name="whatsapp"
                                                    required
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
                                    @endif

                                @endisset


                                <b-button type="submit" class="btn btn-primary mr-2">
                                    <i class="la la-save"></i>
                                    Create User
                                </b-button>


                            </form>
                            <!--end::Form-->
                        </div>

                    </div>

                    <!--end::Portlet-->
                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>

@endsection

@push('scripts')

    <script>
        // jQuery(document).ready(function () {
        var KTBootstrapSelect = function () {

            // Private functions
            var demos = function () {
                // minimum setup
                $('.kt_selectpicker').selectpicker();
            }

            return {
                // public functions
                init: function () {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTBootstrapSelect.init();
        });
        // });
    </script>

@endpush
